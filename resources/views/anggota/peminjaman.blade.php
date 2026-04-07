@extends('anggota.layouts')

@section('title', 'Buku Saya')

@section('content')

<style>
.card-box {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.07);
}


.table thead th {
    background: #4e73df;
    color: white;
    font-weight: 500;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    padding: 14px 16px;
}

.table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    font-size: 14px;
    border-color: #f0f2f9;
}
.badge-menunggu {
    background: #fff7e6;
    color: #d97706;
}

.table tbody tr:hover {
    background: #f8f9ff;
}

.badge-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-dipinjam {
    background: #e8f0ff;
    color: #4e73df;
}

.badge-terlambat {
    background: #ffe8e8;
    color: #e74c3c;
}

.badge-dikembalikan {
    background: #e8f9f0;
    color: #27ae60;
}

.denda-text {
    color: #e74c3c;
    font-weight: 600;
}

.denda-none {
    color: #aaa;
    font-size: 13px;
}

.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.stat-icon.blue { background: #e8f0ff; color: #4e73df; }
.stat-icon.red  { background: #ffe8e8; color: #e74c3c; }
.stat-icon.green{ background: #e8f9f0; color: #27ae60; }

.stat-info p {
    margin: 0;
    font-size: 12px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-info h5 {
    margin: 2px 0 0;
    font-size: 22px;
    font-weight: 700;
    color: #333;
}

.btn-kembali {
    background: #4e73df;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 13px;
    transition: 0.2s;
}

.btn-kembali:hover {
    background: #224abe;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #aaa;
}

.empty-state i {
    font-size: 60px;
    margin-bottom: 16px;
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

{{-- STATISTIK --}}
<div class="row mb-2">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-book"></i></div>
            <div class="stat-info">
                <p>Sedang Dipinjam</p>
                <h5>{{ $sedangDipinjam ?? 0 }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="stat-info">
                <p>Terlambat</p>
                <h5>{{ $terlambat ?? 0 }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-cash"></i></div>
            <div class="stat-info">
                <p>Total Denda</p>
                <h5>Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
</div>

{{-- TABEL --}}
<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Daftar Peminjaman Aktif</h6>
        <a href="/anggota/riwayat" class="btn btn-sm btn-outline-primary" style="border-radius:8px; font-size:13px;">
            <i class="bi bi-clock-history me-1"></i>Lihat Riwayat
        </a>
    </div>

    @if(isset($peminjaman) && $peminjaman->count() > 0)
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $i => $item)
                @php
                    $hariIni     = \Carbon\Carbon::today();
                    $batasKembali = \Carbon\Carbon::parse($item->tanggal_kembali);
                    $terlambatHari = $hariIni->gt($batasKembali) ? $hariIni->diffInDays($batasKembali) : 0;
                    $dendaHitung  = $terlambatHari * 1000; // Rp 1.000/hari
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:14px;">{{ $item->buku->judul ?? '-' }}</div>
                        <div style="font-size:12px; color:#999;">{{ $item->buku->penulis ?? '' }}</div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                        @if($terlambatHari > 0)
                            <br><span style="font-size:11px; color:#e74c3c;">{{ $terlambatHari }} hari terlambat</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'menunggu')
                            <span class="badge-status badge-menunggu">Menunggu</span>

                        @elseif($terlambatHari > 0)
                            <span class="badge-status badge-terlambat">Terlambat</span>

                        @elseif($item->status == 'dipinjam')
                            <span class="badge-status badge-dipinjam">Dipinjam</span>

                        @elseif($item->status == 'dikembalikan')
                            <span class="badge-status badge-dikembalikan">Dikembalikan</span>

                        @else
                            <span class="badge-status">{{ ucfirst($item->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($dendaHitung > 0)
                            <span class="denda-text">Rp {{ number_format($dendaHitung, 0, ',', '.') }}</span>
                        @else
                            <span class="denda-none">-</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'dipinjam')
                        <form action="{{ route('anggota.peminjaman.kembali', $item->id) }}" method="POST"
                              onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-kembali">
                                <i class="bi bi-arrow-return-left me-1"></i>Kembalikan
                            </button>
                        </form>
                        @else
                            <span style="font-size:12px; color:#aaa;">Sudah dikembalikan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="bi bi-bookmark-x"></i>
        <p class="mb-0 fw-semibold">Belum ada peminjaman aktif</p>
        <p style="font-size:13px;">Pergi ke <a href="/anggota/buku">Daftar Buku</a> untuk meminjam.</p>
    </div>
    @endif
</div>

@endsection