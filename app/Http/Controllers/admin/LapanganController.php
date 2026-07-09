<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
        return response()->json($lapangan);
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis' => 'required',
            'lokasi' => 'required',
            'harga_per_jam' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($lapangan->gambar && Storage::disk('public')->exists($lapangan->gambar)) {
                Storage::disk('public')->delete($lapangan->gambar);
            }

            $validated['gambar'] = $request
                ->file('gambar')
                ->store('lapangan', 'public');
        }

        $lapangan->update($validated);

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Lapangan $lapangan)
    {
        if ($lapangan->gambar) {
            Storage::disk('public')->delete($lapangan->gambar);
        }

        $lapangan->delete();

        return redirect()
            ->route('admin.lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus.');
    }
}
