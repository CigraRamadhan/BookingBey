@extends('layouts.admin')

@section('title', 'Data User')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                Data User
            </h2>

            <small class="text-muted">
                Kelola seluruh pengguna aplikasi.
            </small>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <div class="card dashboard-card">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Nama</th>

                        <th>Username</th>

                        <th>Email</th>

                        <th>Role</th>

                        <th width="150">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td>

                                {{ $users->firstItem() + $loop->index }}

                            </td>

                            <td>

                                {{ $user->nama_lengkap }}

                            </td>

                            <td>

                                {{ $user->username }}

                            </td>

                            <td>

                                {{ $user->email }}

                            </td>

                            <td>

                                @if($user->role == 'admin')

                                    <span class="badge bg-danger">

                                        Admin

                                    </span>

                                @else

                                    <span class="badge bg-primary">

                                        User

                                    </span>

                                @endif

                            </td>

                            <td>
                                <button class="btn btn-info btn-sm btn-detail" data-nama="{{ $user->nama_lengkap }}"
                                    data-username="{{ $user->username }}" data-email="{{ $user->email }}"
                                    data-nohp="{{ $user->no_hp }}" data-gender="{{ $user->gender }}"
                                    data-role="{{ ucfirst($user->role) }}" data-profil="{{ $user->profil }}"
                                    data-bs-toggle="modal" data-bs-target="#detailUser">
                                    <i class="bi bi-eye"></i>
                                </button>

                                @if($user->role != 'admin')

                                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $user->id }}"
                                        data-nama="{{ $user->nama_lengkap }}" data-bs-toggle="modal" data-bs-target="#deleteUser">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                Belum ada data user.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            <!-- Modal Detail User -->
            <div class="modal fade" id="detailUser" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">
                                Detail User
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body text-center">

                            <img id="detail_profil" src="{{ asset('images/default-user.png') }}" class="rounded-circle mb-3"
                                width="120" height="120" style="object-fit: cover;">

                            <table class="table table-borderless text-start">

                                <tr>
                                    <th width="35%">Nama</th>
                                    <td id="detail_nama"></td>
                                </tr>

                                <tr>
                                    <th>Username</th>
                                    <td id="detail_username"></td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td id="detail_email"></td>
                                </tr>

                                <tr>
                                    <th>No HP</th>
                                    <td id="detail_nohp"></td>
                                </tr>

                                <tr>
                                    <th>Gender</th>
                                    <td id="detail_gender"></td>
                                </tr>

                                <tr>
                                    <th>Role</th>
                                    <td id="detail_role"></td>
                                </tr>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="deleteUser" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form id="deleteForm" method="POST">

                            @csrf
                            @method('DELETE')

                            <div class="modal-header">

                                <h5 class="modal-title">

                                    Hapus User

                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <p>
                                    Apakah Anda yakin ingin menghapus user
                                    <strong id="delete_nama"></strong>?
                                </p>

                                <p class="text-danger mb-0">
                                    Data yang dihapus tidak dapat dikembalikan.
                                </p>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                    Batal

                                </button>

                                <button type="submit" class="btn btn-danger">

                                    Hapus

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <div class="mt-3">

                {{ $users->links() }}

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>

        document.querySelectorAll('.btn-detail').forEach(button => {

            button.addEventListener('click', function () {

                document.getElementById('detail_nama').innerText = this.dataset.nama;
                document.getElementById('detail_username').innerText = this.dataset.username;
                document.getElementById('detail_email').innerText = this.dataset.email;
                document.getElementById('detail_nohp').innerText = this.dataset.nohp || '-';
                document.getElementById('detail_gender').innerText = this.dataset.gender || '-';
                document.getElementById('detail_role').innerText = this.dataset.role;

                let foto = this.dataset.profil;

                if (foto) {
                    document.getElementById('detail_profil').src = "/storage/profil/" + foto;
                } else {
                    document.getElementById('detail_profil').src = "/images/default-user.png";
                }

                document.querySelectorAll('.btn-delete').forEach(button => {

                    button.addEventListener('click', function () {

                        document.getElementById('delete_nama').innerText =
                            this.dataset.nama;

                        document.getElementById('deleteForm').action =
                            "/admin/users/" + this.dataset.id;

                    });

                });

            });

        });

    </script>

@endsection