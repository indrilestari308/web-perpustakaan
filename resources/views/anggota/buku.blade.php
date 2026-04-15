@extends('anggota.layouts')

@section('title', 'Daftar Buku')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap');

/* ===== INFO BANNER ===== */
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

/* ===== SEARCH BAR ===== */
.search-bar {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
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
    transition: border-color 0.2s;
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

.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 16px;
}

/* ===== BOOK CARD – PORTRAIT ===== */
.book-card {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #eaeef8;
    transition: all 0.22s;
    display: flex;
    flex-direction: column;
    width: 200px;
}

.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 32px rgba(30, 30, 80, 0.12);
}

/* Cover portrait 2:3 */
.book-cover-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 2 / 3;
    overflow: hidden;
    background: #1a1a2e;
    flex-shrink: 0;
}

.book-cover-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Punggung buku */
.book-spine {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 6px;
    background: rgba(0, 0, 0, 0.18);
}

/* Placeholder cover – warna berbeda per sisa stok / kategori */
.cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 20px;
    background: linear-gradient(160deg, #1a1a2e 0%, #16213e 55%, #0f3460 100%);
}

.cover-placeholder-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 13px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.88);
    text-align: center;
    line-height: 1.45;
}

.cover-placeholder-line {
    width: 32px;
    height: 1px;
    background: rgba(255, 255, 255, 0.28);
}

.cover-placeholder-author {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.48);
    text-align: center;
}

/* Badge stok */
.stock-badge {
    position: absolute;
    top: 9px;
    right: 9px;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.3px;
    backdrop-filter: blur(4px);
}

.stock-ok {
    background: rgba(16, 185, 129, 0.14);
    color: #065f46;
    border: 1px solid rgba(16, 185, 129, 0.28);
}

.stock-out {
    background: rgba(239, 68, 68, 0.14);
    color: #991b1b;
    border: 1px solid rgba(239, 68, 68, 0.28);
}

/* Info section */
.book-body {
    padding: 13px 15px 15px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.book-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 14px;
    font-weight: 600;
    color: #1e1e3a;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.book-author {
    font-size: 11.5px;
    color: #9ca3af;
    margin-bottom: 9px;
}

.book-kategori {
    display: inline-block;
    background: #eef2ff;
    color: #4e73df;
    font-size: 10.5px;
    padding: 2px 9px;
    border-radius: 6px;
    margin-bottom: 12px;
    font-weight: 500;
}

.book-actions {
    display: flex;
    gap: 7px;
    margin-top: auto;
}

.btn-detail {
    flex: 1;
    background: #f4f6fb;
    color: #4e73df;
    border: 1px solid #dde3f0;
    border-radius: 3px;
    padding: 8px;
    font-size: 11.5px;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: background 0.18s;
    line-height: 1;
}

.btn-detail:hover {
    background: #dde6ff;
    color: #4e73df;
    text-decoration: none;
}

.btn-pinjam {
    flex: 1;
    background: #1a1a2e;
    color: #fff;
    border: none;
    border-radius: 3px;
    padding: 8px;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.18s;
    line-height: 1;
}

.btn-pinjam:hover {
    background: #0f3460;
}

.btn-pinjam:disabled {
    background: #e9ecef;
    color: #adb5bd;
    cursor: not-allowed;
    border: 1px solid #dee2e6;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #c9d0e0;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 14px;
    display: block;
}
</style>

{{-- NOTIFIKASI --}}
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
    <button type="submit" class="btn btn-primary" style="border-radius: 10px; padding: 10px 18px; font-size: 13px;">
        <i class="bi bi-search"></i>
    </button>
</form>

{{-- GRID BUKU --}}
<div class="book-grid">
    @forelse ($buku as $item)
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="book-card">

            {{-- COVER PORTRAIT --}}
            <div class="book-cover-wrap">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
                @else
                    <div class="cover-placeholder">
                        <div class="cover-placeholder-line"></div>
                        <div class="cover-placeholder-title">{{ $item->judul }}</div>
                        <div class="cover-placeholder-line"></div>
                        <div class="cover-placeholder-author">{{ $item->penulis }}</div>
                    </div>
                @endif

                {{-- Efek punggung buku --}}
                <div class="book-spine"></div>

                {{-- Badge stok --}}
                @if($item->stok > 0)
                    <span class="stock-badge stock-ok">Tersedia</span>
                @else
                    <span class="stock-badge stock-out">Habis</span>
                @endif
            </div>

            {{-- INFO BUKU --}}
            <div class="book-body">
                <div class="book-title" title="{{ $item->judul }}">{{ $item->judul }}</div>
                <div class="book-author">{{ $item->penulis }} &bull; {{ $item->tahun_terbit }}</div>

                @if($item->kategori)
                    <span class="book-kategori">{{ $item->kategori->nama_kategori }}</span>
                @endif

                <div class="book-actions">
                    <a href="{{ route('anggota.buku.detail', $item->id) }}" class="btn-detail">
                        Detail
                    </a>

                    @if($item->stok > 0)
                        <form action="{{ route('anggota.pinjam', $item->id) }}" method="POST" style="flex:1; display:flex;">
                            @csrf
                            <button type="submit" class="btn-pinjam" style="width:100%;"
                                    onclick="return confirm('Pinjam buku \u0022{{ addslashes($item->judul) }}\u0022?')">
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
            <p class="fw-semibold mb-1" style="color: #6b7280;">Buku tidak ditemukan</p>
            <p style="font-size: 13px; color: #9ca3af;">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
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
