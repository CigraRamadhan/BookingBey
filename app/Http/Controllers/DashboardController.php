<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Total booking
        $total_booking = Booking::where('user_id', $user->id)->count();
        
        // Booking aktif
        $booking_aktif = Booking::where('user_id', $user->id)
            ->whereIn('status_booking', ['menunggu', 'konfirmasi'])
            ->count();
        
        // Booking selesai
        $booking_selesai = Booking::where('user_id', $user->id)
            ->where('status_booking', 'selesai')
            ->count();
        
        // Booking terbaru
        $booking_terbaru = Booking::where('user_id', $user->id)
            ->with('lapangan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Total pengeluaran
        $total_pengeluaran = Booking::where('user_id', $user->id)
            ->where('status_booking', 'selesai')
            ->sum('total_harga');

        return view('dashboard', compact(
            'total_booking',
            'booking_aktif',
            'booking_selesai',
            'booking_terbaru',
            'total_pengeluaran'
        ));
    }
}