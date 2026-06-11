<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\PreProductionController;

use App\Models\Lahan;

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

Route::get('/dashboard', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

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

Route::get('/lahan/create', [LahanController::class, 'create'])
    ->name('lahan.create');

Route::post('/lahan/store', [LahanController::class, 'store'])
    ->name('lahan.store');

/*
|--------------------------------------------------------------------------
| Pre Production & Perancangan Routes
|--------------------------------------------------------------------------
*/

Route::get('/pre-production/create', [PreProductionController::class, 'create'])
    ->name('pre-production.create');

Route::post('/pre-production/store', [PreProductionController::class, 'store'])
    ->name('pre-production.store');

Route::get('/pre-production/commodity-types/{commodityId}', [PreProductionController::class, 'commodityTypes'])
    ->name('pre-production.commodity-types');

Route::get('/pre-production/planting-guide/{commodityTypeId}', [PreProductionController::class, 'plantingGuide'])
    ->name('pre-production.planting-guide');

/*
|--------------------------------------------------------------------------
| API Wilayah Lokal
|--------------------------------------------------------------------------
*/

Route::get('/wilayah/provinces', [WilayahController::class, 'provinces'])
    ->name('wilayah.provinces');

Route::get('/wilayah/cities/{provinceId}', [WilayahController::class, 'cities'])
    ->name('wilayah.cities');

Route::get('/wilayah/districts/{cityId}', [WilayahController::class, 'districts'])
    ->name('wilayah.districts');