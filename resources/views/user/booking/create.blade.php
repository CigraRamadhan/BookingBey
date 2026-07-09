@extends('user.layouts.app')

@section('title', 'Booking Lapangan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-plus"></i> Booking Lapangan</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5>Lapangan: {{ $lapangan->nama }}</h5>
                        <p class="mb-0">Harga: Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} / jam</p>
                    </div>

                    <form action="{{ route('user.booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}">

                        <div class="mb-3">
                            <label for="tanggal_booking" class="form-label">Tanggal Booking</label>
                            <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking"
                                min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="durasi" class="form-label">Durasi (Jam)</label>
                            <input type="number" class="form-control" id="durasi" name="durasi" min="1" max="4" required>
                            <small class="text-muted">Maksimal 4 jam</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Booking
                            </button>
                            <a href="{{ route('user.lapangan.show', $lapangan->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jamMulai = document.getElementById('jam_mulai');
            const jamSelesai = document.getElementById('jam_selesai');
            const durasi = document.getElementById('durasi');
            const totalHarga = document.getElementById('total_harga');
            const hargaPerJam = {{ $lapangan->harga_per_jam }};

            function calculateTotal() {
                if (durasi.value && jamMulai.value && jamSelesai.value) {
                    const total = parseInt(durasi.value) * hargaPerJam;
                    totalHarga.value = new Intl.NumberFormat('id-ID').format(total);
                }
            }

            jamMulai.addEventListener('change', calculateTotal);
            jamSelesai.addEventListener('change', calculateTotal);
            durasi.addEventListener('input', calculateTotal);

            // Set default values
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            document.getElementById('tanggal_booking').value = today;
        });
    </script>
@endsection