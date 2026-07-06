<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('lapangan', LapanganController::class);
Route::resource('booking', BookingController::class);
Route::resource('users', UserController::class);