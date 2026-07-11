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

                                Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}

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

                                <button class="btn btn-info btn-sm btn-detail" data-bs-toggle="modal"
                                    data-bs-target="#detailPayment" data-customer="{{ $payment->booking->user->nama_lengkap }}"
                                    data-lapangan="{{ $payment->booking->lapangan->nama_lapangan }}"
                                    data-kode="{{ $payment->kode_pembayaran }}" data-metode="{{ $payment->metode_pembayaran }}"
                                    data-total="{{ number_format($payment->jumlah_bayar, 0, ',', '.') }}"
                                    data-status="{{ $payment->status_pembayaran }}" data-tanggal="{{ $payment->tanggal_bayar }}"
                                    data-bukti="{{ $payment->bukti_pembayaran }}">
                                    <i class="bi bi-eye"></i>
                                </button>

                                @if($payment->status_pembayaran == 'pending')

                                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-success btn-sm"
                                            onclick="return confirm('Konfirmasi pembayaran ini?')">

                                            <i class="bi bi-check-lg"></i>

                                        </button>

                                    </form>

                                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Tolak pembayaran ini?')">

                                            <i class="bi bi-x-lg"></i>

                                        </button>

                                    </form>

                                @endif

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

    <!-- Modal Detail Payment -->

    <div class="modal fade" id="detailPayment" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Detail Payment
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <table class="table">

                        <tr>
                            <th width="200">Customer</th>
                            <td id="detail_customer"></td>
                        </tr>

                        <tr>
                            <th>Lapangan</th>
                            <td id="detail_lapangan"></td>
                        </tr>

                        <tr>
                            <th>Kode Pembayaran</th>
                            <td id="detail_kode"></td>
                        </tr>

                        <tr>
                            <th>Metode</th>
                            <td id="detail_metode"></td>
                        </tr>

                        <tr>
                            <th>Total Bayar</th>
                            <td id="detail_total"></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td id="detail_status"></td>
                        </tr>

                        <tr>
                            <th>Tanggal Bayar</th>
                            <td id="detail_tanggal"></td>
                        </tr>

                    </table>

                    <hr>

                    <h6>Bukti Pembayaran</h6>

                    <img id="detail_bukti" src="" class="img-fluid rounded border">

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>

        document.querySelectorAll('.btn-detail').forEach(button => {

            button.addEventListener('click', function () {

                document.getElementById('detail_customer').innerText = this.dataset.customer;
                document.getElementById('detail_lapangan').innerText = this.dataset.lapangan;
                document.getElementById('detail_kode').innerText = this.dataset.kode;
                document.getElementById('detail_metode').innerText = this.dataset.metode;
                document.getElementById('detail_total').innerText = "Rp " + this.dataset.total;
                document.getElementById('detail_status').innerText = this.dataset.status;
                document.getElementById('detail_tanggal').innerText = this.dataset.tanggal;

                if (this.dataset.bukti) {

                    document.getElementById('detail_bukti').src =
                        "/storage/" + this.dataset.bukti;

                } else {

                    document.getElementById('detail_bukti').src =
                        "https://placehold.co/600x300?text=Tidak+Ada+Bukti";

                }

            });

        });

    </script>

@endsection