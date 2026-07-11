<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('lapangan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $chartData = Booking::select(
                DB::raw('MONTH(tanggal_booking) as bulan'),
                DB::raw('COUNT(*) as total_harga')
            )
            ->where('user_id', Auth::id())
            ->groupBy(DB::raw('MONTH(tanggal_booking)'))
            ->pluck('total_harga', 'bulan');

        return view('user.dashboard.index', compact(
            'bookings',
            'chartData'
        ));
    }
}