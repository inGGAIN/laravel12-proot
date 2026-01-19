<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class TourismController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('home', compact('destinations'));
    }
    public function show($id)
    {
        // Mencari destinasi, jika tidak ada akan muncul error 404
        $destination = Destination::findOrFail($id);
        
        return view('show', compact('destination'));
    }
}
