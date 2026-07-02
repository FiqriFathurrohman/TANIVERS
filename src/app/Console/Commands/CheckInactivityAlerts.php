<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PreProductionPlan;
use App\Models\ExecutionTaskCheck;
use App\Mail\InactivityAlertMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckInactivityAlerts extends Command
{
    protected $signature = 'app:check-inactivity-alerts';
    protected $description = 'Kirim email peringatan jika lahan tidak diurus selama 3 hari berturut-turut';

    public function handle()
    {
        $this->info("Memulai pengecekan lahan terbengkalai...");

        // Ambil semua plan yang masih aktif
        $plans = PreProductionPlan::with(['user', 'lahan', 'commodityType'])
            ->where('is_active', true)
            ->get();

        foreach ($plans as $plan) {
            if (!$plan->user || !$plan->lahan) continue;

            // Cari kapan terakhir kali user nge-ceklis tugas (is_done = true) di lahan ini
            $lastCheck = ExecutionTaskCheck::where('pre_production_plan_id', $plan->id)
                ->where('is_done', true)
                ->latest('checked_at')
                ->first();

            // Kalau belum pernah ada ceklis sama sekali, pakai tanggal plan dibuat
            $lastActiveDate = $lastCheck ? $lastCheck->checked_at : $plan->created_at;

            // Hitung selisih hari dari terakhir aktif sampai hari ini
            $daysInactive = Carbon::parse($lastActiveDate)->startOfDay()->diffInDays(now()->startOfDay());

            // Jika pas 3 Hari nggak ada kabar, TEMBAK EMAILNYA!
            if ($daysInactive == 3) {
                try {
                    Mail::to($plan->user->email)->send(new InactivityAlertMail($plan));
                    $this->info("✅ Inactivity Alert terkirim ke: " . $plan->user->email . " (Lahan: " . $plan->lahan->nama_lahan . ")");
                } catch (\Exception $e) {
                    $this->error("Gagal ngirim ke " . $plan->user->email . ": " . $e->getMessage());
                }
            }
        }

        $this->info("Pengecekan lahan terbengkalai selesai!");
    }
}