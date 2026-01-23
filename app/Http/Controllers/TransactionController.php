<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi dengan pagination.
     */
    public function index(): View
    {
        // Eager loading user dan destination untuk menghindari N+1 Query Problem
        $transactions = Transaction::with(['user', 'destination'])
            ->latest()
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Menyimpan data booking baru ke database.
     */
    public function store(Request $request, int $destination_id): RedirectResponse
    {
        // Validasi input quantity
        $request->validate([
            'quantity' => 'nullable|integer|min:1'
        ]);

        $destination = Destination::findOrFail($destination_id);
        $quantity = $request->input('quantity', 1);
        $totalPrice = $destination->price * $quantity;

        Transaction::create([
            'user_id'        => Auth::id(),
            'destination_id' => $destination->id,
            'status'         => 'pending',
            'quantity'       => $quantity,
            'total_price'    => $totalPrice,
            'booking_date'   => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', "Berhasil memesan {$destination->name}! Silakan cek riwayat pesanan Anda.");
    }

    /**
     * Update status transaksi via AJAX.
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:pending,success,cancel'
        ]);

        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success'    => true, 
            'new_status' => $request->status,
            'message'    => 'Status berhasil diperbarui!'
        ]);
    }
}