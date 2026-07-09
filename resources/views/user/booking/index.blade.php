@extends('user.layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-check"></i> Riwayat Booking</h4>
                </div>
                <div class="card-body">
                    @if($bookings->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x"></i>
                            <p class="mt-2">Belum ada booking. Silahkan booking lapangan sekarang!</p>
                            <a href="{{ route('user.lapangan.index') }}" class="btn btn-primary">
                                <i class="fas fa-table-tennis"></i> Lihat Lapangan
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Lapangan</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Durasi</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $booking->lapangan->nama }}</td>
                                            <td>{{ date('d/m/Y', strtotime($booking->tanggal_booking)) }}</td>
                                            <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                                            <td>{{ $booking->durasi }} jam</td>
                                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'info' : ($booking->status === 'completed' ? 'success' : 'danger')) }}">
                                                    {{ $booking->status_badge }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.booking.show', $booking->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection