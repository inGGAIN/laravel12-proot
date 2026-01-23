<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TransactionController;

Route::get('/', [TourismController::class, 'index'])->name('home');
Route::get('/wisata/{id}', [TourismController::class, 'show'])->name('wisata.show');
Route::get('/wisata/{id}/edit', [TourismController::class, 'edit'])->name('wisata.edit');
// Route untuk melihat detail destinasi
Route::get('/wisata/{id}', [DestinationController::class, 'show'])->name('wisata.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/booking/{destination_id}', [TransactionController::class, 'store'])->name('booking.store');
    // Route untuk update status transaksi secara cepat
Route::patch('/transactions/{id}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
});
Route::middleware(['auth'])->group(function () {
    // Menampilkan form edit
    Route::get('/wisata/{id}/edit', [TourismController::class, 'edit'])->name('wisata.edit');
    
    // Memproses update data
    Route::put('/wisata/{id}', [TourismController::class, 'update'])->name('wisata.update');

    // Hapus Data
    Route::delete('/destinations/{id}', [TourismController::class, 'destroy'])->name('destinations.destroy');
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
