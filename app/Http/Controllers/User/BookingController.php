<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('lapangan')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.booking.index', compact('bookings'));
    }

    public function create($lapangan_id)
    {
        $lapangan = Lapangan::findOrFail($lapangan_id);
        return view('user.booking.create', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Ambil data lapangan
        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        // Hitung durasi
        $mulai = strtotime($request->jam_mulai);
        $selesai = strtotime($request->jam_selesai);

        $durasi = ($selesai - $mulai) / 3600;

        // Hitung total harga
        $totalHarga = $lapangan->harga_per_jam * $durasi;

        // Simpan booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $lapangan->id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi' => $durasi,
            'harga_per_jam' => $lapangan->harga_per_jam,
            'total_harga' => $totalHarga,
            'status_booking' => 'menunggu',
        ]);

        return redirect()
            ->route('user.booking.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat!');
    }

    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->with('lapangan')
            ->findOrFail($id);
        return view('user.booking.show', compact('booking'));
    }
}