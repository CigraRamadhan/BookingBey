<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('lapangan', LapanganController::class);

    Route::resource('booking', BookingController::class);

    Route::resource('payments', PaymentController::class);

    Route::resource('users', UserController::class);
    Route::get('/booking', [BookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('admin.booking.show');
    Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('admin.booking.update');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('admin.booking.destroy');
    Route::put('/booking/{booking}/payment', [BookingController::class, 'updatePayment'])->name('admin.booking.updatePayment');

});