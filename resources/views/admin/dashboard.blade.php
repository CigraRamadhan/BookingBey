@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="mb-4">

        <h2 class="fw-bold">
            Dashboard
        </h2>

        <p class="text-muted">
            Selamat datang di halaman Admin Booking Lapangan.
        </p>

    </div>

    {{-- Statistic Card --}}

    <div class="row g-4">

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card card p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Lapangan
                        </small>

                        <h2 class="fw-bold mt-2">

                            {{ $totalLapangan }}

                        </h2>

                    </div>

                    <div class="icon-box bg-primary">

                        <i class="bi bi-dribbble text-white"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card card p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Booking

                        </small>

                        <h2 class="fw-bold mt-2">

                            {{ $totalBooking }}

                        </h2>

                    </div>

                    <div class="icon-box bg-success">

                        <i class="bi bi-calendar-check text-white"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card card p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Users

                        </small>

                        <h2 class="fw-bold mt-2">

                            {{ $totalUsers }}

                        </h2>

                    </div>

                    <div class="icon-box bg-warning">

                        <i class="bi bi-people-fill text-white"></i>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card card p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">

                            Revenue

                        </small>

                        <h5 class="fw-bold mt-2">

                            Rp{{ number_format($revenue, 0, ',', '.') }}

                        </h5>

                    </div>

                    <div class="icon-box bg-danger">

                        <i class="bi bi-cash-stack text-white"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Booking Table --}}

    <div class="card dashboard-card mt-5">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">

                Booking Terbaru

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>Customer</th>

                            <th>Lapangan</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($bookingTerbaru as $booking)
                            <tr>

                                <td>{{ $booking->user->nama_lengkap ?? '-' }}</td>

                                <td>{{ $booking->lapangan->nama_lapangan ?? '-' }}</td>

                                <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d F Y') }}</td>

                                <td>
                                    {!! $booking->status_badge !!}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada data booking.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

    </div>

    {{-- Chart --}}

    <div class="card dashboard-card mt-5">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                Statistik Booking

            </h5>

        </div>

        <div style="position:relative;height:350px;">

            <canvas id="bookingChart" height="100"></canvas>

        </div>

    </div>

@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        const ctx = document.getElementById('bookingChart');

        new Chart(ctx, {

            type: 'line',

            data: {

                labels: {!! json_encode($chartLabels) !!},

                datasets: [{

                    label: 'Booking',

                    data: {!! json_encode($chartData) !!},

                    borderWidth: 3,

                    fill: false,

                    tension: .4

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false

            }

        });
        
    </script>

@endsection