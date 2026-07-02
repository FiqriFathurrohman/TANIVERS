<?php

namespace App\Services;

use App\Models\PreProductionPlan;
use App\Models\ExecutionExpense; // Tambah ini
use App\Models\HarvestReport;    // Tambah ini

class FinancialAnalyticsService
{
    public function calculateROI(PreProductionPlan $plan): array
    {
        // 1. Hitung Total Modal (Budget Awal + Pengeluaran Ekstra)
        // Kita pakai cara query langsung (Anti-Error)
        $initialBudget = (float) $plan->budget;
        $extraExpenses = (float) ExecutionExpense::where('pre_production_plan_id', $plan->id)->sum('total_amount');
        $totalCapital = $initialBudget + $extraExpenses;

        // 2. Hitung Total Pendapatan Panen
        // Query langsung ke tabel HarvestReport
        $totalIncome = (float) HarvestReport::where('pre_production_plan_id', $plan->id)->sum('total_income');

        // 3. Hitung Laba Bersih
        $profit = $totalIncome - $totalCapital;

        // 4. Hitung persentase ROI
        $roiPercentage = 0;
        if ($totalCapital > 0) {
            $roiPercentage = ($profit / $totalCapital) * 100;
        }

        // 5. Tentukan Status
        if ($roiPercentage > 0) {
            $status = 'Untung';
            $color = 'emerald';
            $message = 'Luar biasa! Lahan ini menghasilkan keuntungan bersih sebesar ' . number_format($roiPercentage, 1) . '% dari total modal.';
        } elseif ($roiPercentage < 0) {
            $status = 'Rugi';
            $color = 'red';
            $message = 'Perhatian: Lahan ini masih mengalami kerugian (' . number_format($roiPercentage, 1) . '%). Total pendapatan belum menutup modal dan pengeluaran.';
        } else {
            $status = 'BEP / Balik Modal';
            $color = 'amber';
            $message = 'Lahan ini sudah mencapai titik impas (Break Even Point). Belum ada untung maupun rugi.';
        }

        return [
            'total_capital' => $totalCapital,
            'total_income' => $totalIncome,
            'net_profit' => $profit,
            'roi_percentage' => round($roiPercentage, 2),
            'analysis' => [
                'status' => $status,
                'color' => $color,
                'message' => $message
            ]
        ];
    }
}