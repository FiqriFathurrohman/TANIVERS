<?php

namespace App\Services;

use App\Models\PreProductionPlan;

class SmartTaskService
{
    public function generateDailyTasks(PreProductionPlan $plan): array
    {
        $currentDay = (int) $plan->current_day;
        
        // 1. Ambil Panduan Tanam beserta Fase dan Tugasnya
        $guide = $plan->plantingGuide()->with(['phases.tasks'])->first();

        if (!$guide) {
            return [
                'status' => 'error',
                'message' => 'Panduan masa tanam tidak ditemukan untuk lahan ini.',
                'tasks' => []
            ];
        }

        // 2. Cari Fase yang sedang aktif di hari ini
        $activePhase = $guide->phases
            ->where('start_day', '<=', $currentDay)
            ->where('end_day', '>=', $currentDay)
            ->first();

        if (!$activePhase) {
            return [
                'status' => 'success',
                'phase_name' => 'Masa Tanam Selesai/Belum Mulai',
                'message' => 'Tidak ada aktivitas terjadwal untuk hari ke-' . $currentDay,
                'tasks' => []
            ];
        }

        // 3. Filter Tugas (Task) yang jatuh pada hari ini
        $todayTasks = [];

        foreach ($activePhase->tasks as $task) {
            // Pastikan hari ini masuk dalam rentang tugas tersebut
            if ($currentDay >= $task->start_day && $currentDay <= $task->end_day) {
                
                $isTaskToday = false;

                // LOGIKA PENJADWALAN DINAMIS
                if ($task->repeat_type === 'daily') {
                    // Jika tugas harian, pasti masuk
                    $isTaskToday = true;
                } elseif ($task->repeat_type === 'interval' && $task->repeat_interval_days > 0) {
                    // Jika tugas berulang tiap X hari (contoh: pupuk tiap 7 hari)
                    // Gunakan operasi Modulo (sisa bagi)
                    if (($currentDay - $task->start_day) % $task->repeat_interval_days === 0) {
                        $isTaskToday = true;
                    }
                } elseif ($task->start_day === $currentDay) {
                    // Jika tugas cuma dilakukan sekali (once) tepat di hari itu
                    $isTaskToday = true;
                }

                if ($isTaskToday) {
                    $todayTasks[] = [
                        'id' => $task->id,
                        'title' => $task->title,
                        'description' => $task->description,
                        'type' => $task->repeat_type, // 'daily', 'interval', 'once'
                    ];
                }
            }
        }

        // 4. Return Output JSON
        return [
            'status' => 'success',
            'current_day' => $currentDay,
            'phase_name' => $activePhase->name,
            'total_tasks_today' => count($todayTasks),
            'tasks' => $todayTasks,
            'message' => count($todayTasks) > 0 
                ? 'Ada ' . count($todayTasks) . ' tugas yang harus diselesaikan hari ini.' 
                : 'Wah, hari ini Anda bisa bersantai! Tidak ada tugas spesifik.'
        ];
    }
}