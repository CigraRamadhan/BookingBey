@extends('layouts.admin')

@section('title', 'Data Booking')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">Data Booking</h2>
            <small class="text-muted">
                Kelola seluruh booking customer.
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

                        <th>Tanggal</th>

                        <th>Jam</th>

                        <th>Total</th>

                        <th>Status</th>

                        <th width="150">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($bookings as $booking)

                        <tr>

                            <td>
                                {{ $bookings->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $booking->user->nama_lengkap }}
                            </td>

                            <td>
                                {{ $booking->lapangan->nama_lapangan }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d-m-Y') }}
                            </td>

                            <td>

                                {{ substr($booking->jam_mulai, 0, 5) }}

                                -

                                {{ substr($booking->jam_selesai, 0, 5) }}

                            </td>

                            <td>

                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}

                            </td>

                            <td>

                                {!! $booking->status_badge !!}

                            </td>

                            <td>
                                <button class="btn btn-info btn-sm btn-detail" data-user="{{ $booking->user->nama_lengkap }}"
                                    data-lapangan="{{ $booking->lapangan->nama_lapangan }}"
                                    data-tanggal="{{ $booking->tanggal_booking }}" data-jammulai="{{ $booking->jam_mulai }}"
                                    data-jamselesai="{{ $booking->jam_selesai }}" data-durasi="{{ $booking->durasi }}"
                                    data-harga="{{ number_format($booking->harga_per_jam, 0, ',', '.') }}"
                                    data-total="{{ number_format($booking->total_harga, 0, ',', '.') }}"
                                    data-status="{{ $booking->status_booking }}" data-catatan="{{ $booking->catatan }}"
                                    data-bs-toggle="modal" data-bs-target="#detailBooking">
                                    <i class="bi bi-eye"></i>
                                </button>


                                <button class="btn btn-warning btn-sm btn-status" data-id="{{ $booking->id }}"
                                    data-status="{{ $booking->status_booking }}" data-bs-toggle="modal"
                                    data-bs-target="#updateStatus">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                Belum ada booking.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            <!-- Modal Detail Booking -->

            <div class="modal fade" id="detailBooking" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">
                                Detail Booking
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <table class="table">

                                <tr>
                                    <th>Customer</th>
                                    <td id="d_user"></td>
                                </tr>

                                <tr>
                                    <th>Lapangan</th>
                                    <td id="d_lapangan"></td>
                                </tr>

                                <tr>
                                    <th>Tanggal</th>
                                    <td id="d_tanggal"></td>
                                </tr>

                                <tr>
                                    <th>Jam</th>
                                    <td id="d_jam"></td>
                                </tr>

                                <tr>
                                    <th>Durasi</th>
                                    <td id="d_durasi"></td>
                                </tr>

                                <tr>
                                    <th>Harga/Jam</th>
                                    <td id="d_harga"></td>
                                </tr>

                                <tr>
                                    <th>Total</th>
                                    <td id="d_total"></td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td id="d_status"></td>
                                </tr>

                                <tr>
                                    <th>Catatan</th>
                                    <td id="d_catatan"></td>
                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Modal Update Status -->

            <div class="modal fade" id="updateStatus">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form id="statusForm" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="modal-header">

                                <h5 class="modal-title">

                                    Update Status Booking

                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <label class="form-label">

                                    Status Booking

                                </label>

                                <select class="form-select" name="status_booking" id="edit_status">

                                    <option value="menunggu">Menunggu</option>

                                    <option value="konfirmasi">Konfirmasi</option>

                                    <option value="selesai">Selesai</option>

                                    <option value="batal">Batal</option>

                                </select>

                            </div>

                            <div class="modal-footer">

                                <button class="btn btn-primary">

                                    Simpan

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <div class="mt-3">

                {{ $bookings->links() }}

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>

        document.querySelectorAll('.btn-detail').forEach(button => {

            button.addEventListener('click', function () {

                document.getElementById('d_user').innerText = this.dataset.user;
                document.getElementById('d_lapangan').innerText = this.dataset.lapangan;
                document.getElementById('d_tanggal').innerText = this.dataset.tanggal;
                document.getElementById('d_jam').innerText = this.dataset.jammulai + " - " + this.dataset.jamselesai;
                document.getElementById('d_durasi').innerText = this.dataset.durasi + " Jam";
                document.getElementById('d_harga').innerText = "Rp " + this.dataset.harga;
                document.getElementById('d_total').innerText = "Rp " + this.dataset.total;
                document.getElementById('d_status').innerText = this.dataset.status;
                document.getElementById('d_catatan').innerText = this.dataset.catatan;

            });

        });

        document.querySelectorAll('.btn-status').forEach(button => {

            button.addEventListener('click', function () {

                document.getElementById('edit_status').value = this.dataset.status;

                document.getElementById('statusForm').action = "/admin/booking/" + this.dataset.id;

            });

        });

    </script>

@endsection