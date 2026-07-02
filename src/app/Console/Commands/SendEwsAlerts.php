<?php

namespace App\Console\Commands;

use App\Mail\EwsAlertMail;
use App\Models\PreProductionPlan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendEwsAlerts extends Command
{
    protected $signature   = 'app:send-ews-alerts';
    protected $description = 'Radar EWS — scan cuaca tiap jam, kirim alert jika ada anomali ekstrem';

    public function handle(): void
    {
        $this->info('Memindai radar anomali cuaca untuk EWS...');

        /*
         * Ambil semua plan aktif dengan relasi yang dibutuhkan untuk email.
         * Satu user bisa punya banyak plan/lahan — setiap lahan dicek sendiri-sendiri
         * karena koordinat cuacanya bisa berbeda (lahan di kota berbeda misalnya).
         */
        $plans = PreProductionPlan::with(['user', 'lahan', 'commodityType'])
            ->where('is_active', true)
            ->get();

        $this->info("Total plan aktif yang akan discan: {$plans->count()}");

        foreach ($plans as $plan) {
            if (! $plan->user || ! $plan->lahan) {
                continue;
            }

            $lat = (float) ($plan->lahan->weather_latitude  ?? -6.2088);
            $lon = (float) ($plan->lahan->weather_longitude ?? 106.8456);

            $this->line("  → Scanning: [{$plan->lahan->nama_lahan}] — lat:{$lat}, lon:{$lon}");

            try {
                $response = Http::timeout(15)->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude'    => $lat,
                    'longitude'   => $lon,
                    'daily'       => 'weathercode,temperature_2m_max,windspeed_10m_max,relative_humidity_2m_max',
                    'timezone'    => 'auto',
                ]);

                if (! $response->successful()) {
                    $this->warn("  ⚠ API gagal untuk plan #{$plan->id}");
                    continue;
                }

                $daily = $response->json('daily') ?? [];

                // Analisis ancaman dan tentukan apakah perlu kirim alert
                $threat = $this->analyzeThreats($daily, $plan->commodityType?->name ?? '');

                if ($threat['is_extreme']) {
                    Mail::to($plan->user->email)
                        ->send(new EwsAlertMail($plan, $threat['threat_name'], $threat['recommendation']));

                    $this->info("  🚨 ALERT dikirim ke: {$plan->user->email} — {$threat['threat_name']}");
                } else {
                    $this->line("  ✅ Aman — tidak ada ancaman ekstrem untuk lahan ini.");
                }

            } catch (\Exception $e) {
                $this->warn("  ⚠ Error scan plan #{$plan->id}: {$e->getMessage()}");
            }
        }

        $this->info('Pemindaian EWS selesai.');
    }

    /**
     * Analisis data cuaca ramalan dan deteksi ancaman ekstrem.
     * Return array dengan flag is_extreme, nama ancaman, dan rekomendasi.
     *
     * Urutan prioritas: Badai > Angin > Hujan beruntun > Panas ekstrem > Kelembapan tinggi
     */
    private function analyzeThreats(array $daily, string $commodityName): array
    {
        $codes    = $daily['weathercode']              ?? [];
        $temps    = $daily['temperature_2m_max']       ?? [];
        $winds    = $daily['windspeed_10m_max']        ?? [];
        $humids   = $daily['relative_humidity_2m_max'] ?? [];

        $todayCode    = (int)   ($codes[0]  ?? 0);
        $todayMaxTemp = (float) ($temps[0]  ?? 0);
        $todayMaxWind = (float) ($winds[0]  ?? 0);
        $todayHumid   = (float) ($humids[0] ?? 0);

        // Ambil 3 hari untuk deteksi hujan beruntun
        $rainDays3 = count(array_filter(
            array_slice($codes, 0, 3),
            fn ($c) => (int) $c >= 61
        ));

        // -----------------------------------------------------------------
        // LEVEL 1: Badai Petir (Kode >= 95) — BAHAYA TERTINGGI
        // -----------------------------------------------------------------
        if ($todayCode >= 95) {
            return [
                'is_extreme'     => true,
                'threat_name'    => 'Badai Petir & Hujan Sangat Lebat Terdeteksi Hari Ini',
                'recommendation' => 'Hentikan SELURUH aktivitas lapangan segera. Pastikan saluran drainase terbuka maksimal agar lahan tidak banjir. Amankan semua peralatan listrik, alat semprot, dan jangan berada di bawah pohon tinggi.',
            ];
        }

        // -----------------------------------------------------------------
        // LEVEL 2: Angin Kencang Ekstrem (> 35 km/h)
        // -----------------------------------------------------------------
        if ($todayMaxWind > 35) {
            return [
                'is_extreme'     => true,
                'threat_name'    => "Angin Kencang Ekstrem Terdeteksi ({$todayMaxWind} km/h)",
                'recommendation' => 'Pasang ajir/penyangga tambahan pada tanaman yang rentan patah. DILARANG melakukan penyemprotan bahan kimia apapun hari ini karena risiko drift (bahan kimia terbawa angin ke lahan lain). Amankan paranet atau naungan yang mungkin terbang.',
            ];
        }

        // -----------------------------------------------------------------
        // LEVEL 3: Hujan Beruntun 3 Hari Berturut-turut
        // -----------------------------------------------------------------
        if ($rainDays3 >= 3) {
            return [
                'is_extreme'     => true,
                'threat_name'    => 'Prediksi Hujan Lebat Beruntun Selama 3 Hari',
                'recommendation' => 'Tunda semua jadwal pemupukan karena pupuk akan hanyut sia-sia. Waspadai serangan patogen jamur (antraknosa, hawar daun) akibat kelembapan terus-menerus tinggi. Siapkan fungisida sistemik dan pastikan saluran drainase tidak tersumbat.',
            ];
        }

        // -----------------------------------------------------------------
        // LEVEL 4: Suhu Panas Ekstrem (>= 36°C)
        // -----------------------------------------------------------------
        if ($todayMaxTemp >= 36) {
            return [
                'is_extreme'     => true,
                'threat_name'    => "Gelombang Panas Ekstrem ({$todayMaxTemp}°C)",
                'recommendation' => 'Risiko tanaman layu akibat stres kekeringan sangat tinggi. Lakukan penyiraman 2x lipat dari biasanya — pagi dan sore hari. Hindari pemupukan daun di siang bolong. Pasang mulsa atau naungan sementara jika memungkinkan.',
            ];
        }

        // -----------------------------------------------------------------
        // LEVEL 5: Kelembapan Sangat Tinggi + Cuaca Tidak Hujan
        // (Kondisi ideal penyebaran jamur & bakteri)
        // -----------------------------------------------------------------
        if ($todayHumid >= 90 && $todayCode < 61) {
            return [
                'is_extreme'     => true,
                'threat_name'    => "Kelembapan Sangat Tinggi ({$todayHumid}%) — Risiko Jamur & Patogen",
                'recommendation' => 'Kelembapan ekstrem tanpa hujan adalah kondisi paling ideal bagi penyebaran spora jamur dan bakteri daun. Lakukan inspeksi visual pada daun dan buah pagi ini. Pertimbangkan penyemprotan fungisida preventif sebelum siang.',
            ];
        }

        // Tidak ada ancaman ekstrem
        return [
            'is_extreme'     => false,
            'threat_name'    => '',
            'recommendation' => '',
        ];
    }
}