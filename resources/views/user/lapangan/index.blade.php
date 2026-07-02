@extends('user.layouts.app')

@section('title', 'Daftar Lapangan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-table-tennis"></i> Daftar Lapangan</h4>
                <span class="badge bg-light text-dark">Total: {{ $lapangans->count() }}</span>
            </div>
            <div class="card-body">
                @if($lapangans->isEmpty())
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                        <p class="mt-2">Belum ada lapangan yang tersedia.</p>
                    </div>
                @else
                    <div class="row">
                        @foreach($lapangans as $lapangan)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    @if($lapangan->gambar)
                                        <img src="{{ asset('storage/' . $lapangan->gambar) }}" 
                                             class="card-img-top" alt="{{ $lapangan->nama }}" 
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white text-center py-5">
                                            <i class="fas fa-image fa-3x"></i>
                                            <p class="mt-2">No Image</p>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $lapangan->nama }}</h5>
                                        <p class="card-text">{{ Str::limit($lapangan->deskripsi, 100) }}</p>
                                        <div class="mb-2">
                                            <span class="badge bg-success">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}/jam</span>
                                            <span class="badge bg-info">{{ $lapangan->lokasi }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-{{ $lapangan->status === 'available' ? 'success' : 'danger' }}">
                                                {{ $lapangan->status_badge }}
                                            </span>
                                            <a href="{{ route('user.lapangan.show', $lapangan->id) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection