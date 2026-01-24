<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function checkout(Request $request, $id)
    {
        $wisata = Destination::findOrFail($id);

        // save to transaction_table
        $trx = Transaction::create([
            'user_id' => Auth::id() ?? 1,
            'destination_id' => $id,
            'quantity' => $request->qty,
            'total_price' => $wisata->price * $request->qty,
            'status' => 'paid'
        ]);

        return redirect()->route('invoice', $trx->id);
    }  

    public function invoice($id)
    {
        $transaction = Transaction::with(['user', 'destination'])
            ->where('id', $id)
            ->where('user_id', auth()->id()) // Pastikan user hanya bisa buka invoice milik sendiri
            ->firstOrFail();

        return view('bookings.invoice', compact('transaction'));
    }
}
