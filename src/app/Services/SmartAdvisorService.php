<?php

namespace App\Services;

use App\Models\PreProductionPlan;

class SmartAdvisorService
{
    public function generateAdvice(PreProductionPlan $plan, array $weatherData): array
    {
        // 1. Ambil informasi komoditas dan hari tanam saat ini
        $commodityName = strtolower($plan->commodityType?->name ?? '');
        $currentDay = $plan->current_day;

        // 2. Ambil parameter cuaca hari ini dari Open-Meteo (dikirim via frontend)
        $temp = (float) ($weatherData['temp'] ?? 0);
        $weatherCode = (int) ($weatherData['code'] ?? 0);
        $humidity = (float) ($weatherData['humidity'] ?? 0);
        $windSpeed = (float) ($weatherData['wind_speed'] ?? 0);

        // 3. Cari Fase aktif berdasarkan hari tanam saat ini dari relasi plantingGuide
        $currentPhase = $plan->plantingGuide?->phases()
            ->where('start_day', '<=', $currentDay)
            ->where('end_day', '>=', $currentDay)
            ->first();

        $phaseName = $currentPhase ? $currentPhase->name : 'Fase Tidak Terdeteksi';

        // Default response jika kondisi normal
        $status = 'optimal'; // optimal, warning, danger
        $advice = 'Kondisi lingkungan sangat mendukung. Tetap lakukan perawatan rutin sesuai checklist pelaksanaan hari ke-' . $currentDay . '.';

        // --- ENGINE LOGIKA SMART ADVISOR ---
        
        // Skenario 1: Tanaman Cabai
        if (str_contains($commodityName, 'cabai')) {
            if ($temp > 33) {
                $status = 'warning';
                $advice = "Suhu terdeteksi sangat panas ({$temp}°C). Pada fase {$phaseName}, cabai rentan rontok bunga dan buah. Tingkatkan volume penyiraman pada sore hari.";
            } elseif ($humidity > 85 && $weatherCode < 51) {
                $status = 'danger';
                $advice = "Waspada! Kelembapan sangat tinggi ({$humidity}%) namun cuaca cerah/berawan. Kondisi ini sangat ideal bagi penyebaran jamur Antraknosa (patek) pada buah cabai. Lakukan monitoring ketat.";
            } elseif ($windSpeed > 20) {
                $status = 'warning';
                $advice = "Kecepatan angin cukup kencang ({$windSpeed} km/h). Tunda penyemprotan pupuk daun atau pestisida cair hari ini agar tidak terbuang percuma akibat drift (terbawa angin).";
            }
        }

        // Skenario 2: Tanaman Padi
        if (str_contains($commodityName, 'padi')) {
            if ($weatherCode >= 61) { // Kode Open-Meteo untuk hujan sedang/lebat
                $status = 'warning';
                if (str_contains(strtolower($phaseName), 'semai') || $currentDay <= 15) {
                    $status = 'danger';
                    $advice = "Hujan lebat mengguyur di fase persemaian padi hari ke-{$currentDay}. Pastikan saluran drainase sawah terbuka lebar agar bibit muda tidak tergenang banjir dan membusuk.";
                } else {
                    $advice = "Hari ini turun hujan. Kurangi debit pengairan dari irigasi utama untuk menghemat air dan mencegah luapan lahan.";
                }
            } elseif ($temp > 35) {
                $status = 'warning';
                $advice = "Suhu panas ekstrem ({$temp}°C). Pastikan ketinggian air di petakan sawah terjaga setinggi 5-7 cm untuk menstabilkan suhu mikro di sekitar akar padi.";
            }
        }

        return [
            'status' => $status,
            'phase_name' => $phaseName,
            'current_day' => $currentDay,
            'advice' => $advice,
        ];
    }
}