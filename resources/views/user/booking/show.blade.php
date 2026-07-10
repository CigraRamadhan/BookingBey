@extends('user.layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Booking</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-striped">
                        <tr>
                            <th width="40%">ID Booking</th>
                            <td>#{{ $booking->id }}</td>
                        </tr>
                        <tr>
                            <th>Lapangan</th>
                            <td>{{ $booking->lapangan->nama_lapangan ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Booking</th>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jam</th>
                            <td>{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}</td>
                        </tr>
                        <tr>
                            <th>Durasi</th>
                            <td>{{ $booking->durasi }} Jam</td>
                        </tr>
                        <tr>
                            <th>Harga per Jam</th>
                            <td>Rp {{ number_format($booking->harga_per_jam, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td><strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <th>Status Booking</th>
                            <td>
                                @php
                                    $statusClass = [
                                        'menunggu' => 'bg-warning text-dark',
                                        'konfirmasi' => 'bg-info text-white',
                                        'selesai' => 'bg-success text-white',
                                        'batal' => 'bg-danger text-white',
                                    ][$booking->status_booking] ?? 'bg-secondary text-white';
                                @endphp
                                <span class="badge {{ $statusClass }}" style="font-size: 14px; padding: 8px 15px;">
                                    {{ ucfirst($booking->status_booking) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Booking Dibuat</th>
                            <td>{{ $booking->created_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>

                    <!-- Informasi Pembayaran -->
                    <div class="mt-4">
                        <h4>Informasi Pembayaran</h4>
                        <hr>

                        @if($booking->payment)
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Kode Pembayaran</th>
                                    <td>{{ $booking->payment->kode_pembayaran }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ ucfirst($booking->payment->metode_pembayaran) }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Bayar</th>
                                    <td><strong>Rp {{ number_format($booking->payment->jumlah_bayar, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>
                                        @php
                                            $paymentStatusClass = [
                                                'pending' => 'bg-warning text-dark',
                                                'paid' => 'bg-success text-white',
                                                'failed' => 'bg-danger text-white',
                                            ][$booking->payment->status_pembayaran] ?? 'bg-secondary text-white';
                                        @endphp
                                        <span class="badge {{ $paymentStatusClass }}" style="font-size: 14px; padding: 8px 15px;">
                                            {{ ucfirst($booking->payment->status_pembayaran) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($booking->payment->tanggal_bayar)
                                <tr>
                                    <th>Tanggal Bayar</th>
                                    <td>{{ \Carbon\Carbon::parse($booking->payment->tanggal_bayar)->format('d F Y H:i') }}</td>
                                </tr>
                                @endif
                                @if($booking->payment->bukti_pembayaran)
                                <tr>
                                    <th>Bukti Pembayaran</th>
                                    <td>
                                        <a href="{{ asset('storage/' . $booking->payment->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary">
                                            Lihat Bukti
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            </table>

                            <!-- Form Pembayaran (jika status pending) -->
                            @if($booking->payment->status_pembayaran == 'pending')
                                <div class="card mt-3 border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <strong>⏳ Silakan Lakukan Pembayaran</strong>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('user.booking.payment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                                    <option value="">Pilih Metode</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="transfer">Transfer Bank</option>
                                                    <option value="qris">QRIS</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran (Opsional)</label>
                                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept="image/*">
                                                <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
                                            </div>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Bayar Sekarang
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @elseif($booking->payment->status_pembayaran == 'paid')
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    Pembayaran sudah dikonfirmasi. Terima kasih!
                                </div>
                            @elseif($booking->payment->status_pembayaran == 'failed')
                                <div class="alert alert-danger">
                                    <i class="fas fa-times-circle"></i>
                                    Pembayaran gagal. Silakan hubungi admin.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Belum ada data pembayaran.
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('user.booking.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if($booking->status_booking != 'batal')
                            <form action="{{ route('user.booking.cancel', $booking->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
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
</div>
@endsection