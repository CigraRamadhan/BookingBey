@extends('user.layouts.app')

@section('title', 'Dashboard - Sport Booking')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-bars me-2"></i> Menu Dashboard</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('user.lapangan.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-table-tennis me-2"></i> Lapangan
                    </a>
                    <a href="{{ route('user.booking.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check me-2"></i> Booking
                    </a>
                    <a href="{{ route('user.payment.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-credit-card me-2"></i> Payment
                    </a>
                    <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-id-card me-2"></i> Profil
                    </a>
                </div>
            </div>

            <div class="card border-0 bg-light mt-3">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-lightbulb me-2"></i> Tips</h6>
                    <p class="small mb-0">Pesan lapangan lebih awal untuk mendapatkan jadwal terbaik.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-home me-2"></i> Dashboard User</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Total Booking</h5>
                                    <h2 class="mb-0">{{ Auth::user()->bookings->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-warning text-dark h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Booking Pending</h5>
                                    <h2 class="mb-0">{{ Auth::user()->bookings->where('status', 'pending')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Booking Selesai</h5>
                                    <h2 class="mb-0">{{ Auth::user()->bookings->where('status', 'completed')->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-compass me-2"></i> Navigasi Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-sm-6 col-lg-3">
                                            <a href="{{ route('user.lapangan.index') }}" class="btn btn-outline-primary w-100 text-start">
                                                <i class="fas fa-table-tennis me-2"></i> Lihat Lapangan
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{ route('user.booking.index') }}" class="btn btn-outline-warning w-100 text-start">
                                                <i class="fas fa-calendar-check me-2"></i> Riwayat Booking
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{ route('user.payment.index') }}" class="btn btn-outline-success w-100 text-start">
                                                <i class="fas fa-credit-card me-2"></i> Pembayaran
                                            </a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary w-100 text-start">
                                                <i class="fas fa-id-card me-2"></i> Profil Saya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="alert alert-info mb-0">
                                <h5><i class="fas fa-info-circle me-2"></i> Informasi</h5>
                                <p class="mb-0">Selamat datang, {{ Auth::user()->name }}! Anda dapat melakukan booking lapangan melalui menu "Lapangan".</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
