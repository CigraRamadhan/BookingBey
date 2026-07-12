<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController;

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');

    // Notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('admin.notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('admin.notifications.readAll');

    Route::resource('lapangan', LapanganController::class);

    Route::resource('booking', BookingController::class);

    Route::resource('payments', PaymentController::class);

    Route::resource('users', UserController::class);
    Route::get('/booking', [BookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('admin.booking.show');
    Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('admin.booking.update');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('admin.booking.destroy');
    Route::put('/booking/{booking}/payment', [BookingController::class, 'updatePayment'])->name('admin.booking.updatePayment');

    Route::put('payments/{payment}/approve', [PaymentController::class, 'approve'])
        ->name('payments.approve');
    Route::put('payments/{payment}/reject', [PaymentController::class, 'reject'])
        ->name('payments.reject');


});