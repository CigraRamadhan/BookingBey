<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLapangan = Lapangan::count();
        $totalBooking = Booking::count();
        $totalUsers = User::where('role', 'user')->count();
        $revenue = Payment::where('status_pembayaran', 'paid')->sum('jumlah_bayar');

        $bookingTerbaru = Booking::with(['user', 'lapangan'])
            ->latest()
            ->take(5)
            ->get();

        // Statistik booking per bulan untuk tahun berjalan
        $bookingPerBulan = Booking::selectRaw('MONTH(tanggal_booking) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_booking', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $chartLabels = [];
        $chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $namaBulan[$i - 1];
            $chartData[] = $bookingPerBulan[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalLapangan',
            'totalBooking',
            'totalUsers',
            'revenue',
            'bookingTerbaru',
            'chartLabels',
            'chartData'
        ));
    }
}