@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-receipt"></i> Detail Booking</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5 class="text-muted">Status Booking</h5>
                        <h3>{!! $booking->status_badge !!}</h3>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6><i class="fas fa-user text-primary"></i> Informasi User</h6>
                                    <hr>
                                    <p><strong>Username:</strong> {{ $booking->user->username }}</p>
                                    <p><strong>Nama:</strong> {{ $booking->user->nama_lengkap }}</p>
                                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6><i class="fas fa-futbol text-success"></i> Informasi Lapangan</h6>
                                    <hr>
                                    <p><strong>Nama:</strong> {{ $booking->lapangan->nama_lapangan }}</p>
                                    <p><strong>Lokasi:</strong> {{ $booking->lapangan->lokasi }}</p>
                                    <p><strong>Harga/Jam:</strong> Rp {{ number_format($booking->harga_per_jam, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered mt-3">
                        <tr>
                            <th style="width: 40%;">Tanggal Booking</th>
                            <td>{{ date('d F Y', strtotime($booking->tanggal_booking)) }}</td>
                        </tr>
                        <tr>
                            <th>Jam</th>
                            <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>{{ $booking->durasi }} jam</td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td><strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $booking->catatan ?? 'Tidak ada catatan' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Booking</th>
                            <td>{{ date('d F Y H:i', strtotime($booking->created_at)) }}</td>
                        </tr>
                    </table>

                    <!-- Payment Section -->
                    @if($booking->payment)
                    <div class="card border-0 bg-light mt-3">
                        <div class="card-body">
                            <h5><i class="fas fa-credit-card text-warning"></i> Informasi Pembayaran</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Kode Pembayaran:</strong> <code>{{ $booking->payment->kode_pembayaran }}</code></p>
                                    <p><strong>Metode:</strong> {{ ucfirst($booking->payment->metode_pembayaran) }}</p>
                                    <p><strong>Jumlah Bayar:</strong> Rp {{ number_format($booking->payment->jumlah_bayar, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong> {!! $booking->payment->status_badge !!}</p>
                                    @if($booking->payment->tanggal_bayar)
                                        <p><strong>Tanggal Bayar:</strong> {{ date('d F Y', strtotime($booking->payment->tanggal_bayar)) }}</p>
                                    @endif
                                    @if($booking->payment->bukti_pembayaran)
                                        <p><strong>Bukti:</strong> 
                                            <a href="{{ $booking->payment->bukti_url }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-image"></i> Lihat Bukti
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Upload Bukti -->
                    @if($booking->status_booking == 'menunggu' && $booking->payment)
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <h5><i class="fas fa-upload text-primary"></i> Upload Bukti Pembayaran</h5>
                            <form action="{{ route('booking.upload-bukti', $booking->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
                                        <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('booking.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if($booking->status_booking == 'menunggu')
                            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan booking?')">
                                    <i class="fas fa-times"></i> Batalkan Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection