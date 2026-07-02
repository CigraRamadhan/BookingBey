<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('layouts/admin');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

# Route Admin
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', fn()=>view('admin.dashboard'))->name('dashboard');

        Route::resource('lapangan', Admin\LapanganController::class);

        Route::resource('booking', Admin\BookingController::class);

        Route::resource('payments', Admin\PaymentController::class);

        Route::resource('users', Admin\UserController::class);

});