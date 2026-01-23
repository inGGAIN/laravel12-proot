<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->paginate(10); // ✅ BENAR
        return view('destinations.index', compact('destinations'));
    }


    public function edit(Destination $destination)
    {
        return view('destinations.edit', compact('destination'));
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('destinations.index')
            ->with('success', 'Destinasi berhasil dihapus');
    }
}
