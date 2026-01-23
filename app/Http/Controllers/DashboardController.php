<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Widget
        $totalDestinations = Destination::count();
        
        // 2. Data untuk Grafik Pendapatan Mingguan
        $weeklyIncome = Transaction::select(
            DB::raw('SUM(total_price) as income'),
            DB::raw('WEEK(created_at) as week')
        )
        ->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))
        ->groupBy('week')
        ->orderBy('week', 'asc')
        ->get();

        $labels = $weeklyIncome->map(fn($item, $key) => 'Minggu ' . ($key + 1));
        $values = $weeklyIncome->pluck('income');

        // 3. Data untuk Tabel (Group by Destination) - Untuk statistik ringkas
        $chartData = Transaction::join('destinations', 'destinations.id', '=', 'transactions.destination_id')
            ->select('destinations.name', DB::raw('count(transactions.id) as total_booked'))
            ->groupBy('destinations.id', 'destinations.name')
            ->orderBy('total_booked', 'desc')
            ->get();

        // 4. INI YANG KURANG: Ambil 5 Transaksi Terbaru untuk List Konfirmasi
        $recentTransactions = Transaction::with('destination')
            ->latest()
            ->take(5)
            ->get();

        // Kirim semua variabel ke view
        return view('dashboard', compact(
            'totalDestinations', 
            'chartData', 
            'recentTransactions', // Pastikan variabel ini ada di sini
            'labels', 
            'values'
        ));
    }
}