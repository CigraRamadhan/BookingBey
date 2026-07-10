<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'lapangan', 'payment'])
            ->latest()
            ->paginate(10);

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

        return redirect()
            ->route('admin.booking.index')
            ->with('success', 'Status booking berhasil diperbarui.');
    }
}