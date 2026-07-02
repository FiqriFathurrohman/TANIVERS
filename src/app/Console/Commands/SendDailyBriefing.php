<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PreProductionPlan;
use App\Services\SmartTaskService;
use App\Mail\DailyMorningBriefing;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class SendDailyBriefing extends Command
{
    protected $signature = 'app:send-daily-briefing';
    protected $description = 'Kirim email morning briefing ke semua petani aktif';

    public function handle(SmartTaskService $taskService)
    {
        $this->info("Memulai pengiriman Morning Briefing...");

        // Ambil semua rencana tanam yang aktif
        $plans = PreProductionPlan::with(['user', 'lahan', 'commodityType'])
            ->where('is_active', true)
            ->get();

        foreach ($plans as $plan) {
            if (!$plan->user || !$plan->lahan) continue;

            // 1. Tembak API Cuaca Open-Meteo dari Backend
            $lat = $plan->lahan->weather_latitude ?? -6.2088;
            $lon = $plan->lahan->weather_longitude ?? 106.8456;
            
            $weatherApi = Http::get("https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&daily=weathercode,temperature_2m_max,windspeed_10m_max&timezone=auto");
            
            $weatherData = [
                'condition' => 'Berawan',
                'max_temp' => '30',
                'recommendation' => 'Kondisi lingkungan aman untuk aktivitas rutin.'
            ];

            if ($weatherApi->successful()) {
                $daily = $weatherApi->json('daily');
                $code = $daily['weathercode'][0] ?? 0;
                $temp = $daily['temperature_2m_max'][0] ?? 30;
                
                // Terjemahan cuaca sederhana
                if ($code <= 3) $weatherData['condition'] = 'Cerah Berawan';
                elseif ($code >= 51 && $code <= 65) $weatherData['condition'] = 'Hujan / Gerimis';
                elseif ($code >= 95) $weatherData['condition'] = 'Badai Petir';

                $weatherData['max_temp'] = $temp;

                if ($code >= 61) $weatherData['recommendation'] = "Tunda penyemprotan bahan kimia karena potensi hujan turun.";
                elseif ($temp >= 35) $weatherData['recommendation'] = "Suhu ekstrem. Pastikan penyiraman maksimal hari ini.";
                else $weatherData['recommendation'] = "Sangat baik untuk aktivitas pemupukan dan penyemprotan.";
            }

            // 2. Ambil To-Do List hari ini dari Smart Task Service
            $taskData = $taskService->generateDailyTasks($plan);

            // 3. EWS Sederhana berbasis cuaca
            $ewsData = [
                'status' => 'Aman',
                'message' => 'Tidak ada ancaman cuaca atau hama signifikan yang terdeteksi.'
            ];

            if (($daily['weathercode'][0] ?? 0) >= 61 && ($daily['weathercode'][1] ?? 0) >= 61) {
                $ewsData = [
                    'status' => 'Waspada',
                    'message' => 'Hujan diprediksi berturut-turut. Waspadai genangan air dan penyebaran jamur/patogen daun.'
                ];
            } elseif (($daily['windspeed_10m_max'][0] ?? 0) > 25) {
                $ewsData = [
                    'status' => 'Bahaya',
                    'message' => 'Angin kencang. Hindari penyemprotan karena risiko terbawa angin (drift).'
                ];
            }

            // 4. Kirim Emailnya!
            Mail::to($plan->user->email)->send(new DailyMorningBriefing($plan, $weatherData, $taskData, $ewsData));
            
            $this->info("Email terkirim ke: " . $plan->user->email);
        }

        $this->info("Pengiriman selesai!");
    }
}