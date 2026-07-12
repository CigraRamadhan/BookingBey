@extends('user.layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
<div class="card shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row">

                <div class="col-md-5">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari lapangan..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-3">

                    @foreach($bookings as $booking)
                        {{ $booking->status_booking }}

                        @endforeach
                    
                        @if($booking->status_booking == 'pending')
                    <span class="badge bg-warning">
                        Pending
                    </span>

                    @elseif($booking->status_booking=='selesai')

                    <span class="badge bg-success">
                        Selesai
                    </span>

                    @else

                    <span class="badge bg-danger">
                        Dibatalkan
                    </span>

                    @endif

                </div>

                <div class="col-md-2">

                    <button class="btn btn-primary w-100">

                        Cari

                    </button>

                </div>

                <div class="col-md-2">

                    <a
                        href="{{ route('user.booking.index') }}"
                        class="btn btn-secondary w-100">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Booking Saya</h2>
        <a href="{{ route('user.lapangan.index') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Booking Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki booking. <a href="{{ route('user.booking.create') }}">Booking sekarang!</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->lapangan->nama_lapangan ?? 'N/A' }}</td>
                        <td>{{ $booking->tanggal_booking }}</td>
                        <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                        <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $booking->status_booking == 'menunggu' ? 'warning' : ($booking->status_booking == 'konfirmasi' ? 'info' : ($booking->status_booking == 'selesai' ? 'success' : 'danger')) }}">
                                {{ ucfirst($booking->status_booking) }}
                            </span>
                        </td>
                        <td>

                    <a
                    href="{{ route('user.booking.show',$booking->id) }}"
                    class="btn btn-info btn-sm">

                    Detail

                    </a>

                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $bookings->links() }}
    @endif
</div>
@endsection