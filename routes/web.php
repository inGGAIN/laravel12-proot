<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;

Route::get('/', [TourismController::class, 'index'])->name('home');
Route::get('/wisata/{id}', [TourismController::class, 'show'])->name('wisata.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('destinations', DestinationController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard bawaan Breeze
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::get('/destinations', [DestinationController::class, 'index'])
        ->name('destinations.index');

    Route::resource('destinations', DestinationController::class)->except(['index']);

    // Route Projek Wisata
    Route::post('/checkout/{id}', [BookingController::class, 'checkout'])->name('checkout');
    Route::get('/invoice/{id}', [BookingController::class, 'invoice'])->name('invoice');
});

require __DIR__.'/auth.php';
