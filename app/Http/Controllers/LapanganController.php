<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LapanganController extends Controller
{
    // Daftar lapangan
    public function index()
    {
        $lapangan = Lapangan::orderBy('created_at', 'desc')->paginate(9);
        return view('lapangan.index', compact('lapangan'));
    }

    // Detail lapangan
    public function show($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        
        // Dapatkan jam tersedia
        $jam_tersedia = $this->getJamTersedia($lapangan);
        
        return view('lapangan.show', compact('lapangan', 'jam_tersedia'));
    }

    // Admin: create
    public function create()
    {
        return view('lapangan.create');
    }

    // Admin: store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lapangan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:tersedia,tidak_tersedia'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/lapangan', $nama_file);
            $data['gambar'] = $nama_file;
        }

        Lapangan::create($data);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan!');
    }

    // Admin: edit
    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('lapangan.edit', compact('lapangan'));
    }

    // Admin: update
    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_lapangan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:tersedia,tidak_tersedia'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($lapangan->gambar) {
                Storage::delete('public/lapangan/' . $lapangan->gambar);
            }
            $file = $request->file('gambar');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/lapangan', $nama_file);
            $data['gambar'] = $nama_file;
        }

        $lapangan->update($data);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil diupdate!');
    }

    // Admin: delete
    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        
        if ($lapangan->gambar) {
            Storage::delete('public/lapangan/' . $lapangan->gambar);
        }
        
        $lapangan->delete();

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus!');
    }

    // Fungsi bantu: get jam tersedia
    private function getJamTersedia($lapangan)
    {
        $jam = [];
        $start = 6;
        $end = 22;

        for ($i = $start; $i < $end; $i++) {
            $jam[] = sprintf("%02d:00", $i);
        }

        $bookings = Booking::where('lapangan_id', $lapangan->id)
            ->where('tanggal_booking', date('Y-m-d'))
            ->whereIn('status_booking', ['menunggu', 'konfirmasi'])
            ->get();

        $booked_jam = [];
        foreach ($bookings as $booking) {
            $booked_jam[] = date('H:i', strtotime($booking->jam_mulai));
        }

        return array_values(array_diff($jam, $booked_jam));
    }
}