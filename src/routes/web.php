<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\PreProductionController;
use App\Http\Controllers\PelaksanaanController;
use App\Http\Controllers\RiwayatLaporanController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Livewire Asset Handling
|--------------------------------------------------------------------------
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});

/*
|--------------------------------------------------------------------------
| Root Route (Landing Page Tera Tani)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Memanggil landing page dari folder resources/views/pembuka/welcome.blade.php
    return view('pembuka.welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Auth Page Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    if (Auth::check()) {
        if (! Auth::user()->email_verified_at) {
            return redirect()->route('otp.form');
        }
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    if (Auth::check()) {
        if (! Auth::user()->email_verified_at) {
            return redirect()->route('otp.form');
        }
        return redirect()->route('dashboard');
    }
    return view('auth.register');
})->name('register');

Route::get('/forgot-password', function () {
    return 'Fitur reset password dalam tahap pengembangan.';
})->name('password.request');

/*
|--------------------------------------------------------------------------
| Auth Process Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| OTP Verification Routes
|--------------------------------------------------------------------------
*/
Route::get('/otp/verify', [OtpController::class, 'show'])
    ->middleware('auth')
    ->name('otp.form');

Route::post('/otp/verify', [OtpController::class, 'verify'])
    ->middleware(['auth', 'throttle:10,1'])
    ->name('otp.verify');

Route::post('/otp/resend', [OtpController::class, 'resend'])
    ->middleware(['auth', 'throttle:3,1'])
    ->name('otp.resend');

/*
|--------------------------------------------------------------------------
| Google Socialite Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| Main Dashboard Route
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Lahan Routes
|--------------------------------------------------------------------------
*/
Route::get('/lahan/create', [LahanController::class, 'create'])
    ->middleware('auth')
    ->name('lahan.create');

Route::post('/lahan/store', [LahanController::class, 'store'])
    ->middleware('auth')
    ->name('lahan.store');

/*
|--------------------------------------------------------------------------
| Pre Production & Perancangan Routes
|--------------------------------------------------------------------------
*/
Route::get('/pre-production/create', [PreProductionController::class, 'create'])
    ->middleware('auth')
    ->name('pre-production.create');

Route::post('/pre-production/store', [PreProductionController::class, 'store'])
    ->middleware('auth')
    ->name('pre-production.store');

Route::get('/pre-production/commodity-types/{commodityId}', [PreProductionController::class, 'commodityTypes'])
    ->middleware('auth')
    ->name('pre-production.commodity-types');

Route::get('/pre-production/planting-guide/{commodityTypeId}', [PreProductionController::class, 'plantingGuide'])
    ->middleware('auth')
    ->name('pre-production.planting-guide');

// Route API Internal Pre-Production
Route::get('/api/check-crop-rotation', [PreProductionController::class, 'checkCropRotation'])
    ->middleware('auth')
    ->name('api.check-crop-rotation');

Route::post('/pre-production/smart-advisor-analysis', [PreProductionController::class, 'getSmartAdvice'])
    ->name('pre-production.smart-advisor');

Route::post('/pre-production/early-warning', [PreProductionController::class, 'getEarlyWarning'])
    ->name('pre-production.early-warning');

Route::post('/pre-production/yield-prediction', [PreProductionController::class, 'getYieldPrediction'])
    ->name('pre-production.yield-prediction');

/*
|--------------------------------------------------------------------------
| Pelaksanaan Routes
|--------------------------------------------------------------------------
*/
Route::get('/pelaksanaan', [PelaksanaanController::class, 'index'])
    ->middleware('auth')
    ->name('pelaksanaan.index');

Route::post('/pelaksanaan/update-day', [PelaksanaanController::class, 'updateDay'])
    ->middleware('auth')
    ->name('pelaksanaan.update-day');

Route::post('/pelaksanaan/checklist', [PelaksanaanController::class, 'updateChecklist'])
    ->middleware('auth')
    ->name('pelaksanaan.checklist');

Route::post('/pelaksanaan/hama', [PelaksanaanController::class, 'storePestReport'])
    ->middleware('auth')
    ->name('pelaksanaan.hama.store');

Route::post('/pelaksanaan/pengeluaran', [PelaksanaanController::class, 'storeExpense'])
    ->middleware('auth')
    ->name('pelaksanaan.expense.store');

Route::post('/pelaksanaan/simpan-laporan', [PelaksanaanController::class, 'storeDailyReport'])
    ->middleware('auth')
    ->name('pelaksanaan.report.store');

Route::post('/pelaksanaan/smart-tasks', [PelaksanaanController::class, 'getSmartTasks'])
    ->middleware('auth')
    ->name('pelaksanaan.smart-tasks');

Route::post('/pelaksanaan/toggle-task', [PelaksanaanController::class, 'toggleTask'])
    ->name('pelaksanaan.toggle-task');

/*
|--------------------------------------------------------------------------
| Riwayat Laporan & Laporan Keuangan Routes
|--------------------------------------------------------------------------
*/
Route::get('/riwayat-laporan', [RiwayatLaporanController::class, 'index'])
    ->middleware('auth')
    ->name('riwayat-laporan.index');

Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])
    ->middleware('auth')
    ->name('laporan-keuangan.index');

Route::post('/laporan-keuangan/panen', [LaporanKeuanganController::class, 'storeHarvest'])
    ->middleware('auth')
    ->name('laporan-keuangan.harvest.store');

Route::post('/laporan-keuangan/financial-analysis', [LaporanKeuanganController::class, 'getFinancialAnalysis'])
    ->middleware('auth')
    ->name('laporan-keuangan.analysis');

/*
|--------------------------------------------------------------------------
| Profil & Pengaturan Akun
|--------------------------------------------------------------------------
*/
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

/*
|--------------------------------------------------------------------------
| API Wilayah Lokal
|--------------------------------------------------------------------------
*/
Route::get('/wilayah/provinces', [WilayahController::class, 'provinces'])->name('wilayah.provinces');
Route::get('/wilayah/cities/{provinceId}', [WilayahController::class, 'cities'])->name('wilayah.cities');
Route::get('/wilayah/districts/{cityId}', [WilayahController::class, 'districts'])->name('wilayah.districts');

/*
|--------------------------------------------------------------------------
| Utility / Testing Routes
|--------------------------------------------------------------------------
*/
Route::get('/test-email', function() {
    try {
        \Illuminate\Support\Facades\Mail::raw('Ini adalah pesan uji coba dari sistem Tanivers.', function($msg) {
            $msg->to(Auth::check() ? Auth::user()->email : 'alfinkhalaj566@gmail.com')
                ->subject('🚨 Uji Coba Radar Tanivers');
        });
        return "<h1>✅ SUKSES! Email berhasil dikirim! Cek inbox/spam lu sekarang.</h1>";
    } catch (\Exception $e) {
        return "<h1>❌ GAGAL! Ini alasan Google menolaknya:</h1><br><b>" . $e->getMessage() . "</b>";
    }
});