@extends('layouts.app')

@section('title', 'Booking Lapangan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-check"></i> Booking Lapangan</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Lapangan</label>
                            <select name="lapangan_id" class="form-select @error('lapangan_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Lapangan --</option>
                                @foreach($lapangan as $item)
                                    <option value="{{ $item->id }}" {{ request('lapangan') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_lapangan }} - {{ $item->lokasi }} (Rp {{ number_format($item->harga_per_jam, 0, ',', '.') }}/jam)
                                    </option>
                                @endforeach
                            </select>
                            @error('lapangan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal</label>
                                    <input type="date" name="tanggal_booking" class="form-control @error('tanggal_booking') is-invalid @enderror" 
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('tanggal_booking')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" required>
                                    <small class="text-muted">Durasi minimal 1 jam</small>
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis catatan tambahan..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> Booking Sekarang
                            </button>
                            <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection