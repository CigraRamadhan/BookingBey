<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $bookings = Booking::with('lapangan')
            ->where('user_id', $userId)
            ->orderBy('tanggal_booking', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $todayCount = $bookings
            ->where('tanggal_booking', now()->toDateString())
            ->count();

        $pendingCount = $bookings->where('status_booking', 'menunggu')->count();
        $selesaiCount = $bookings->where('status_booking', 'selesai')->count();
        $totalBayar = $bookings->sum('total_harga');

        return view('user.dashboard.index', compact(
            'bookings',
            'todayCount',
            'pendingCount',
            'selesaiCount',
            'totalBayar'
        ));
    }
}