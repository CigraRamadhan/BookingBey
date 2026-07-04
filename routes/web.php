<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LapanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('layouts/admin');
});

# Route Admin
Route::prefix('admin')
    ->middleware(['auth'])
    ->name('admin.')
    ->group(function () {

        Route::resource('lapangan', LapanganController::class);

    });