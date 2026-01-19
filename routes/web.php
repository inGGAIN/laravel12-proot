<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\BookingController;

Route::get('/', [TourismController::class, 'index'])->name('home');
Route::get('/wisata/{id}', [TourismController::class, 'show'])->name('wisata.show');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard bawaan Breeze
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route Projek Wisata
    Route::post('/checkout/{id}', [BookingController::class, 'checkout'])->name('checkout');
    Route::get('/invoice/{id}', [BookingController::class, 'invoice'])->name('invoice');
});

require __DIR__.'/auth.php';
