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

                            12

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

                            153

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

                            67

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

                            Rp12.500.000

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

                        <tr>

                            <td>Andi</td>

                            <td>Futsal A</td>

                            <td>12 Juli 2026</td>

                            <td>

                                <span class="badge bg-success">

                                    Approved

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <td>Budi</td>

                            <td>Badminton B</td>

                            <td>13 Juli 2026</td>

                            <td>

                                <span class="badge bg-warning">

                                    Pending

                                </span>

                            </td>

                        </tr>

                        <tr>

                            <td>Siti</td>

                            <td>Basket Indoor</td>

                            <td>15 Juli 2026</td>

                            <td>

                                <span class="badge bg-danger">

                                    Cancelled

                                </span>

                            </td>

                        </tr>

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

                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],

                datasets: [{

                    label: 'Booking',

                    data: [12, 19, 8, 15, 30, 26],

                    borderWidth: 3,

                    fill: false,

                    tension: .4

                }]

            }

        });

        new Chart(ctx, {

            type: 'line',

            data: { ...},

            options: {

                responsive: true,

                maintainAspectRatio: false

            }

                options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        
    </script>

@endsection