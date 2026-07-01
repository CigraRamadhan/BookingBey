<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================
// AUTH ROUTES (Dari Breeze)
// ============================================
require __DIR__.'/auth.php';

// ============================================
// PUBLIC ROUTES (Tanpa Login)
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ============================================
// ROUTE LAPANGAN (Bisa Diakses Tanpa Login)
// ============================================
Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan.index');
Route::get('/lapangan/{id}', [LapanganController::class, 'show'])->name('lapangan.show');

// ============================================
// ROUTES DENGAN MIDDLEWARE USER (Harus Login)
// ============================================
Route::middleware(['auth', 'user'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile - Menggunakan method dari ProfileController
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Booking
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::put('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::put('/booking/{id}/upload-bukti', [BookingController::class, 'uploadBukti'])->name('booking.upload-bukti');
});

// ============================================
// ADMIN ROUTES (dengan middleware admin)
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Lapangan CRUD
    Route::get('/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan', [LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::put('/lapangan/{id}', [LapanganController::class, 'update'])->name('lapangan.update');
    Route::delete('/lapangan/{id}', [LapanganController::class, 'destroy'])->name('lapangan.destroy');

    // Admin Booking Management
    Route::get('/booking', [BookingController::class, 'adminIndex'])->name('admin.booking.index');
    Route::put('/booking/{id}/status', [BookingController::class, 'adminUpdateStatus'])->name('admin.booking.status');
    Route::put('/payment/{id}/status', [BookingController::class, 'adminUpdatePayment'])->name('admin.booking.payment');
});