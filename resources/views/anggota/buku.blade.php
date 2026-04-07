@extends('anggota.layouts')

@section('title', 'Daftar Buku')

@section('content')

<style>
.info-banner {
    background: #fff;
    border: 1px solid #b5d4f4;
    border-left: 4px solid #4e73df;
    border-radius: 10px;
    padding: 10px 16px;
    margin-bottom: 20px;
    font-size: 13px;
    color: #555;
}

.search-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
}

.search-input {
    flex: 1;
    background: #fff;
    border: 1px solid #dde3f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    color: #333;
    outline: none;
}

.search-input:focus {
    border-color: #4e73df;
}

.filter-select {
    background: #fff;
    border: 1px solid #dde3f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    color: #555;
    outline: none;
    cursor: pointer;
}

.book-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 3px 14px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
}

.book-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.book-cover-wrap {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f0f2f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.book-cover-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cover-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.cover-spine {
    width: 70px;
    height: 100px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4e73df, #224abe);
}

.stock-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.stock-ok   { background: #eafaf1; color: #1a7a45; }
.stock-out  { background: #fdeaea; color: #a32d2d; }

.book-body {
    padding: 14px 16px;
}

.book-title {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.book-author {
    font-size: 12px;
    color: #aaa;
    margin-bottom: 4px;
}

.book-kategori {
    display: inline-block;
    background: #eef2ff;
    color: #4e73df;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 6px;
    margin-bottom: 12px;
}

.book-actions {
    display: flex;
    gap: 8px;
}

.btn-detail {
    flex: 1;
    background: #eef2ff;
    color: #4e73df;
    border: none;
    border-radius: 8px;
    padding: 8px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: background 0.2s;
}

.btn-detail:hover {
    background: #dde6ff;
    color: #4e73df;
}

.btn-pinjam {
    flex: 1;
    background: #4e73df;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-pinjam:hover {
    background: #224abe;
}

.btn-pinjam:disabled {
    background: #e0e0e0;
    color: #aaa;
    cursor: not-allowed;
}

.empty-state {
    text-align: center;
    padding: 60px;
    color: #ccc;
}

.empty-state i {
    font-size: 50px;
    margin-bottom: 12px;
    display: block;
}
</style>

{{-- NOTIF --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- INFO BANNER --}}
<div class="info-banner">
    <i class="bi bi-info-circle me-1"></i>
    Setelah klik <strong>Pinjam</strong>, permintaan dikirim ke petugas. Silakan tunggu konfirmasi sebelum buku diambil.
</div>

{{-- SEARCH & FILTER --}}
<form method="GET" action="{{ route('anggota.buku') }}" class="search-bar">
    <input type="text" name="cari" class="search-input"
           placeholder="Cari judul atau penulis..."
           value="{{ request('cari') }}">
    <select name="kategori" class="filter-select" onchange="this.form.submit()">
        <option value="">Semua kategori</option>
        @foreach($kategoriList ?? [] as $kat)
            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                {{ $kat->nama_kategori }}
            </option>
        @endforeach
    </select>
</form>

{{-- GRID BUKU --}}
<div class="row g-4">
    @forelse ($buku as $item)
    <div class="col-md-4 col-sm-6">
        <div class="book-card">

            {{-- COVER --}}
            <div class="book-cover-wrap">
                @if($item->gambar)
                    <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}">
                @else
                    <div class="cover-placeholder">
                        <div class="cover-spine">
                            <i class="bi bi-book" style="font-size:24px; color:rgba(255,255,255,0.8);"></i>
                        </div>
                    </div>
                @endif

                {{-- BADGE STOK --}}
                @if($item->stok > 0)
                    <span class="stock-badge stock-ok">Tersedia</span>
                @else
                    <span class="stock-badge stock-out">Habis</span>
                @endif
            </div>

            {{-- INFO --}}
            <div class="book-body">
                <div class="book-title" title="{{ $item->judul }}">{{ $item->judul }}</div>
                <div class="book-author">{{ $item->penulis }} • {{ $item->tahun_terbit }}</div>

                @if($item->kategori)
                    <span class="book-kategori">{{ $item->kategori->nama_kategori }}</span>
                @endif

                <div class="book-actions">
                    <a href="{{ route('anggota.buku.detail', $item->id) }}" class="btn-detail">
                        Lihat Detail
                    </a>

                    @if($item->stok > 0)
                    <form action="{{ route('anggota.pinjam', $item->id) }}" method="POST" style="flex:1;">
                        @csrf
                        <button type="submit" class="btn-pinjam" style="width:100%;"
                                onclick="return confirm('Pinjam buku ini?')">
                            Pinjam
                        </button>
                    </form>
                    @else
                    <button class="btn-pinjam" style="flex:1;" disabled>Habis</button>
                    @endif
                </div>
            </div>

        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <i class="bi bi-book-x"></i>
            <p class="fw-semibold mb-1">Buku tidak ditemukan</p>
            <p style="font-size:13px;">Coba ubah kata kunci pencarian</p>
        </div>
    </div>
    @endforelse
</div>

{{-- PAGINATION --}}
@if($buku->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $buku->withQueryString()->links() }}
</div>
@endif

@endsection