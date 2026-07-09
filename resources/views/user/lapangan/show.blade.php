@extends('user.layouts.app')

@section('title', 'Detail Lapangan')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-info-circle"></i> Detail Lapangan</h4>
                </div>
                <div class="card-body">
                    @if($lapangan->gambar)
                        <img src="{{ asset('storage/' . $lapangan->gambar) }}" class="img-fluid rounded mb-3"
                            alt="{{ $lapangan->nama }}">
                    @endif

                    <h3>{{ $lapangan->nama }}</h3>
                    <p>{{ $lapangan->deskripsi }}</p>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="fas fa-money-bill-wave text-success"></i>
                                <span class="ms-2">Harga: Rp
                                    {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}/jam</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <span class="ms-2">Lokasi: {{ $lapangan->lokasi }}</span>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="info-box">
                                <i class="fas fa-info-circle text-info"></i>
                                <span class="ms-2">Status:
                                    <span class="badge bg-{{ $lapangan->status === 'available' ? 'success' : 'danger' }}">
                                        {{ $lapangan->status_badge }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-plus"></i> Booking</h5>
                </div>
                <div class="card-body">
                    @if($lapangan->status === 'tersedia')
                        <a href="{{ route('user.booking.create', $lapangan->id) }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-calendar-check"></i> Booking Sekarang
                        </a>
                    @else
                        <div class="alert alert-danger text-center">
                            <i class="fas fa-times-circle"></i>
                            <p class="mt-2">Lapangan sedang tidak tersedia</p>
                        </div>
                    @endif

                    <hr>
                    <div class="text-center">
                        <a href="{{ route('user.lapangan.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-box {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
@endsection