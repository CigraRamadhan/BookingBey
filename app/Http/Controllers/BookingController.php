<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // Form booking
    public function create()
    {
        $lapangan = Lapangan::where('status', 'tersedia')->get();
        return view('booking.create', compact('lapangan'));
    }

    // Store booking
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'catatan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lapangan = Lapangan::findOrFail($request->lapangan_id);
        
        // Cek duplikasi
        $cek = Booking::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where('jam_mulai', $request->jam_mulai)
            ->whereIn('status_booking', ['menunggu', 'konfirmasi'])
            ->exists();

        if ($cek) {
            return redirect()->back()
                ->with('error', 'Jam tersebut sudah dibooking!')
                ->withInput();
        }

        $durasi = 1;
        $jam_selesai = date('H:i:s', strtotime($request->jam_mulai . ' +' . $durasi . ' hours'));
        $total_harga = $lapangan->harga_per_jam * $durasi;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'lapangan_id' => $request->lapangan_id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $jam_selesai,
            'durasi' => $durasi,
            'harga_per_jam' => $lapangan->harga_per_jam,
            'total_harga' => $total_harga,
            'status_booking' => 'menunggu',
            'catatan' => $request->catatan,
        ]);

        // Auto create payment
        Payment::create([
            'booking_id' => $booking->id,
            'kode_pembayaran' => Payment::generateKode(),
            'metode_pembayaran' => 'cash',
            'jumlah_bayar' => $total_harga,
            'status_pembayaran' => 'pending',
        ]);

        return redirect()->route('booking.show', $booking->id)
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
    }

    // Riwayat booking
    public function index()
    {
        $booking = Booking::where('user_id', Auth::id())
            ->with(['lapangan', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('booking.index', compact('booking'));
    }

    // Detail booking
    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->with(['lapangan', 'payment'])
            ->findOrFail($id);
        
        return view('booking.show', compact('booking'));
    }

    // Cancel booking
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('status_booking', 'menunggu')
            ->findOrFail($id);
        
        $booking->update(['status_booking' => 'batal']);
        
        // Update payment
        if ($booking->payment) {
            $booking->payment->update(['status_pembayaran' => 'failed']);
        }

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    // Upload bukti pembayaran
    public function uploadBukti(Request $request, $id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('status_booking', 'menunggu')
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('bukti_pembayaran');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/bukti', $nama_file);

        $booking->payment->update([
            'bukti_pembayaran' => $nama_file,
            'status_pembayaran' => 'pending',
        ]);

        return redirect()->route('booking.show', $booking->id)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }

    // Admin: list booking
    public function adminIndex()
    {
        $booking = Booking::with(['user', 'lapangan', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('booking.admin-index', compact('booking'));
    }

    // Admin: update status
    public function adminUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status_booking' => 'required|in:menunggu,konfirmasi,selesai,batal'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status_booking' => $request->status_booking]);

        // Update payment status jika booking selesai
        if ($request->status_booking == 'selesai' && $booking->payment) {
            $booking->payment->update([
                'status_pembayaran' => 'paid',
                'tanggal_bayar' => date('Y-m-d'),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Status booking berhasil diupdate!');
    }

    // Admin: update payment status
    public function adminUpdatePayment(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,paid,failed'
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update([
            'status_pembayaran' => $request->status_pembayaran,
            'tanggal_bayar' => $request->status_pembayaran == 'paid' ? date('Y-m-d') : null,
        ]);

        return redirect()->back()
            ->with('success', 'Status pembayaran berhasil diupdate!');
    }
}