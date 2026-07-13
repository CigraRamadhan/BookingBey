<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $totalLapangan = Lapangan::count();
        $totalBooking = Booking::count();
        $totalUser = User::where('role', 'user')->count();

        $totalRevenue = Payment::where('status_pembayaran', 'paid')
            ->sum('jumlah_bayar');

        $latestBookings = Booking::with(['user', 'lapangan'])
            ->latest()
            ->take(5)
            ->get();

        $bookingChart = Booking::select(
            DB::raw('MONTH(tanggal_booking) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $total = [];

        foreach ($bookingChart as $item) {
            $bulan[] = date('M', mktime(0, 0, 0, $item->bulan, 1));
            $total[] = $item->total;
        }

        return view('admin.dashboard', compact(
            'totalLapangan',
            'totalBooking',
            'totalUser',
            'totalRevenue',
            'latestBookings',
            'bulan',
            'total'
        ));
    }
}