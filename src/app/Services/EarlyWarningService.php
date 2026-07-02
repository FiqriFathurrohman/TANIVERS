<?php

namespace App\Services;

use App\Models\PreProductionPlan;

class EarlyWarningService
{
    public function analyzeRisk(PreProductionPlan $plan, array $forecastData): array
    {
        // 1. Identifikasi Tanaman
        $commodityName = strtolower($plan->commodityType?->name ?? '');

        // 2. Ekstrak Ramalan Cuaca (Ambil 3 hari ke depan saja untuk deteksi dini)
        $avgTemp = collect($forecastData['temperature_2m_max'])->take(3)->average();
        $avgHumidity = collect($forecastData['relative_humidity_2m_max'])->take(3)->average();
        $weatherCodes = collect($forecastData['weathercode'])->take(3);
        
        // Hitung berapa hari berpotensi hujan dalam 3 hari ke depan
        $rainDays = $weatherCodes->filter(fn($code) => $code >= 61)->count();

        // 3. Default Response (Kondisi Aman)
        $riskLevel = 'RENDAH';
        $threatName = 'Tidak ada ancaman signifikan';
        $recommendation = 'Kondisi lingkungan diproyeksikan aman. Lanjutkan jadwal perawatan dan observasi rutin.';
        $color = 'emerald'; // Hijau

        // --- ENGINE PREDIKTIF HAMA & PENYAKIT ---

        // Skenario Cabai
        if (str_contains($commodityName, 'cabai') || str_contains($commodityName, 'cabe')) {
            if ($avgHumidity >= 85 && $rainDays >= 2) {
                $riskLevel = 'TINGGI';
                $threatName = 'Jamur Antraknosa (Patek)';
                $recommendation = 'Bahaya! Kelembapan rata-rata tinggi (' . round($avgHumidity) . '%) dengan potensi hujan berturut-turut. Segera semprotkan fungisida preventif (berbahan aktif Mankozeb/Propineb) dan kurangi pupuk Nitrogen.';
                $color = 'red';
            } elseif ($avgTemp >= 34) {
                $riskLevel = 'SEDANG';
                $threatName = 'Hama Thrips / Kutu Daun';
                $recommendation = 'Suhu diproyeksikan sangat panas (' . round($avgTemp) . '°C) beberapa hari ke depan. Kondisi ini memicu ledakan hama Thrips. Pasang perangkap lekat kuning (Yellow Trap) di sekitar lahan.';
                $color = 'amber';
            }
        }

        // Skenario Padi
        if (str_contains($commodityName, 'padi')) {
            if ($rainDays >= 3) {
                $riskLevel = 'TINGGI';
                $threatName = 'Bakteri Hawar Daun (Kresek)';
                $recommendation = 'Cuaca ekstrem! Hujan terus-menerus memicu penyebaran bakteri Kresek. Pastikan sirkulasi air lahan lancar, hindari pemupukan Urea berlebih, dan siapkan bakterisida.';
                $color = 'red';
            } elseif ($avgHumidity > 80 && $avgTemp >= 28 && $avgTemp <= 32) {
                $riskLevel = 'SEDANG';
                $threatName = 'Wereng Batang Coklat (WBC)';
                $recommendation = 'Suhu hangat (' . round($avgTemp) . '°C) dan lembap (' . round($avgHumidity) . '%) adalah inkubator sempurna bagi Wereng. Lakukan pengeringan petakan sawah secara berselang dan pantau pangkal batang padi.';
                $color = 'amber';
            }
        }

        // 4. Return Output JSON
        return [
            'status' => 'success',
            'risk_level' => $riskLevel,
            'threat_name' => $threatName,
            'recommendation' => $recommendation,
            'color' => $color,
            'indicators' => [
                'avg_temp' => round($avgTemp, 1),
                'avg_humidity' => round($avgHumidity, 1),
                'rain_days' => $rainDays
            ]
        ];
    }
}