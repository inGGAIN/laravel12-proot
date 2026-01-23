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
        $totalDestinations = Destination::count();
        $destinations = Destination::latest()->paginate(10);
        $chartData = Transaction::select(
            'destinations.name',
            DB::raw('COUNT(transactions.id) as total_booked')
        )
        ->join('destinations', 'destinations.id', '=', 'transactions.destination_id')
        ->groupBy('destinations.id', 'destinations.name')
        ->get();

        return view('dashboard', compact('totalDestinations', 'chartData', 'destinations'));
    }
}
