@extends('anggota.layouts')

@section('title', 'Riwayat Peminjaman')

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

.table tbody tr:hover {
    background: #f8f9ff;
}

.badge-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-dipinjam    { background: #e8f0ff; color: #4e73df; }
.badge-terlambat   { background: #ffe8e8; color: #e74c3c; }
.badge-dikembalikan{ background: #e8f9f0; color: #27ae60; }

.denda-text { color: #e74c3c; font-weight: 600; }
.denda-none { color: #aaa; font-size: 13px; }

.filter-bar {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.filter-bar select,
.filter-bar input {
    border-radius: 8px;
    border: 1px solid #e0e4f0;
    padding: 8px 12px;
    font-size: 13px;
    color: #555;
    background: #f8f9ff;
    outline: none;
}

.filter-bar select:focus,
.filter-bar input:focus {
    border-color: #4e73df;
    background: #fff;
}

.btn-filter {
    background: #4e73df;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 13px;
}

.btn-reset {
    background: #f0f2f9;
    color: #555;
    border: none;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
}

.summary-row {
    background: #f8f9ff;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.summary-item p { margin: 0; font-size: 11px; text-transform: uppercase; color: #999; letter-spacing: 0.5px; }
.summary-item h6 { margin: 2px 0 0; font-weight: 700; color: #333; }

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #aaa;
}
.empty-state i { font-size: 60px; margin-bottom: 16px; display: block; }
</style>

{{-- RINGKASAN --}}
<div class="summary-row mb-3">
    <div class="summary-item">
        <p>Total Pinjaman</p>
        <h6>{{ $riwayat->total() ?? 0 }} buku</h6>
    </div>
    <div class="summary-item">
        <p>Total Denda Dibayar</p>
        <h6>Rp {{ number_format($totalDendaDibayar ?? 0, 0, ',', '.') }}</h6>
    </div>
    <div class="summary-item">
        <p>Pernah Terlambat</p>
        <h6>{{ $pernahTerlambat ?? 0 }} kali</h6>
    </div>
</div>

<div class="card-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="fw-bold mb-0">Riwayat Peminjaman</h6>
        <a href="/anggota/peminjaman" class="btn btn-sm btn-outline-primary" style="border-radius:8px; font-size:13px;">
            <i class="bi bi-bookmark-check me-1"></i>Buku Saya
        </a>
    </div>

    {{-- FILTER --}}
    <form method="GET" action="{{ route('anggota.riwayat') }}" class="filter-bar mb-4">
        <select name="status">
            <option value="">Semua Status</option>
            <option value="dipinjam"     {{ request('status')=='dipinjam'     ? 'selected':'' }}>Dipinjam</option>
            <option value="dikembalikan" {{ request('status')=='dikembalikan' ? 'selected':'' }}>Dikembalikan</option>
            <option value="terlambat"    {{ request('status')=='terlambat'    ? 'selected':'' }}>Terlambat</option>
        </select>
        <input type="text" name="cari" placeholder="Cari judul buku..." value="{{ request('cari') }}">
        <button type="submit" class="btn-filter">
            <i class="bi bi-search me-1"></i>Filter
        </button>
        <a href="{{ route('anggota.riwayat') }}" class="btn-reset">Reset</a>
    </form>

    @if(isset($riwayat) && $riwayat->count() > 0)
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $i => $item)
                @php
                    $terlambatHari = 0;
                    if($item->tanggal_dikembalikan && $item->tanggal_kembali) {
                        $kembali = \Carbon\Carbon::parse($item->tanggal_dikembalikan);
                        $batas   = \Carbon\Carbon::parse($item->tanggal_kembali);
                        $terlambatHari = $kembali->gt($batas) ? $kembali->diffInDays($batas) : 0;
                    }
                    $denda = $item->denda ?? ($terlambatHari * 1000);
                @endphp
                <tr>
                    <td>{{ $riwayat->firstItem() + $i }}</td>
                    <td>
                        <div class="fw-semibold">{{ $item->buku->judul ?? '-' }}</div>
                        <div style="font-size:12px; color:#999;">{{ $item->buku->penulis ?? '' }}</div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                    <td>
                        @if($item->tanggal_dikembalikan)
                            {{ \Carbon\Carbon::parse($item->tanggal_dikembalikan)->format('d M Y') }}
                        @else
                            <span style="color:#aaa; font-size:12px;">Belum</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status == 'dikembalikan' && $terlambatHari == 0)
                            <span class="badge-status badge-dikembalikan">Dikembalikan</span>
                        @elseif($terlambatHari > 0)
                            <span class="badge-status badge-terlambat">Terlambat {{ $terlambatHari }}h</span>
                        @else
                            <span class="badge-status badge-dipinjam">Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        @if($denda > 0)
                            <span class="denda-text">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                        @else
                            <span class="denda-none">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $riwayat->withQueryString()->links() }}
    </div>

    @else
    <div class="empty-state">
        <i class="bi bi-clock-history"></i>
        <p class="mb-0 fw-semibold">Belum ada riwayat peminjaman</p>
        <p style="font-size:13px;">Riwayat akan muncul setelah kamu meminjam buku.</p>
    </div>
    @endif
</div>

@endsection