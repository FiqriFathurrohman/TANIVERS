<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PetaniAuthController;
use App\Http\Controllers\SOPController;
use App\Http\Controllers\Petani\RencanaController;
use App\Http\Controllers\Petani\PelaksanaanController;
use App\Http\Controllers\Petani\LahanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\UserController; // tambahkan
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes — Tera Tani Platform
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});

// Otentikasi
Route::get('/petani', [PetaniAuthController::class, 'showLoginForm'])->name('login');
Route::post('/petani', [PetaniAuthController::class, 'login']);
Route::post('/petani/logout', [PetaniAuthController::class, 'logout'])->name('logout');

// Registrasi
Route::get('/register', [PetaniAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [PetaniAuthController::class, 'register']);

// Verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Semua rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SOPController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard', [SOPController::class, 'storeKeuangan'])->name('pelaksanaan.keuangan.store');

    Route::get('/rencana', function () {
        return redirect('/dashboard');
    })->name('rencana.index');
    Route::post('/rencana/mulai', [RencanaController::class, 'storePeriode'])->name('rencana.store');
    Route::post('/rencana/budget-save', [RencanaController::class, 'storeBudget'])->name('rencana.budget.save');

    Route::get('/pelaksanaan', [PelaksanaanController::class, 'index'])->name('pelaksanaan.index');
    Route::post('/pelaksanaan/photo', [PelaksanaanController::class, 'storePhoto'])->name('pelaksanaan.photo.store');
    Route::post('/pelaksanaan/sop-toggle', [PelaksanaanController::class, 'toggleSop'])->name('sop.toggle');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('teratani.laporan');
    Route::post('/laporan/panen', [LaporanController::class, 'storePanen'])->name('teratani.panen.store');
    Route::post('/laporan/transaksi', [LaporanController::class, 'storeTransaksi'])->name('teratani.transaksi.store');

    // Manajemen lahan (pendaftaran & cek lahan aktif)
    Route::post('/petani/lahan/pendaftaran-store', [LahanController::class, 'store'])->name('lahan.store');
    Route::get('/petani/lahan/aktif', [LahanController::class, 'getActiveLahan'])->name('lahan.aktif');

    // Rute untuk pengaturan akun
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::put('/user/password', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::delete('/user/delete', [UserController::class, 'deleteAccount'])->name('user.delete');
});