<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| [1] NAIK HARI OTOMATIS (Jam 00:00 Tengah Malam)
|--------------------------------------------------------------------------
*/
Schedule::command('app:update-crop-days')->dailyAt('00:00');

/*
|--------------------------------------------------------------------------
| [2] MORNING BRIEFING EMAIL (Jam 05:30 Pagi)
|--------------------------------------------------------------------------
*/
Schedule::command('app:send-daily-briefing')->dailyAt('05:30');

/*
|--------------------------------------------------------------------------
| [3] RADAR EWS — EARLY WARNING SYSTEM (Setiap Jam)
|--------------------------------------------------------------------------
*/
Schedule::command('app:send-ews-alerts')->hourly();

// PENGINGAT PANEN H-7 SUDAH DIHAPUS DARI SINI. 
// SEKARANG MURNI REAL-TIME DARI PELAKSANAAN CONTROLLER.

/*
|--------------------------------------------------------------------------
| [4] NOTIFIKASI LAHAN TERBENGKALAI (Jam 16:00 Sore)
|--------------------------------------------------------------------------
*/
Schedule::command('app:check-inactivity-alerts')->dailyAt('16:00');