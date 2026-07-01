@extends('layouts.app')

@section('title', 'Daftar Lapangan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-list text-primary"></i> Daftar Lapangan</h2>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('lapangan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Lapangan
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <select class="form-select" id="filterJenis" onchange="filterLapangan()">
                <option value="">Semua Lokasi</option>
                @php
                    $lokasi = App\Models\Lapangan::distinct()->pluck('lokasi');
                @endphp
                @foreach($lokasi as $l)
                    <option value="{{ $l }}">{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="filterStatus" onchange="filterLapangan()">
                <option value="">Semua Status</option>
                <option value="tersedia">Tersedia</option>
                <option value="tidak_tersedia">Tidak Tersedia</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="searchLapangan" placeholder="Cari lapangan..." onkeyup="filterLapangan()">
        </div>
    </div>

    <!-- Grid Lapangan -->
    <div class="row g-4" id="lapanganGrid">
        @foreach($lapangan as $item)
        <div class="col-md-4 lapangan-item" 
             data-lokasi="{{ $item->lokasi }}" 
             data-status="{{ $item->status }}"
             data-nama="{{ strtolower($item->nama_lapangan) }}">
            <div class="card h-100 shadow-sm hover-card">
                <div class="position-relative">
                    <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->nama_lapangan }}" 
                         style="height: 200px; object-fit: cover;">
                    <span class="badge position-absolute top-0 end-0 m-2 {{ $item->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $item->status }}
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama_lapangan }}</h5>
                    <p class="card-text">
                        <i class="fas fa-map-marker-alt text-danger"></i> {{ $item->lokasi }}
                    </p>
                    <p class="card-text">
                        <strong class="text-primary">Rp {{ number_format($item->harga_per_jam, 0, ',', '.') }}</strong> / jam
                    </p>
                    <p class="card-text text-muted small">{{ Str::limit($item->deskripsi, 80) }}</p>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ route('lapangan.show', $item->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    @if(Auth::user()->isAdmin())
                        <div class="btn-group w-100 mt-2">
                            <a href="{{ route('lapangan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('lapangan.destroy', $item->id) }}" method="POST" class="w-50">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $lapangan->links() }}
    </div>
</div>

<script>
function filterLapangan() {
    const lokasi = document.getElementById('filterJenis').value;
    const status = document.getElementById('filterStatus').value;
    const search = document.getElementById('searchLapangan').value.toLowerCase();
    
    const items = document.querySelectorAll('.lapangan-item');
    
    items.forEach(item => {
        const itemLokasi = item.dataset.lokasi;
        const itemStatus = item.dataset.status;
        const itemNama = item.dataset.nama;
        
        let show = true;
        if (lokasi && itemLokasi !== lokasi) show = false;
        if (status && itemStatus !== status) show = false;
        if (search && !itemNama.includes(search)) show = false;
        
        item.style.display = show ? 'block' : 'none';
    });
}
</script>

<style>
.hover-card {
    transition: transform 0.3s, box-shadow 0.3s;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
</style>
@endsection