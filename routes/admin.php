<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('lapangan', LapanganController::class);