<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['lapangan', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
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
            'durasi' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
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
            'lapangan_id' => $request -> lapangan_id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'durasi' => $request->durasi,
            'harga_per_jam' => $lapangan->harga_per_jam,
            'total_harga' => $totalHarga,
            'status_booking' => 'menunggu',
            'catatan' => $request->catatan,
        ]);
         Payment::create([
            'booking_id' => $booking->id,
            'kode_pembayaran' => 'INV-' . date('Ymd') . '-' . $booking->id,
            'metode_pembayaran' => 'cash',
            'jumlah_bayar' => $totalHarga,
            'status_pembayaran' => 'pending',
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
     public function payment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:cash,transfer,qris',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $payment = $booking->payment;

        if (!$payment) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'kode_pembayaran' => 'INV-' . date('Ymd') . '-' . $booking->id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'jumlah_bayar' => $booking->total_harga,
                'status_pembayaran' => 'pending',
            ]);
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            $payment->bukti_pembayaran = $path;
        }

        $payment->metode_pembayaran = $request->metode_pembayaran;
        $payment->status_pembayaran = 'pending';
        $payment->save();

        return redirect()
            ->route('user.booking.show', $booking->id)
            ->with('success', 'Pembayaran sedang diproses. Menunggu konfirmasi admin.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status_booking == 'selesai') {
            return redirect()
                ->route('user.booking.show', $booking->id)
                ->with('error', 'Booking yang sudah selesai tidak bisa dibatalkan.');
        }

        $booking->update(['status_booking' => 'batal']);
        
        if ($booking->payment) {
            $booking->payment->update(['status_pembayaran' => 'failed']);
        }

        return redirect()
            ->route('user.booking.show', $booking->id)
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}
