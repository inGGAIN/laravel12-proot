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
| Public Routes (Bisa diakses tanpa login)
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

    // --- Akses Semua Role (User & Admin) ---
    Route::post('/booking/{destination_id}', [TransactionController::class, 'store'])->name('booking.store');
    Route::get('/invoice/{id}', [BookingController::class, 'invoice'])->name('invoice');
    Route::get('/my-bookings', [TransactionController::class, 'myBookings'])->name('my-bookings');
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/booking/invoice/{id}', [TransactionController::class, 'showInvoice'])->name('booking.invoice');
    // Fitur Cancel Booking
    Route::delete('/my-bookings/{id}/cancel', [TransactionController::class, 'cancelBooking'])->name('booking.cancel');
    
    // Riwayat Booking yang sudah selesai (Success/Cancel)
    Route::get('/booking-history', [TransactionController::class, 'bookingHistory'])->name('booking.history');
    /*
    |--------------------------------------------------------------------------
    | Admin ONLY Routes (Hanya untuk Role Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->group(function () {
        
        // Dashboard Statistik
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Destinasi (Hanya Admin yang bisa kelola data)
        // Kita exclude 'show' karena sudah ada di rute public/umum
        Route::resource('destinations', DestinationController::class)->except(['show']);
        
        // Manajemen Transaksi (Update Status, List Booking)
        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [TransactionController::class, 'index'])->name('index');
            Route::patch('/{id}/status', [TransactionController::class, 'updateStatus'])->name('updateStatus');
        });

        // Export ke file
        Route::get('/admin/export-pdf', [TransactionController::class, 'exportPDF'])->name('admin.export-pdf');
        Route::get('/admin/export-word', [TransactionController::class, 'exportWord'])->name('admin.export-word');

        // Fitur Checkout Admin (Jika diperlukan)
        Route::post('/checkout/{id}', [BookingController::class, 'checkout'])->name('checkout');
    });

});

require __DIR__.'/auth.php';