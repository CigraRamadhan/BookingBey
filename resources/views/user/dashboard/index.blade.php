@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                Selamat Datang,
                {{ Auth::user()->nama_lengkap }}
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

    {{-- Statistik --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="icon blue">
                    <i class="fas fa-calendar-check"></i>
                </div>

                <div>

                    <small>Total Booking</small>

                    <h2>
                        {{ $bookings->count() }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="icon purple">
                    <i class="fas fa-calendar-day"></i>
                </div>

                <div>

                    <small>Booking Hari Ini</small>

                    <h2>

                        {{ $todayCount }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="icon orange">
                    <i class="fas fa-clock"></i>
                </div>

                <div>

                    <small>Menunggu</small>

                    <h2>

                        {{ $pendingCount }}

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="icon green">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div>

                    <small>Selesai</small>

                    <h2>

                        {{ $selesaiCount }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4 mb-4">

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="icon red">
                    <i class="fas fa-money-bill-wave"></i>
                </div>

                <div>

                    <small>Total Pembayaran</small>

                    <h4>

                        Rp
                        {{ number_format($totalBayar,0,',','.') }}

                    </h4>

                </div>

            </div>

        </div>

    </div>

    {{-- Quick Menu --}}

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <a href="{{ route('user.lapangan.index') }}"
               class="quick-card text-decoration-none">

                <i class="fas fa-table-tennis"></i>

                <h5>Lihat Lapangan</h5>

                <p>Cari lapangan yang tersedia.</p>

            </a>

        </div>

        <div class="col-md-4">

            <a href="{{ route('user.booking.index') }}"
               class="quick-card text-decoration-none">

                <i class="fas fa-calendar-plus"></i>

                <h5>Booking Saya</h5>

                <p>Lihat semua booking Anda.</p>

            </a>

        </div>

        <div class="col-md-4">

            <a href="{{ route('user.profile') }}"
               class="quick-card text-decoration-none">

                <i class="fas fa-user-circle"></i>

                <h5>Profil</h5>

                <p>Edit informasi akun Anda.</p>

            </a>

        </div>

    </div>

    {{-- Riwayat Booking --}}

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white">

            <h5 class="mb-0">

                <i class="fas fa-history me-2"></i>

                Booking Terbaru

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($bookings->take(5) as $booking)

                        <tr>

                            <td>

                                {{ $booking->lapangan->nama_lapangan ?? '-' }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y') }}

                            </td>

                            <td>

                                {!! $booking->status_badge !!}

                            </td>

                            <td>

                                Rp
                                {{ number_format($booking->total_harga,0,',','.') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4">

                                Belum ada booking.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection