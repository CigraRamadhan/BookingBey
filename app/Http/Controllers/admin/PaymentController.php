<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'booking.user',
            'booking.lapangan'
        ])->latest()->paginate(10);

        return view('admin.payment.index', compact('payments'));
    }
}