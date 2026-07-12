<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Notification;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['user', 'lapangan']);

        if ($request->filled('search')) {

            $search = $request->search;

            $bookings->where(function ($query) use ($search) {

                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%");
                })

                    ->orWhereHas('lapangan', function ($q) use ($search) {
                        $q->where('nama_lapangan', 'like', "%{$search}%");
                    })

                    ->orWhere('status_booking', 'like', "%{$search}%");

            });
        }

        $bookings = $bookings->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.booking.index', compact('bookings'));
    }

    public function show(Booking $booking) // <- Tambahkan method show
    {
        $booking->load(['user', 'lapangan', 'payment']);
        return view('admin.booking.show', compact('booking'));
    }
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status_booking' => 'required|in:menunggu,konfirmasi,selesai,batal',
        ]);

        $booking->update([
            'status_booking' => $request->status_booking,
        ]);

        $labelStatus = [
            'menunggu' => 'Menunggu',
            'konfirmasi' => 'Dikonfirmasi',
            'selesai' => 'Selesai',
            'batal' => 'Dibatalkan',
        ][$request->status_booking] ?? $request->status_booking;

        Notification::kirim(
            $booking->user_id,
            $booking->id,
            'Status Booking Diperbarui',
            'Booking lapangan ' . ($booking->lapangan->nama_lapangan ?? '') . ' pada tanggal ' .
                $booking->tanggal_booking . ' sekarang berstatus "' . $labelStatus . '".'
        );

        return redirect()
            ->route('admin.booking.index')
            ->with('success', 'Status booking berhasil diperbarui.');
    }
}