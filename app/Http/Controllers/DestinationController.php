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

    public function show($id)
    {
        // Mengambil data destinasi atau return 404 jika tidak ditemukan
        $destination = Destination::findOrFail($id);

        return view('destinations.show', compact('destination'));
    }

    // Menampilkan form tambah destinasi
    public function create()
    {
        return view('destinations.create');
    }

    // Menyimpan destinasi baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Di sini wajib image
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('destinations', 'public');
        }

        Destination::create($data);

        return redirect()->route('destinations.index')->with('success', 'Destinasi baru berhasil ditambahkan!');
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

    /**
     * Memperbarui data destinasi di database.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $destination = Destination::findOrFail($id);

        // 2. Ambil semua data input kecuali gambar
        $data = $request->only(['name', 'description','location', 'price']);

        // 3. Logika Update Gambar
        if ($request->hasFile('image')) {
            // Opsional: Hapus gambar lama dari storage
            if ($destination->image && \Storage::disk('public')->exists($destination->image)) {
                \Storage::disk('public')->delete($destination->image);
            }

            // Simpan gambar baru ke array data
            $data['image'] = $request->file('image')->store('destinations', 'public');
        }

        // 4. Update SEKALIGUS (Data teks + Gambar jika ada)
        $destination->update($data);

        return redirect()->route('destinations.index')->with('success', 'Destinasi berhasil diperbarui!');
    }
}
