<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['booking.lapangan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.payment.index', compact('payments'));
    }

    public function create($booking_id)
    {
        $booking = Booking::with('lapangan')->findOrFail($booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment()->exists()) {
            return redirect()->route('user.payment.show', $booking->payment->id)
                ->with('info', 'Pembayaran untuk booking ini sudah ada.');
        }

        return view('user.payment.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:bank_transfer,credit_card,e_wallet,qris',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment()->exists()) {
            return redirect()->route('user.payment.show', $booking->payment->id)
                ->with('info', 'Pembayaran untuk booking ini sudah ada.');
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'amount' => $booking->total_harga,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return redirect()->route('user.payment.show', $payment->id)
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    public function show($id)
    {
        $payment = Payment::with(['booking.lapangan'])->findOrFail($id);

        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.payment.show', compact('payment'));
    }

    public function confirm($id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->update([
            'status' => 'confirmed',
            'payment_date' => now(),
        ]);

        return redirect()->route('user.payment.show', $payment->id)
            ->with('success', 'Pembayaran dikonfirmasi.');
    }

    public function cancel($id)
    {
        $payment = Payment::findOrFail($id);

        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $payment->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('user.payment.show', $payment->id)
            ->with('success', 'Pembayaran dibatalkan.');
    }
}
