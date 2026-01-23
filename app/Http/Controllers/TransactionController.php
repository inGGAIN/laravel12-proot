<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request, $destination_id)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $destination = Destination::findOrFail($destination_id);

        $quantity = $request->input('quantity', 1);

        $totalPrice = $destination->price * $quantity;
        // Simpan data ke tabel transactions
        Transaction::create([
            'user_id' => Auth::id(),
            'destination_id' => $destination->id,
            'status' => 'pending', // Status awal pemesanan
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'booking_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Berhasil memesan ' . $destination->name . '! Cek riwayat pesanan Anda.');
    }

    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Validasi status yang diperbolehkan
        $request->validate([
            'status' => 'required|in:pending,success,cancel'
        ]);

        $transaction->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'new_status' => $request->status]);
    }
}