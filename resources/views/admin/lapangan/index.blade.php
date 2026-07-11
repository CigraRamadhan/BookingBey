@extends('layouts.admin')
@section('title', 'Data Lapangan')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                Data Lapangan
            </h2>
            <small class="text-muted">
                Kelola seluruh data lapangan.
            </small>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createLapangan">
            <i class="bi bi-plus-circle"></i>
            Tambah Lapangan
        </button>
    </div>

    <div class="card dashboard-card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>

                        <th>No</th>

                        <th>Gambar</th>

                        <th>Nama</th>

                        <th>Jenis</th>

                        <th>Lokasi</th>

                        <th>Harga</th>

                        <th>Status</th>

                        <th width="180">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($lapangans as $lapangan)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($lapangan->gambar)
                                    <img src="{{ $lapangan->gambar_url }}" width="80" height="60" class="rounded object-fit-cover">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>

                            <td>{{ $lapangan->nama_lapangan}}</td>

                            <td>{{ $lapangan->jenis}}</td>

                            <td>{{ $lapangan->lokasi }}</td>

                            <td>
                                Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                            </td>

                            <td>

                                @if($lapangan->status == 'tersedia')

                                    <span class="badge rounded-pill bg-success">

                                        Tersedia

                                    </span>

                                @else
                                    <span class="badge rounded-pill bg-danger">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $lapangan->id }}"
                                    data-nama="{{ $lapangan->nama_lapangan }}" data-jenis="{{ $lapangan->jenis }}"
                                    data-lokasi="{{ $lapangan->lokasi }}" data-harga="{{ $lapangan->harga_per_jam }}"
                                    data-deskripsi="{{ $lapangan->deskripsi }}" data-status="{{ $lapangan->status }}"
                                    data-bs-toggle="modal" data-bs-target="#editLapangan">
                                    <i class="bi bi-pencil"></i>
                                </button>


                                <form action="{{ route('admin.lapangan.destroy', $lapangan->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus lapangan ini?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada data lapangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal Tambah Lapangan -->

    <div class="modal fade" id="createLapangan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ route('admin.lapangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tambah Lapangan
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Nama Lapangan
                                </label>

                                <input type="text" class="form-control" name="nama_lapangan" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Jenis
                                </label>

                                <select class="form-select" name="jenis">
                                    <option value="Futsal">Futsal</option>
                                    <option value="Badminton">Badminton</option>
                                    <option value="Basket">Basket</option>
                                    <option value="Voli">Voli</option>
                                    <option value="Tennis">Tennis</option>
                                </select>

                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Lokasi
                            </label>

                            <input type="text" class="form-control" name="lokasi">
                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Harga per Jam

                            </label>

                            <input type="number" class="form-control" name="harga_per_jam">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Deskripsi

                            </label>

                            <textarea rows="4" class="form-control" name="deskripsi"></textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Upload Gambar

                            </label>

                            <input type="file" class="form-control" name="gambar">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Status

                            </label>

                            <select class="form-select" name="status">

                                <option value="tersedia">

                                    Tersedia

                                </option>

                                <option value="tidak_tersedia">

                                    Tidak Tersedia

                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editLapangan" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form id="editForm" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Lapangan</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Nama Lapangan</label>

                                <input type="text" class="form-control" id="edit_nama" name="nama_lapangan">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Jenis</label>

                                <select class="form-select" id="edit_jenis" name="jenis">

                                    <option value="Futsal">Futsal</option>
                                    <option value="Badminton">Badminton</option>
                                    <option value="Basket">Basket</option>
                                    <option value="Voli">Voli</option>
                                    <option value="Tennis">Tennis</option>

                                </select>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Lokasi</label>

                            <input type="text" class="form-control" id="edit_lokasi" name="lokasi">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Harga</label>

                            <input type="number" class="form-control" id="edit_harga" name="harga_per_jam">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Deskripsi</label>

                            <textarea class="form-control" rows="4" id="edit_deskripsi" name="deskripsi"></textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Gambar Baru</label>

                            <input type="file" class="form-control" name="gambar">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Status</label>

                            <select class="form-select" id="edit_status" name="status">

                                <option value="tersedia">Tersedia</option>
                                <option value="tidak_tersedia">Tidak Tersedia</option>

                            </select>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit" class="btn btn-primary">

                            Update

                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                document.getElementById('editForm').action = "/admin/lapangan/" + id;
                document.getElementById('edit_nama').value = this.dataset.nama;
                document.getElementById('edit_jenis').value = this.dataset.jenis;
                document.getElementById('edit_lokasi').value = this.dataset.lokasi;
                document.getElementById('edit_harga').value = this.dataset.harga;
                document.getElementById('edit_deskripsi').value = this.dataset.deskripsi;
                document.getElementById('edit_status').value = this.dataset.status;
            });
        });
    </script>
@endsection