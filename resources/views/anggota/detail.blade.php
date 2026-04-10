@extends('anggota.layouts')

@section('title', 'Detail Buku – ' . $buku->judul)

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap');

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #6b7280;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    padding: 7px 14px;
    text-decoration: none;
    transition: all 0.18s;
    margin-bottom: 28px;
}

.btn-back:hover {
    color: #1a1a2e;
    border-color: #c7d0e8;
    background: #f8f9fc;
    text-decoration: none;
}

.detail-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 36px;
    align-items: start;
}

@media (max-width: 768px) {
    .detail-layout {
        grid-template-columns: 1fr;
    }
    .detail-cover-col {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .detail-cover-book {
        width: 140px;
        flex-shrink: 0;
    }
}

/* ===== COVER PORTRAIT ===== */
.detail-cover-book {
    position: relative;
}

.detail-cover-img {
    width: 100%;
    aspect-ratio: 2 / 3;
    border-radius: 14px;
    overflow: hidden;
    box-shadow:
        6px 6px 0 0 rgba(26, 26, 46, 0.12),
        12px 12px 0 0 rgba(26, 26, 46, 0.06);
}

.detail-cover-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cover-placeholder-detail {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 24px 20px;
    background: linear-gradient(160deg, #1a1a2e 0%, #16213e 55%, #0f3460 100%);
}

.cover-placeholder-detail .cp-line {
    width: 40px;
    height: 1px;
    background: rgba(255, 255, 255, 0.28);
}

.cover-placeholder-detail .cp-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 16px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    text-align: center;
    line-height: 1.4;
}

.cover-placeholder-detail .cp-author {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.5);
    text-align: center;
}

.cover-spine-detail {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 7px;
    background: rgba(0, 0, 0, 0.18);
    border-radius: 14px 0 0 14px;
}

/* ===== AVAILABILITY CARD ===== */
.avail-card {
    margin-top: 16px;
    border-radius: 11px;
    padding: 11px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.avail-card.ok  { background: #ecfdf5; border: 1px solid #a7f3d0; }
.avail-card.out { background: #fef2f2; border: 1px solid #fecaca; }

.avail-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    flex-shrink: 0;
}

.avail-dot.ok  { background: #10b981; }
.avail-dot.out { background: #ef4444; }

.avail-text-main {
    font-size: 13px;
    font-weight: 600;
    color: #065f46;
}

.avail-card.out .avail-text-main { color: #991b1b; }

.avail-text-sub {
    font-size: 11px;
    color: #6ee7b7;
    margin-top: 1px;
}

.avail-card.out .avail-text-sub { color: #fca5a5; }

/* ===== RIGHT COLUMN ===== */
.detail-kategori-badge {
    display: inline-block;
    background: #eef2ff;
    color: #4e73df;
    font-size: 11px;
    padding: 3px 11px;
    border-radius: 6px;
    font-weight: 600;
    letter-spacing: 0.4px;
    margin-bottom: 12px;
}

.detail-judul {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 28px;
    font-weight: 700;
    color: #1e1e3a;
    line-height: 1.28;
    margin-bottom: 7px;
}

.detail-penulis {
    font-size: 15px;
    color: #6b7280;
    margin-bottom: 26px;
}

/* ===== META GRID ===== */
.meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 28px;
}

.meta-item {
    background: #f8f9fc;
    border-radius: 11px;
    padding: 12px 14px;
    border: 1px solid #eaeef8;
}

.meta-label {
    font-size: 10.5px;
    color: #9ca3af;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.meta-value {
    font-size: 14px;
    font-weight: 600;
    color: #1e1e3a;
}

/* ===== SINOPSIS ===== */
.section-label {
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    margin-bottom: 9px;
}

.sinopsis-text {
    font-size: 14px;
    color: #4b5563;
    line-height: 1.78;
    margin-bottom: 28px;
}

/* ===== ACTIONS ===== */
.detail-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 28px;
}

.btn-pinjam-lg {
    flex: 1;
    background: #1a1a2e;
    color: #fff;
    border: none;
    border-radius: 11px;
    padding: 13px 22px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    letter-spacing: 0.2px;
}

.btn-pinjam-lg:hover    { background: #0f3460; }
.btn-pinjam-lg:disabled { background: #e5e7eb; color: #9ca3af; cursor: not-allowed; }

.section-divider {
    border: none;
    border-top: 1px solid #f0f2f8;
    margin: 0 0 24px;
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

{{-- BACK --}}
<a href="{{ route('anggota.buku') }}" class="btn-back">
    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
</a>

{{-- MAIN LAYOUT --}}
<div class="detail-layout">

    {{-- ===== KOLOM KIRI: COVER ===== --}}
    <div class="detail-cover-col">
        <div class="detail-cover-book">
            <div class="detail-cover-img">
                @if($buku->gambar)
                    <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul }}">
                @else
                    <div class="cover-placeholder-detail">
                        <div class="cp-line"></div>
                        <div class="cp-title">{{ $buku->judul }}</div>
                        <div class="cp-line"></div>
                        <div class="cp-author">{{ $buku->penulis }}</div>
                    </div>
                @endif
                <div class="cover-spine-detail"></div>
            </div>

            {{-- KETERSEDIAAN --}}
            <div class="avail-card {{ $buku->stok > 0 ? 'ok' : 'out' }}">
                <div class="avail-dot {{ $buku->stok > 0 ? 'ok' : 'out' }}"></div>
                <div>
                    <div class="avail-text-main">
                        {{ $buku->stok > 0 ? $buku->stok . ' eksemplar tersedia' : 'Stok habis' }}
                    </div>
                    <div class="avail-text-sub">
                        {{ $buku->stok > 0 ? 'Siap dipinjam sekarang' : 'Cek lagi nanti' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== KOLOM KANAN: DETAIL ===== --}}
    <div>

        {{-- Kategori --}}
        @if($buku->kategori)
            <span class="detail-kategori-badge">{{ $buku->kategori->nama_kategori }}</span>
        @endif

        {{-- Judul & Penulis --}}
        <h1 class="detail-judul">{{ $buku->judul }}</h1>
        <p class="detail-penulis">
            <i class="bi bi-person me-1"></i>{{ $buku->penulis }}
        </p>

        {{-- Meta info — sesuai $fillable model Buku --}}
        <div class="meta-grid">
            @if($buku->penerbit)
            <div class="meta-item">
                <div class="meta-label">Penerbit</div>
                <div class="meta-value">{{ $buku->penerbit }}</div>
            </div>
            @endif

            <div class="meta-item">
                <div class="meta-label">Tahun Terbit</div>
                <div class="meta-value">{{ $buku->tahun_terbit ?? '-' }}</div>
            </div>

            @if($buku->jumlah_halaman)
            <div class="meta-item">
                <div class="meta-label">Jumlah Halaman</div>
                <div class="meta-value">{{ number_format($buku->jumlah_halaman) }} hlm</div>
            </div>
            @endif

            @if($buku->bahasa)
            <div class="meta-item">
                <div class="meta-label">Bahasa</div>
                <div class="meta-value">{{ $buku->bahasa }}</div>
            </div>
            @endif

            <div class="meta-item">
                <div class="meta-label">Stok</div>
                <div class="meta-value">{{ $buku->stok }} eksemplar</div>
            </div>

            @if($buku->status)
            <div class="meta-item">
                <div class="meta-label">Status</div>
                <div class="meta-value">{{ ucfirst($buku->status) }}</div>
            </div>
            @endif
        </div>

        {{-- Sinopsis --}}
        @if($buku->sinopsis)
        <div class="section-label">Sinopsis</div>
        <p class="sinopsis-text">{{ $buku->sinopsis }}</p>
        @endif

        <hr class="section-divider">

        {{-- Tombol Pinjam --}}
        <div class="detail-actions">
            @if($buku->stok > 0)
                <form action="{{ route('anggota.pinjam', $buku->id) }}" method="POST" style="flex:1; display:flex;">
                    @csrf
                    <button type="submit" class="btn-pinjam-lg" style="width:100%;"
                            onclick="return confirm('Pinjam buku &quot;{{ addslashes($buku->judul) }}&quot;?')">
                        <i class="bi bi-book me-2"></i>Pinjam Buku Ini
                    </button>
                </form>
            @else
                <button class="btn-pinjam-lg" style="flex:1;" disabled>
                    <i class="bi bi-x-circle me-2"></i>Stok Habis
                </button>
            @endif
        </div>

    </div>
</div>

@endsection
