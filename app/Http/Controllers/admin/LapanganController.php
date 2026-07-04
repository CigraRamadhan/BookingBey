<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lapangan;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::latest()->paginate(10);

        return view('admin.lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'lokasi' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,tidak_tersedia',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('lapangan', 'public');
        }

        Lapangan::create($validated);

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan!');
    }
    public function show(Lapangan $lapangan)
    {
        //
    }

    public function edit(Lapangan $lapangan)
    {
        //
    }

    public function update(Lapangan $lapangan)
    {
        //
    }

    public function destroy(Lapangan $lapangan)
    {
        //
    }
}
