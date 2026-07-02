<?php

namespace App\Services;

use App\Models\PreProductionPlan;
use App\Models\HarvestReport;

class YieldPredictionService
{
    public function predict(PreProductionPlan $plan): array
    {
        // 1. Ambil Data Dasar
        $luasLahan = (float) ($plan->lahan->luas_meter_persegi ?? 0);
        $commodityName = strtolower($plan->commodityType?->name ?? '');
        $commodityId = $plan->commodity_id;
        $userId = $plan->user_id;

        // --- 2. TENTUKAN YIELD (HASIL PANEN PER M2) ---
        // Hasil panen biologis relatif stabil, kita gunakan standar Agronomi
        $minYieldPerM2 = 0.5;
        $maxYieldPerM2 = 1.0;

        if (str_contains($commodityName, 'cabai') || str_contains($commodityName, 'cabe')) {
            $minYieldPerM2 = 0.8;
            $maxYieldPerM2 = 1.5;
        } elseif (str_contains($commodityName, 'padi')) {
            $minYieldPerM2 = 0.5;
            $maxYieldPerM2 = 0.8;
        } elseif (str_contains($commodityName, 'bawang')) {
            $minYieldPerM2 = 1.0;
            $maxYieldPerM2 = 2.0;
        }

        $minTotalYield = $luasLahan * $minYieldPerM2;
        $maxTotalYield = $luasLahan * $maxYieldPerM2;

        // --- 3. MACHINE LEARNING SEDERHANA: 3-TANGGA FALLBACK HARGA PASAR ---
        $estimatedPricePerKg = 0;
        $dataSource = '';

        // Ambil semua ID Plan di seluruh database yang komoditasnya sama persis
        $similarPlanIds = PreProductionPlan::where('commodity_id', $commodityId)->pluck('id');

        // TANGGA 1: Data Historis Pribadi (Cari rata-rata harga panen milik User ini saja)
        $personalPrice = HarvestReport::where('user_id', $userId)
            ->whereIn('pre_production_plan_id', $similarPlanIds)
            ->avg('price_per_unit');

        if ($personalPrice && $personalPrice > 0) {
            $estimatedPricePerKg = $personalPrice;
            $dataSource = 'Data Historis Anda'; // Data paling akurat dan personal
        } else {
            // TANGGA 2: Data Komunitas (Cari rata-rata harga panen dari SEMUA Petani di sistem)
            $communityPrice = HarvestReport::whereIn('pre_production_plan_id', $similarPlanIds)
                ->avg('price_per_unit');

            if ($communityPrice && $communityPrice > 0) {
                $estimatedPricePerKg = $communityPrice;
                $dataSource = 'Harga Rata-rata Komunitas'; // Jaring Pengaman 1
            } else {
                // TANGGA 3: Data Master Default (Jaring Pengaman Terakhir jika aplikasi masih kosong)
                if (str_contains($commodityName, 'cabai') || str_contains($commodityName, 'cabe')) {
                    $estimatedPricePerKg = 35000;
                } elseif (str_contains($commodityName, 'padi')) {
                    $estimatedPricePerKg = 7000;
                } elseif (str_contains($commodityName, 'bawang')) {
                    $estimatedPricePerKg = 25000;
                } else {
                    $estimatedPricePerKg = 5000;
                }
                $dataSource = 'Estimasi Harga Pasar Standar'; // Sistem tidak akan pernah error
            }
        }

        // --- 4. KALKULASI POTENSI PENDAPATAN (OMZET) ---
        $minIncome = $minTotalYield * $estimatedPricePerKg;
        $maxIncome = $maxTotalYield * $estimatedPricePerKg;

        // 5. Return Output JSON
        return [
            'status' => 'success',
            'luas_lahan' => $luasLahan,
            'commodity' => ucwords($commodityName),
            'price_source' => $dataSource,
            'estimated_price' => round($estimatedPricePerKg),
            'yield' => [
                'min' => round($minTotalYield),
                'max' => round($maxTotalYield),
                'unit' => 'kg'
            ],
            'income' => [
                'min' => $minIncome,
                'max' => $maxIncome,
                'formatted_min' => 'Rp ' . number_format($minIncome, 0, ',', '.'),
                'formatted_max' => 'Rp ' . number_format($maxIncome, 0, ',', '.')
            ],
            // Pesan dinamis yang jujur memberi tahu user dari mana harganya didapat
            'message' => "Menggunakan " . strtolower($dataSource) . " (Rp " . number_format($estimatedPricePerKg, 0, ',', '.') . "/kg). Luas " . number_format($luasLahan, 0, ',', '.') . " m² memiliki kapasitas produksi " . number_format($minTotalYield, 0, ',', '.') . " - " . number_format($maxTotalYield, 0, ',', '.') . " kg."
        ];
    }
}