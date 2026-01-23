<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TourismController extends Controller
{
    public function index()
    {
        $destinations = Destination::latest()->paginate(9);
        return view('home', compact('destinations'));
    }
    public function show($id)
    {
        // Mencari destinasi, jika tidak ada akan muncul error 404
        $destination = Destination::findOrFail($id);
        
        return view('destinations.show', compact('destination'));
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);
        return view('destinations.edit', compact('destination'));
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // 1. Hapus foto lama dari storage jika ada
            if ($destination->image) {
                Storage::disk('public')->delete($destination->image);
            }

            // 2. Ambil file dari request
            $file = $request->file('image');

            // 3. Buat Nama File Custom
            // Format: nama-destinasi_YYYY-MM-DD-HHmmss.ekstensi
            $slugName = Str::slug($request->name);
            $timestamp = now()->format('Y-m-d-His');
            $extension = $file->getClientOriginalExtension();
            
            $fileName = "{$slugName}_{$timestamp}.{$extension}";

            // 4. Simpan file ke folder 'destinations' di dalam 'public' dengan nama baru
            $path = $file->storeAs('destinations', $fileName, 'public');

            // 5. Simpan path/nama file ke database
            $destination->image = $path;
        }

        $destination->name = $request->name;
        $destination->location = $request->location;
        $destination->price = $request->price;
        $destination->description = $request->description;

        // Logika jika user mengganti gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($destination->image) {
                Storage::disk('public')->delete($destination->image);
            }
            // Simpan gambar baru
            $path = $request->file('image')->store('destinations', 'public');
            $destination->image = $path;
        }

        $destination->save();

        return redirect()->route('destinations.index')->with('success', 'Destinasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);

        // 1. Hapus file gambar dari storage agar tidak membebani memori laptop
        if ($destination->image) {
            Storage::disk('public')->delete($destination->image);
        }

        // 2. Hapus data dari database
        $destination->delete();

        return redirect()->back()->with('success', 'Destinasi berhasil dihapus!');
    }
}
