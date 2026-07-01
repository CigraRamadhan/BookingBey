@extends('layouts.app')

@section('title', $lapangan->nama_lapangan)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('lapangan.index') }}">Lapangan</a></li>
            <li class="breadcrumb-item active">{{ $lapangan->nama_lapangan }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Gambar -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <img src="{{ $lapangan->gambar_url }}" class="card-img-top" alt="{{ $lapangan->nama_lapangan }}" 
                     style="height: 400px; object-fit: cover; border-radius: 15px 15px 0 0;">
                <div class="card-body">
                    <span class="badge {{ $lapangan->status == 'tersedia' ? 'bg-success' : 'bg-danger' }} fs-6">
                        {{ $lapangan->status == 'tersedia' ? '✅ Tersedia' : '❌ Tidak Tersedia' }}
                    </span>
                    <span class="badge bg-info fs-6">
                        <i class="fas fa-map-marker-alt"></i> {{ $lapangan->lokasi }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">{{ $lapangan->nama_lapangan }}</h2>
                    
                    <div class="mb-3">
                        <h5 class="text-primary">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}</h5>
                        <small class="text-muted">/ jam</small>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fas fa-map-marker-alt text-danger"></i> Lokasi</h6>
                        <p class="text-muted">{{ $lapangan->lokasi }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Deskripsi</h6>
                        <p class="text-muted">{{ $lapangan->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    </div>

                    <!-- Form Booking -->
                    @if($lapangan->status == 'tersedia')
                        <form action="{{ route('booking.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tanggal</label>
                                    <input type="date" name="tanggal_booking" class="form-control" 
                                           min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jam Mulai</label>
                                    <select name="jam_mulai" class="form-select" required>
                                        <option value="">Pilih Jam</option>
                                        @foreach($jam_tersedia as $jam)
                                            <option value="{{ $jam }}">{{ $jam }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">*Durasi minimal 1 jam</small>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label fw-bold">Catatan (Opsional)</label>
                                <textarea name="catatan" class="form-control" rows="2" placeholder="Tulis catatan tambahan..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 mt-3">
                                <i class="fas fa-calendar-check"></i> Booking Sekarang
                            </button>
                        </form>
                    @else
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-circle"></i> Lapangan sedang tidak tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection