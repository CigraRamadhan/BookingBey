@extends('layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
<div class="container py-4">
    <h2><i class="fas fa-history text-primary"></i> Riwayat Booking</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($booking->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted"></i>
                <h5 class="mt-3">Belum ada booking</h5>
                <p class="text-muted">Mulai booking lapangan sekarang!</p>
                <a href="{{ route('lapangan.index') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari Lapangan
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Lapangan</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Total</th>
                                <th>Status Booking</th>
                                <th>Status Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->lapangan->nama_lapangan }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->tanggal_booking)) }}</td>
                                <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>{!! $item->status_badge !!}</td>
                                <td>{!! $item->payment ? $item->payment->status_badge : '<span class="badge bg-secondary">N/A</span>' !!}</td>
                                <td>
                                    <a href="{{ route('booking.show', $item->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($item->status_booking == 'menunggu')
                                        <form action="{{ route('booking.cancel', $item->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Batalkan booking?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $booking->links() }}
            </div>
        </div>
    @endif
</div>
@endsection