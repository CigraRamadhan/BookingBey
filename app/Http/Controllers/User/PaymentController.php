<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar pembayaran milik user
     */
    public function index()
    {
        $payments = Payment::with(['booking.lapangan'])
            ->whereHas('booking', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('user.payment.index', compact('payments'));
    }

    /**
     * Menampilkan form pembayaran
     */
    public function create($booking_id)
    {
        $booking = Booking::with('lapangan')->findOrFail($booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment()->exists()) {
            return redirect()
                ->route('user.payment.show', $booking->payment->id)
                ->with('info', 'Pembayaran untuk booking ini sudah dibuat.');
        }

        return view('user.payment.create', compact('booking'));
    }

    /**
     * Menyimpan pembayaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'metode_pembayaran' => 'required|in:cash,transfer,qris',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment()->exists()) {
            return redirect()
                ->route('user.payment.show', $booking->payment->id)
                ->with('info', 'Pembayaran sudah tersedia.');
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'kode_pembayaran' => 'PAY-' . strtoupper(uniqid()),
            'metode_pembayaran' => $request->metode_pembayaran,
            'jumlah_bayar' => $booking->total_harga,
            'status_pembayaran' => 'pending',
        ]);

        return redirect()
            ->route('user.payment.show', $payment->id)
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    /**
     * Detail pembayaran
     */
    public function show($id)
    {
        $payment = Payment::with(['booking.lapangan'])
            ->findOrFail($id);

        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.payment.show', compact('payment'));
    }

    /**
     * Konfirmasi pembayaran
     */
    public function confirm($id)
    {
        $payment = Payment::with('booking')->findOrFail($id);

        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->update([
            'status_pembayaran' => 'paid',
            'tanggal_bayar' => now(),
        ]);

        return redirect()
            ->route('user.payment.show', $payment->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    /**
     * Membatalkan pembayaran
     */
    public function cancel($id)
    {
        $payment = Payment::with('booking')->findOrFail($id);

        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->update([
            'status_pembayaran' => 'failed',
        ]);

        return redirect()
            ->route('user.payment.show', $payment->id)
            ->with('success', 'Pembayaran dibatalkan.');
    }
}