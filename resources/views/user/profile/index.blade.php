@extends('user.layouts.app')

@section('title', 'Profil User')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i> Profil Saya</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
                        <i class="fas fa-user-circle fa-7x text-secondary"></i>
                    </div>
                </div>
                <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-2">{{ Auth::user()->email }}</p>
                <span class="badge rounded-pill bg-success">Aktif</span>
                <hr>
                <div class="text-start small text-muted">
                    <p class="mb-2"><i class="fas fa-calendar-alt me-2"></i> Bergabung: {{ Auth::user()->created_at->format('d F Y') }}</p>
                    <p class="mb-2"><i class="fas fa-phone me-2"></i> {{ Auth::user()->no_telepon ?? '-' }}</p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> {{ Auth::user()->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="fas fa-bell me-2"></i> Notifikasi</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0 py-2">
                    <small>Belum ada notifikasi terbaru.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Edit Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ Auth::user()->no_telepon }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ Auth::user()->alamat }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-lock me-2"></i> Ganti Kata Sandi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Kata Sandi Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-warning"><i class="fas fa-key me-2"></i>Ubah Kata Sandi</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-shield-alt me-2"></i> Kelola Akun</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column flex-sm-row flex-wrap gap-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100 w-sm-auto">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                    <form action="{{ route('user.profile.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 w-sm-auto">
                            <i class="fas fa-trash me-2"></i> Hapus Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
