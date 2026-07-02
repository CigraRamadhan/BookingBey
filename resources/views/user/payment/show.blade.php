@extends('user.layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-receipt"></i> Detail Pembayaran</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="display-4">
                        @if($payment->status === 'confirmed')
                            <span class="text-success"><i class="fas fa-check-circle"></i></span>
                        @elseif($payment->status === 'pending')
                            <span class="text-warning"><i class="fas fa-clock"></i></span>
                        @else
                            <span class="text-danger"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </h2>
                    <h3 class="mt-2">{{ $payment->status_label }}</h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted">ID Pembayaran</label>
                            <p><strong>#{{ $payment->id }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Booking ID</label>
                            <p><strong>#{{ $payment->booking_id }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Lapangan</label>
                            <p><strong>{{ $payment->booking->lapangan->nama }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Jumlah Pembayaran</label>
                            <p><strong class="text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="text-muted">Metode Pembayaran</label>
                            <p><strong>{{ $payment->payment_method_label }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Status</label>
                            <p>
                                <span class="badge bg-{{ $payment->status === 'pending' ? 'warning' : ($payment->status === 'confirmed' ? 'success' : 'danger') }} fs-6">
                                    {{ $payment->status_label }}
                                </span>
                            </p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Tanggal Pembayaran</label>
                            <p><strong>{{ $payment->payment_date ? date('d F Y H:i', strtotime($payment->payment_date)) : '-' }}</strong></p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted">Dibuat Pada</label>
                            <p><strong>{{ $payment->created_at->format('d F Y H:i') }}</strong></p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Booking</h6>
                            <p class="mb-0">
                                <strong>Tanggal:</strong> {{ date('d F Y', strtotime($payment->booking->tanggal_booking)) }} | 
                                <strong>Jam:</strong> {{ $payment->booking->jam_mulai }} - {{ $payment->booking->jam_selesai }} |
                                <strong>Durasi:</strong> {{ $payment->booking->durasi }} jam
                            </p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('user.payment.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                    </a>
                    
                    <div>
                        @if($payment->status === 'pending')
                            <a href="{{ route('user.payment.confirm', $payment->id) }}" 
                               class="btn btn-success me-2"
                               onclick="return confirm('Yakin ingin mengkonfirmasi pembayaran ini?')">
                                <i class="fas fa-check"></i> Konfirmasi Pembayaran
                            </a>
                            <a href="{{ route('user.payment.cancel', $payment->id) }}" 
                               class="btn btn-danger"
                               onclick="return confirm('Yakin ingin membatalkan pembayaran ini?')">
                                <i class="fas fa-times"></i> Batalkan
                            </a>
                        @endif
                    </div>
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
    color: #6c757d;
}
.info-item p {
    margin-bottom: 0;
    font-size: 1.1rem;
}
</style>
@endsection