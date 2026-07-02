@extends('user.layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-info-circle"></i> Detail Booking</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted">ID Booking</label>
                            <p><strong>#{{ $booking->id }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Lapangan</label>
                            <p><strong>{{ $booking->lapangan->nama }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Tanggal Booking</label>
                            <p><strong>{{ date('d F Y', strtotime($booking->tanggal_booking)) }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Jam</label>
                            <p><strong>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</strong></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted">Durasi</label>
                            <p><strong>{{ $booking->durasi }} Jam</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Total Harga</label>
                            <p><strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Status</label>
                            <p>
                                <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'info' : ($booking->status === 'completed' ? 'success' : 'danger')) }} fs-6">
                                    {{ $booking->status_badge }}
                                </span>
                            </p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Tanggal Booking</label>
                            <p><strong>{{ date('d F Y H:i', strtotime($booking->created_at)) }}</strong></p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.booking.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    
                    @if($booking->status === 'pending')
                        <form action="#" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan booking?')">
                                <i class="fas fa-times"></i> Batalkan Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    margin-bottom: 15px;
}
.info-item label {
    display: block;
    font-size: 0.9rem;
}
</style>
@endsection