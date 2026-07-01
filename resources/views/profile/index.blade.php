@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{ $user->profil_url }}" alt="Profile" class="rounded-circle" 
                             style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #667eea;">
                    </div>
                    <h5>{{ $user->nama_lengkap }}</h5>
                    <p class="text-muted">@ {{ $user->username }}</p>
                    <p class="text-muted small">{{ $user->email }}</p>
                    <p>
                        <span class="badge bg-info">{{ $user->gender ?? 'Tidak diisi' }}</span>
                        <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                    </p>
                    <p class="text-muted small">
                        <i class="fas fa-phone"></i> {{ $user->no_hp ?? 'Tidak diisi' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Update Profil -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit text-primary"></i> Edit Profil</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                       value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                       value="{{ old('no_hp', $user->no_hp) }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Gender</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Pilih Gender</option>
                                    <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Foto Profil</label>
                                <input type="file" name="profil" class="form-control @error('profil') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                                @error('profil')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="fas fa-save"></i> Update Profil
                        </button>
                    </form>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-key text-warning"></i> Ganti Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Lama</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Ganti Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection