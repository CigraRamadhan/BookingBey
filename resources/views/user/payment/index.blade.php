@extends('user.layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-credit-card"></i> Riwayat Pembayaran</h4>
                <span class="badge bg-light text-dark">Total: {{ $payments->count() }}</span>
            </div>
            <div class="card-body">
                @if($payments->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle fa-2x"></i>
                        <p class="mt-2">Belum ada riwayat pembayaran.</p>
                        <a href="{{ route('user.lapangan.index') }}" class="btn btn-primary">
                            <i class="fas fa-table-tennis"></i> Booking Lapangan
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking ID</th>
                                    <th>Lapangan</th>
                                    <th>Jumlah</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>#{{ $payment->booking_id }}</td>
                                        <td>{{ $payment->booking->lapangan->nama }}</td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $payment->payment_method_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $payment->status === 'pending' ? 'warning' : ($payment->status === 'confirmed' ? 'success' : 'danger') }}">
                                                {{ $payment->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('user.payment.show', $payment->id) }}" 
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