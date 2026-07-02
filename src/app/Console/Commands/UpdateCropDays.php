<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PreProductionPlan;
use App\Mail\MilestonePhaseMail;
use Illuminate\Support\Facades\Mail;

class UpdateCropDays extends Command
{
    protected $signature = 'app:update-crop-days';
    protected $description = 'Naikkan hari tanam otomatis jam 00:00 dan deteksi pergantian fase';

    public function handle()
    {
        $this->info("Memulai proses update hari tanam otomatis...");

        // Ambil semua rencana produksi yang masih aktif berjalan
        $plans = PreProductionPlan::with(['user', 'lahan', 'commodityType', 'plantingGuide.phases'])
            ->where('is_active', true)
            ->get();

        foreach ($plans as $plan) {
            if (!$plan->user || !$plan->plantingGuide) continue;

            // Jaring pengaman: jika sudah mentok durasi tanam, jangan di-increment lagi
            if ((int)$plan->current_day >= (int)$plan->duration_days) {
                continue;
            }

            // Hitung target hari esok
            $nextDay = (int)$plan->current_day + 1;

            // Ambil daftar semua fase untuk panduan tanam komoditas ini
            $phases = $plan->plantingGuide->phases;

            // Cari tahu apakah hari esok adalah hari pembuka (start_day) suatu fase baru
            $matchingPhase = $phases->first(function ($phase) use ($nextDay) {
                return (int)$phase->start_day === $nextDay;
            });

            // JIKA COCOK (PINDAH FASE), TEMBAK EMAIL PERAYAAN!
            if ($matchingPhase) {
                $phaseName = $matchingPhase->name;
                $focusText = $this->generateAiFocusText($phaseName);

                // Kirim email milestone menggunakan mailable perayaan
                Mail::to($plan->user->email)->send(new MilestonePhaseMail($plan, $phaseName, $focusText));
                $this->info("🎉 Milestone! Email fase [{$phaseName}] terkirim ke: " . $plan->user->email);
            }

            // Update hari tanam naik 1 angka di database
            $plan->update([
                'current_day' => $nextDay
            ]);
        }

        $this->info("Proses update hari tanam selesai!");
    }

    /**
     * Algoritma AI Advisor penentu fokus utama berdasarkan nama fase di database admin.
     */
    private function generateAiFocusText(string $phaseName): string
    {
        $name = strtolower($phaseName);

        if (str_contains($name, 'penyemaian') || str_contains($name, 'seeding') || str_contains($name, 'semai')) {
            return "Fokus utama pada fase ini adalah menjaga kelembapan media semai dan melindunginya dari paparan sinar matahari terik langsung. Pastikan drainase wadah semai lancar agar benih tidak busuk.";
        }
        
        if (str_contains($name, 'vegetatif') || str_contains($name, 'tumbuh') || str_contains($name, 'penyiaman')) {
            return "Fokus utama pada fase vegetatif adalah pembentukan struktur daun, ranting, dan batang yang kokoh. Maksimalkan asupan unsur Nitrogen (N) tinggi, lakukan penyiraman berkala tiap pagi, dan amati potensi serangan kutu daun daun muda.";
        }

        if (str_contains($name, 'generatif') || str_contains($name, 'bunga') || str_contains($name, 'buah')) {
            return "Di fase generatif ini, fokus utama Anda wajib dialihkan untuk merangsang pembungaan kuat dan mencegah kerontokan bakal buah. Kurangi drastis pupuk dengan unsur Nitrogen (N), lalu perbanyak asupan unsur Fosfor (P) dan Kalium (K) tinggi.";
        }

        if (str_contains($name, 'pematangan') || str_contains($name, 'matang')) {
            return "Fokus pada pengisian bobot buah dan pembentukan rasa/warna maksimal. Jaga stabilitas kadar air tanah (jangan terlalu becek agar buah tidak pecah) dan berikan asupan kalsium serta kalium dosis akhir.";
        }

        if (str_contains($name, 'panen') || str_contains($name, 'harvest')) {
            return "Selamat, saatnya memetik hasil jerih payah Anda! Lakukan pemanenan hanya pada pagi hari saat kondisi komoditas dalam kondisi paling segar. Gunakan alat potong tajam agar luka pada tanaman induk tidak mengundang penyakit.";
        }

        // Teks fallback standar jika admin menginput nama fase kustom/unik
        return "Tanaman memasuki fase penyesuaian fungsional yang baru. Lakukan monitoring intensif terhadap kecukupan nutrisi makro-mikro, jaga sanitasi kebersihan area sekitar piringan lahan, dan amati siklus perkembangan fisik harian tanaman.";
    }
}