<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LahanController;

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
| Root Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Page Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
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
| Dashboard
|--------------------------------------------------------------------------
*/

use App\Models\Lahan;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    // Ambil semua lahan milik user untuk filter
    $lahans = Lahan::where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('dashboard', compact('lahans'));
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Lahan Routes
|--------------------------------------------------------------------------
*/

Route::get('/lahan/create', [LahanController::class, 'create'])->name('lahan.create');
Route::post('/lahan/store', [LahanController::class, 'store'])->name('lahan.store');

/*
|--------------------------------------------------------------------------
| API Wilayah Lokal
|--------------------------------------------------------------------------
*/

Route::get('/wilayah/provinces', [WilayahController::class, 'provinces'])->name('wilayah.provinces');
Route::get('/wilayah/cities/{provinceId}', [WilayahController::class, 'cities'])->name('wilayah.cities');
Route::get('/wilayah/districts/{cityId}', [WilayahController::class, 'districts'])->name('wilayah.districts');