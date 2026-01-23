<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [TourismController::class, 'index'])->name('home');
Route::get('/wisata/{id}', [DestinationController::class, 'show'])->name('wisata.show');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Manajemen Destinasi (CRUD) ---
    // Menggunakan Resource agar lebih ringkas (Index, Create, Store, Edit, Update, Destroy)
    Route::resource('destinations', DestinationController::class);
    
    // --- Manajemen Transaksi & Booking ---
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::patch('/{id}/status', [TransactionController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::post('/booking/{destination_id}', [TransactionController::class, 'store'])->name('booking.store');

    // --- Fitur Tambahan (Checkout & Invoice) ---
    Route::post('/checkout/{id}', [BookingController::class, 'checkout'])->name('checkout');
    Route::get('/invoice/{id}', [BookingController::class, 'invoice'])->name('invoice');

    // --- Profile User ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';