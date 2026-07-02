<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PreProductionPlan;
use App\Mail\HarvestReminderMail;
use Illuminate\Support\Facades\Mail;

class CheckHarvestReminders extends Command
{
    protected $signature = 'app:check-harvest-reminders';
    protected $description = 'Kirim email pengingat H-7 sebelum masa panen tiba';

    public function handle()
    {
        $this->info("Memulai pengecekan H-7 masa panen...");

        // Ambil semua rencana produksi aktif
        $plans = PreProductionPlan::with(['user', 'lahan', 'commodityType'])
            ->where('is_active', true)
            ->get();

        foreach ($plans as $plan) {
            if (!$plan->user || !$plan->duration_days) continue;

            $currentDay = (int) $plan->current_day;
            $durationDays = (int) $plan->duration_days;
            
            // Hitung sisa hari
            $daysLeft = $durationDays - $currentDay;

            // Jika tepat H-7, tembak email!
            if ($daysLeft === 7) {
                Mail::to($plan->user->email)->send(new HarvestReminderMail($plan));
                $this->info("🌾 Pengingat panen H-7 dikirim ke: " . $plan->user->email);
            }
        }

        $this->info("Pengecekan selesai!");
    }
}