<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PreProductionPlan;
use App\Models\ExecutionExpense;
use App\Mail\FinancialAlertMail;
use Illuminate\Support\Facades\Mail;

class CheckFinancialAlerts extends Command
{
    protected $signature = 'app:check-financial-alerts';
    protected $description = 'Audit total pengeluaran petani';

    public function handle()
    {
        $this->info("Memulai audit anggaran keuangan pra-produksi...");

        $plans = PreProductionPlan::with(['user', 'lahan', 'commodityType'])
            ->where('is_active', true)
            ->where('budget', '>', 0)
            ->get();

        foreach ($plans as $plan) {
            if (!$plan->user) continue;

            $totalSpent = (float) ExecutionExpense::where('pre_production_plan_id', $plan->id)
                ->sum('total_amount');

            if ($totalSpent <= 0) continue;

            $percentage = ($totalSpent / (float)$plan->budget) * 100;

            if ($percentage >= 80) {
                try {
                    // Panggil Mailable Asli yang udah kita bikin kalem
                    Mail::to($plan->user->email)->send(new FinancialAlertMail($plan, $totalSpent, $percentage));
                    $this->info("✅ Financial Alert terkirim ke: " . $plan->user->email . " ({$percentage}%)");
                } catch (\Exception $e) {
                    $this->error("Gagal ngirim: " . $e->getMessage());
                }
            }
        }

        $this->info("Audit keuangan selesai!");
    }
}