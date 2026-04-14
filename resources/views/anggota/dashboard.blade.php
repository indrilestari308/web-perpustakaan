@extends('anggota.layouts')

@section('title', 'Dashboard')

@section('content')

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}

.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

.stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    font-size: 16px;
}

.stat-label {
    font-size: 12px;
    color: #999;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 22px;
    font-weight: 700;
    color: #333;
    margin-bottom: 2px;
}

.stat-sub {
    font-size: 11px;
    color: #bbb;
}

.rules-box {
    background: #fff;
    border-radius: 14px;
    border-left: 4px solid #4e73df;
    padding: 18px 22px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

.rules-title {
    font-size: 13px;
    font-weight: 600;
    color: #444;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.rules-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.rule-item {
    background: #f8f9ff;
    border-radius: 10px;
    padding: 14px;
}

.rule-num {
    font-size: 20px;
    font-weight: 700;
    color: #4e73df;
    margin-bottom: 4px;
}

.rule-desc {
    font-size: 11px;
    color: #888;
    line-height: 1.4;
}

.section-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

.section-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}

.section-title {
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.see-all {
    font-size: 12px;
    color: #4e73df;
    text-decoration: none;
}

.book-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f5f5f5;
}

.book-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.book-info .title {
    font-size: 13px;
    font-weight: 600;
    color: #333;
}

.book-info .meta {
    font-size: 11px;
    color: #aaa;
    margin-top: 2px;
}

.book-right {
    text-align: right;
}

.due {
    font-size: 11px;
    color: #aaa;
    margin-bottom: 4px;
}

.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-warn  { background: #fff8e8; color: #b07d1a; }
.badge-ok    { background: #eafaf1; color: #1a7a45; }
.badge-late  { background: #fdeaea; color: #a32d2d; }

.empty-info {
    text-align: center;
    padding: 30px;
    color: #ccc;
    font-size: 13px;
}
</style>

{{-- STATISTIK --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eef2ff;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4e73df" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
        </div>
        <div class="stat-label">Total pinjaman</div>
        <div class="stat-value">{{ $totalPinjaman ?? 0 }}</div>
        <div class="stat-sub">sepanjang masa</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fff8e8;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b07d1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stat-label">Sedang dipinjam</div>
        <div class="stat-value">{{ $sedangDipinjam ?? 0 }}</div>
        <div class="stat-sub">dari maks. 3 buku</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#eafaf1;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a7a45" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div class="stat-label">Dikembalikan</div>
        <div class="stat-value">{{ $sudahKembali ?? 0 }}</div>
        <div class="stat-sub">buku selesai</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fdeaea;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#a32d2d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
        <div class="stat-label">Total denda</div>
        <div class="stat-value" style="font-size:16px;">Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</div>
        <div class="stat-sub">{{ ($totalDenda ?? 0) == 0 ? 'tidak ada tunggakan' : 'harap segera dilunasi' }}</div>
    </div>
</div>

{{-- ATURAN --}}
<div class="rules-box">
    <div class="rules-title">
        ℹ️ Aturan peminjaman
    </div>
    <div class="rules-grid">
        <div class="rule-item">
            <div class="rule-num">3</div>
            <div class="rule-desc">Maksimal buku dipinjam sekaligus</div>
        </div>
        <div class="rule-item">
            <div class="rule-num">7 hari</div>
            <div class="rule-desc">Batas waktu peminjaman per buku</div>
        </div>
        <div class="rule-item">
            <div class="rule-num">Rp 1.000</div>
            <div class="rule-desc">Denda per hari keterlambatan</div>
        </div>
    </div>
</div>

{{-- BUKU SEDANG DIPINJAM --}}
<div class="section-card">
    <div class="section-head">
        <div class="section-title">Sedang dipinjam</div>
        <a href="{{ route('anggota.peminjaman') }}" class="see-all">Lihat semua →</a>
    </div>

    @forelse($peminjamanAktif ?? [] as $item)
    @php
        $batas = \Carbon\Carbon::parse($item->batas_kembali);
        $terlambat = now()->gt($batas);
    @endphp
    <div class="book-row">
        <div class="book-info">
            <div class="title">{{ $item->buku->judul ?? '-' }}</div>
            <div class="meta">Dipinjam {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</div>
        </div>
        <div class="book-right">
            <div class="due">Kembali {{ $batas->format('d M Y') }}</div>
            @if($terlambat)
                <span class="badge badge-late">Terlambat</span>
            @else
                <span class="badge badge-warn">Dipinjam</span>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-info">Tidak ada buku yang sedang dipinjam</div>
    @endforelse
</div>

{{-- RIWAYAT TERAKHIR --}}
<div class="section-card">
    <div class="section-head">
        <div class="section-title">Riwayat terakhir</div>
        <a href="{{ route('anggota.riwayat') }}" class="see-all">Lihat semua →</a>
    </div>

    @forelse($riwayatTerakhir ?? [] as $item)
    <div class="book-row">
        <div class="book-info">
            <div class="title">{{ $item->buku->judul ?? '-' }}</div>
            <div class="meta">
                Dikembalikan {{ $item->tanggal_dikembalikan ? \Carbon\Carbon::parse($item->tanggal_dikembalikan)->format('d M Y') : '-' }}
            </div>
        </div>
        <div class="book-right">
            <span class="badge badge-ok">Dikembalikan</span>
        </div>
    </div>
    @empty
    <div class="empty-info">Belum ada riwayat peminjaman</div>
    @endforelse
</div>

@endsection