@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    {{-- ============================================
    HEADER / GREETING
    ============================================ --}}
    @php
        $hour = now()->format('H');

        if ($hour < 12) {
            $greeting = '🌅 Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = '☀️ Selamat Siang';
        } elseif ($hour < 18) {
            $greeting = '🌇 Selamat Sore';
        } else {
            $greeting = '🌙 Selamat Malam';
        }
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                {{ $greeting }}, {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}
            </h3>
            <p class="text-muted mb-0">
                Kelola booking lapangan Anda dengan mudah.
            </p>
        </div>
        <div class="text-end">
            <small class="text-muted">
                {{ now()->translatedFormat('l, d F Y') }}
            </small>
        </div>
    </div>

    {{-- ============================================
    STATISTIK CARD
    ============================================ --}}
    @php
        $totalBooking = $bookings->count();
        $bookingHariIni = $bookings->where('tanggal', now()->toDateString())->count();
        $pending = $bookings->where('status', 'pending')->count();
        $selesai = $bookings->where('status', 'selesai')->count();
        $batal = $bookings->where('status', 'batal')->count();
        $totalPembayaran = $bookings->sum('total_harga');
    @endphp

    <div class="row g-4 mb-4">
        {{-- Booking Hari Ini --}}
        <div class="col-md-3 col-6">
            <div class="card dashboard-shadow rounded-4 border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Booking Hari Ini</small>
                            <h2 class="mb-0 fw-bold">{{ $bookingHariIni }}</h2>
                        </div>
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-calendar-day fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-md-3 col-6">
            <div class="card dashboard-shadow rounded-4 border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Pending</small>
                            <h2 class="mb-0 fw-bold">{{ $pending }}</h2>
                        </div>
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-spinner fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="col-md-3 col-6">
            <div class="card dashboard-shadow rounded-4 border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Selesai</small>
                            <h2 class="mb-0 fw-bold">{{ $selesai }}</h2>
                        </div>
                        <div class="icon-circle bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pembayaran --}}
        <div class="col-md-3 col-6">
            <div class="card dashboard-shadow rounded-4 border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Pembayaran</small>
                            <h5 class="mb-0 fw-bold">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</h5>
                        </div>
                        <div class="icon-circle bg-success bg-opacity-10 text-success">
                            <i class="fas fa-money-bill-wave fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================
    PROGRESS BOOKING
    ============================================ --}}
    @php
        $total = max($bookings->count(), 1);
        $persen = ($selesai / $total) * 100;
    @endphp

    <div class="card dashboard-shadow rounded-4 border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-3">
                <i class="fas fa-chart-pie text-primary me-2"></i>
                Progress Booking
            </h5>
            <div class="progress" style="height: 12px; border-radius: 10px;">
                <div class="progress-bar bg-success" style="width: {{ $persen }}%; border-radius: 10px;">
                </div>
            </div>
            <small class="text-muted mt-2 d-block">
                {{ round($persen) }}% booking selesai dari {{ $total }} total booking
            </small>
        </div>
    </div>

    {{-- ============================================
    STATISTIK CHART + QUICK ACTION
    ============================================ --}}
    <div class="row g-4 mb-4">
        {{-- Chart --}}
        <div class="col-lg-8">
            <div class="card dashboard-shadow rounded-4 border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Statistik Booking
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="bookingChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Quick Action --}}
        <div class="col-lg-4">
            <div class="card dashboard-shadow rounded-4 border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Quick Action
                    </h5>
                </div>
                <div class="card-body d-grid gap-3">
                    <a href="{{ route('user.lapangan.index') }}" class="btn btn-primary btn-lg rounded-3 py-3">
                        <i class="fas fa-table-tennis me-2"></i> Cari Lapangan
                    </a>
                    <a href="{{ route('user.booking.index') }}" class="btn btn-success btn-lg rounded-3 py-3">
                        <i class="fas fa-calendar-check me-2"></i> Booking Saya
                    </a>
                    <a href="{{ route('user.profile') }}" class="btn btn-dark btn-lg rounded-3 py-3">
                        <i class="fas fa-user me-2"></i> Profil Saya
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================
    RIWAYAT BOOKING TERBARU
    ============================================ --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-history me-2"></i>
                Booking Terbaru
            </h5>
            <a href="{{ route('user.booking.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings->take(5) as $booking)
                        <tr>
                            <td>
                                @php
                                    $namaLapangan = '-';
                                    if ($booking->lapangan) {
                                        if (is_string($booking->lapangan) && strpos($booking->lapangan, '{') === 0) {
                                            $data = json_decode($booking->lapangan, true);
                                            $namaLapangan = $data['nama_lapangan'] ?? '-';
                                        } elseif (is_object($booking->lapangan)) {
                                            $namaLapangan = $booking->lapangan->nama_lapangan ?? '-';
                                        } else {
                                            $namaLapangan = $booking->lapangan;
                                        }
                                    }
                                @endphp
                                {{ $namaLapangan }}
                            </td>
                            <td>{{ date('d-m-Y', strtotime($booking->tanggal_booking ?? $booking->tanggal)) }}</td>
                            <td>{{ $booking->jam_mulai ?? '-' }} - {{ $booking->jam_selesai ?? '-' }}</td>
                            <td>Rp {{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $status = $booking->status ?? 'pending';
                                @endphp
                                @if($status == 'pending' || $status == 'Menunggu')
                                    <span class="badge rounded-pill bg-warning text-dark">Pending</span>
                                @elseif($status == 'selesai' || $status == 'Konfirmasi')
                                    <span class="badge rounded-pill bg-success">Selesai</span>
                                @elseif($status == 'batal' || $status == 'Batal')
                                    <span class="badge rounded-pill bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">{{ $status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted d-block mb-2"></i>
                                <span class="text-muted">Belum ada booking.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ============================================
STYLE TAMBAHAN
============================================ --}}
<style>
    .dashboard-shadow {
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }
    .dashboard-shadow:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.10);
        transform: translateY(-2px);
    }
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-bar {
        transition: width 0.8s ease;
    }
    .btn-lg {
        font-weight: 600;
    }
</style>

{{-- ============================================
CHART SCRIPT
============================================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari controller
        const chartData = @json($chartData ?? collect([]));

        const ctx = document.getElementById('bookingChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.keys ? Object.keys(chartData) : [],
                datasets: [{
                    label: 'Jumlah Booking',
                    data: chartData.values ? Object.values(chartData) : [],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>

@endsection