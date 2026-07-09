@extends('layouts.admin')

@section('title', 'Payment')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Data Payment
            </h2>

            <small class="text-muted">
                Kelola pembayaran customer.
            </small>

        </div>

    </div>

    <div class="card dashboard-card">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Customer</th>

                        <th>Lapangan</th>

                        <th>Total</th>

                        <th>Metode</th>

                        <th>Status</th>

                        <th width="180">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($payments as $payment)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $payment->booking->user->nama_lengkap }}</td>

                            <td>{{ $payment->booking->lapangan->nama_lapangan }}</td>

                            <td>

                                Rp {{ number_format($payment->jumlah_bayar,0,',','.') }}

                            </td>

                            <td>

                                {{ $payment->metode_pembayaran }}

                            </td>

                            <td>

                                @if($payment->status_pembayaran == 'pending')

                                    <span class="badge bg-warning">
                                        Pending
                                    </span>

                                @elseif($payment->status_pembayaran == 'paid')

                                    <span class="badge bg-success">
                                        Paid
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Failed
                                    </span>

                                @endif

                            </td>

                            <td>

                                <button class="btn btn-info btn-sm">

                                    <i class="bi bi-eye"></i>

                                </button>

                                <button class="btn btn-success btn-sm">

                                    <i class="bi bi-check-lg"></i>

                                </button>

                                <button class="btn btn-danger btn-sm">

                                    <i class="bi bi-x-lg"></i>

                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center">

                                Belum ada data pembayaran.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $payments->links() }}

        </div>

    </div>

@endsection