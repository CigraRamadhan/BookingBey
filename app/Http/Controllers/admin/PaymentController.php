<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['booking.user', 'booking.lapangan']);

        if ($request->filled('search')) {

            $search = $request->search;

            $payments->where(function ($query) use ($search) {

                $query->where('kode_pembayaran', 'like', "%{$search}%")

                    ->orWhere('metode_pembayaran', 'like', "%{$search}%")

                    ->orWhereHas('booking.user', function ($q) use ($search) {

                        $q->where('nama_lengkap', 'like', "%{$search}%");

                    })

                    ->orWhereHas('booking.lapangan', function ($q) use ($search) {

                        $q->where('nama_lapangan', 'like', "%{$search}%");

                    });

            });
        }

        $payments = $payments->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.payment.index', compact('payments'));
    }

    public function approve(Payment $payment)
    {
        $payment->update([
            'status_pembayaran' => 'paid',
            'tanggal_bayar' => now(),
        ]);

        $payment->booking->update([
            'status_booking' => 'konfirmasi',
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function reject(Payment $payment)
    {
        $payment->update([
            'status_pembayaran' => 'failed',
        ]);

        $payment->booking->update([
            'status_booking' => 'batal',
        ]);

        return back()->with('success', 'Pembayaran ditolak.');
    }
}