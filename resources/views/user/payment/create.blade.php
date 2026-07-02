@extends('user.layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-credit-card"></i> Pembayaran Booking</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h5>Detail Booking</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Lapangan:</strong> {{ $booking->lapangan->nama }}</p>
                            <p><strong>Tanggal:</strong> {{ date('d F Y', strtotime($booking->tanggal_booking)) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Jam:</strong> {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</p>
                            <p><strong>Total Harga:</strong> <span class="fw-bold text-success">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.payment.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <input type="hidden" name="amount" value="{{ $booking->total_harga }}">

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="bank_transfer">🏦 Bank Transfer</option>
                            <option value="credit_card">💳 Kartu Kredit</option>
                            <option value="e_wallet">📱 E-Wallet</option>
                            <option value="cash">💵 Tunai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Pembayaran</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" value="{{ number_format($booking->total_harga, 0, ',', '.') }}" readonly>
                        </div>
                        <small class="text-muted">Jumlah pembayaran sesuai dengan total harga booking.</small>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong> Setelah melakukan pembayaran, Anda harus mengkonfirmasi pembayaran di halaman detail pembayaran.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Bayar Sekarang
                        </button>
                        <a href="{{ route('user.booking.show', $booking->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection