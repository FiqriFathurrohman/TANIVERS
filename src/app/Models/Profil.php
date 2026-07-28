<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [ProfileController::class, 'index'])
            ->name('index');

        Route::patch('/', [ProfileController::class, 'update'])
            ->name('update');

        Route::post('/photo', [ProfileController::class, 'updatePhoto'])
            ->name('photo.update');

        Route::put('/password', [ProfileController::class, 'updatePassword'])
            ->name('password.update');

        Route::post('/logout-other-devices', [ProfileController::class, 'logoutOtherDevices'])
            ->name('logout-other-devices');
    });