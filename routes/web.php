<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TourismController::class, 'index'])->name('home');

Route::get('/wisata/{id}', [TourismController::class, 'show'])->name('wisata.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/book/{id}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/invoice/{id}', [BookingController::class, 'invoice'])->name('invoice');

    //Halaman CRUD
    Route::resource('admin/destinations', DestinationController::class)->middleware('auth');
});

require __DIR__.'/auth.php';
