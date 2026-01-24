<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

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

    public function showInvoice($id)
    {
        $transaction = Transaction::with(['user', 'destination'])->findOrFail($id);
        
        // Pastikan user hanya bisa melihat invoice miliknya sendiri
        if ($transaction->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('transactions.invoice', compact('transaction'));
    }
    public function exportPDF()
    {
        // Ambil hanya transaksi yang sukses untuk laporan penghasilan
        $transactions = Transaction::with(['user', 'destination'])
            ->where('status', 'success')
            ->latest()
            ->get();

        $totalRevenue = $transactions->sum('total_price');
        
        // Data untuk grafik sederhana (pendapatan per hari/bulan)
        $chartData = Transaction::where('status', 'success')
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->get();

        $pdf = Pdf::loadView('admin.reports.booking-pdf', compact('transactions', 'totalRevenue', 'chartData'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan-Pendapatan-' . now()->format('d-M-Y') . '.pdf');
    }

    public function exportWord()
    {
        $transactions = Transaction::with(['user', 'destination'])
            ->where('status', 'success')
            ->latest()
            ->get();

        $totalRevenue = $transactions->sum('total_price');

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Judul Dokumen
        $section->addText("LAPORAN PENDAPATAN EXPLOREIN", ['bold' => true, 'size' => 16], ['alignment' => Jc::CENTER]);
        $section->addText("Tanggal: " . now()->format('d M Y'), [], ['alignment' => Jc::CENTER]);
        $section->addTextBreak(1);

        // Ringkasan
        $section->addText("Ringkasan Eksekutif:", ['bold' => true]);
        $section->addText("Total Transaksi Sukses: " . $transactions->count());
        $section->addText("Total Pendapatan: Rp " . number_format($totalRevenue, 0, ',', '.'));
        $section->addTextBreak(1);

        // Tabel Transaksi
        $styleTable = ['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80];
        $phpWord->addTableStyle('OrderTable', $styleTable);
        $table = $section->addTable('OrderTable');

        // Header Tabel
        $table->addRow();
        $table->addCell(2000)->addText("ID", ['bold' => true]);
        $table->addCell(4000)->addText("Customer", ['bold' => true]);
        $table->addCell(4000)->addText("Destinasi", ['bold' => true]);
        $table->addCell(3000)->addText("Total Harga", ['bold' => true]);

        // Isi Tabel
        foreach ($transactions as $trx) {
            $table->addRow();
            $table->addCell(2000)->addText("#" . $trx->id);
            $table->addCell(4000)->addText($trx->user->name);
            $table->addCell(4000)->addText($trx->destination->name);
            $table->addCell(3000)->addText("Rp " . number_format($trx->total_price, 0, ',', '.'));
        }

        // Proses Download
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'Laporan-ExploreIn-' . now()->format('Ymd') . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Menampilkan riwayat pesanan milik user yang sedang login.
     */
    public function myBookings(): View
    {
        $bookings = Transaction::with('destination')
            ->where('user_id', Auth::id()) // Filter hanya milik user ini
            ->latest()
            ->paginate(10);

        return view('transactions.my-bookings', compact('bookings'));
    }

    // Menampilkan Riwayat (Success & Cancel)
    public function bookingHistory()
    {
        $history = Transaction::with('destination')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['success', 'cancel']) // Yang sudah diproses
            ->latest()
            ->paginate(10);

        return view('transactions.history', compact('history'));
    }

    // Fitur Cancel oleh User
    public function cancelBooking($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // CEK: Jika status sudah bukan pending, larang pembatalan
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Pesanan yang sudah dikonfirmasi tidak dapat dibatalkan.');
        }

        $transaction->update(['status' => 'cancel']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
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