@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="card dashboard-card border-0">
            <div class="card-body text-center py-4">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto overflow-hidden mb-3"
                     style="width: 110px; height: 110px; background:#2563EB;">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <span class="text-white fw-bold" style="font-size:36px;">
                            {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <h5 class="mb-1">{{ $user->nama_lengkap }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span class="badge" style="background:#2563EB;">Administrator</span>
                <hr>
                <div class="text-start small text-muted">
                    <p class="mb-2"><i class="bi bi-calendar3 me-2"></i>Bergabung: {{ $user->created_at->format('d F Y') }}</p>
                    <p class="mb-0"><i class="bi bi-telephone me-2"></i>{{ $user->no_telepon ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card dashboard-card border-0 mb-4">
            <div class="card-body">
                <h5 class="mb-3 fw-semibold"><i class="bi bi-person-gear me-2" style="color:#2563EB;"></i>Edit Profil</h5>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" name="avatar" accept="image/*">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" name="no_telepon" value="{{ $user->no_telepon }}">
                    </div>

                    <button type="submit" class="btn text-white" style="background:#2563EB;">
                        <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="card dashboard-card border-0" id="security">
            <div class="card-body">
                <h5 class="mb-3 fw-semibold"><i class="bi bi-shield-lock me-2" style="color:#2563EB;"></i>Keamanan &amp; Kata Sandi</h5>

                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Kata Sandi Saat Ini</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control" name="new_password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control" name="new_password_confirmation" required>
                        </div>
                    </div>

                    <button type="submit" class="btn text-white" style="background:#0F172A;">
                        <i class="bi bi-key me-2"></i>Ubah Kata Sandi
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
