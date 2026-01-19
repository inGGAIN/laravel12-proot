<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $destinations = Destination::all();
       return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
	    $request->validate([
		    'name' => 'required',
		    'price' => 'required|numeric',
		    'image' => 'image|mimes:jpeg,png,jpg|max:2048'
	    ]);

	    $data = $request->all();
	    if ($request->hasFile('image')) {
		    $data['image'] = $request->file('image')->store('destinations', 'public');
	    }

	    Destination::create($data);
	    return redirect()->back()->with('success', 'Destinasi di tambahkan');
    }

    /**
     * Display the specified resource.
    
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
