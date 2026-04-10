@extends('kepala.layouts')

@section('title', 'Dashboard Kepala')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

* { font-family: 'Plus Jakarta Sans', sans-serif; }

.mono { font-family: 'DM Mono', monospace; }

.dash-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 60%, #1a8cff 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    color: white;
}

.dash-header::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
}

.dash-header::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 80px;
    width: 150px; height: 150px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
}

.dash-header h4 {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 4px;
    letter-spacing: -0.3px;
}

.dash-header p {
    margin: 0;
    opacity: 0.75;
    font-size: 13.5px;
}

.dash-header .date-chip {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 12px;
    letter-spacing: 0.3px;
}

/* STAT CARDS */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 22px 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #f0f4ff;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

.stat-card .stat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    margin-bottom: 14px;
}

.stat-card .stat-value {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
    margin-bottom: 4px;
    letter-spacing: -0.5px;
}

.stat-card .stat-label {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card .stat-accent {
    position: absolute;
    bottom: 0; right: 0;
    width: 70px; height: 70px;
    border-radius: 50% 0 0 0;
    opacity: 0.07;
}

.card-blue .stat-icon  { background: #eff6ff; color: #3b82f6; }
.card-blue .stat-accent { background: #3b82f6; }
.card-green .stat-icon  { background: #f0fdf4; color: #22c55e; }
.card-green .stat-accent { background: #22c55e; }
.card-amber .stat-icon  { background: #fffbeb; color: #f59e0b; }
.card-amber .stat-accent { background: #f59e0b; }
.card-red .stat-icon    { background: #fef2f2; color: #ef4444; }
.card-red .stat-accent  { background: #ef4444; }

/* GRID BAWAH */
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
}

.section-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #f0f4ff;
    overflow: hidden;
}

.section-card .card-head {
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.section-card .card-head h6 {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

.section-card .card-head a {
    font-size: 12px;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
}

/* TABLE */
.act-table { width: 100%; border-collapse: collapse; }
.act-table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 10px 16px;
    border-bottom: 1px solid #f1f5f9;
}

.act-table tbody td {
    padding: 13px 16px;
    font-size: 13px;
    color: #334155;
    border-bottom: 1px solid #f8fafc;
    vertical-align: middle;
}

.act-table tbody tr:last-child td { border-bottom: none; }
.act-table tbody tr:hover td { background: #fafbff; }

.avatar-circle {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2d6a9f);
    color: white;
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.badge-pill {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}

.pill-dipinjam      { background: #eff6ff; color: #3b82f6; }
.pill-dikembalikan  { background: #f0fdf4; color: #22c55e; }
.pill-terlambat     { background: #fef2f2; color: #ef4444; }
.pill-menunggu      { background: #fffbeb; color: #f59e0b; }
.pill-menunggu_kembali { background: #fff7ed; color: #f97316; }
.pill-ditolak       { background: #f1f5f9; color: #64748b; }

/* SIDE PANEL */
.side-panel { display: flex; flex-direction: column; gap: 20px; }

.info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 22px;
    border-bottom: 1px solid #f8fafc;
}

.info-row:last-child { border-bottom: none; }

.info-row .info-label {
    font-size: 12.5px;
    color: #64748b;
    font-weight: 500;
}

.info-row .info-val {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
}

/* STATUS BAR */
.status-bar-wrap { padding: 18px 22px; }
.status-bar-label {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 6px;
    font-weight: 500;
}

.status-bar {
    height: 8px;
    border-radius: 8px;
    background: #f1f5f9;
    overflow: hidden;
    margin-bottom: 14px;
}

.status-bar-fill {
    height: 100%;
    border-radius: 8px;
    transition: width 0.8s ease;
}

.empty-row td {
    text-align: center;
    padding: 40px !important;
    color: #94a3b8;
    font-size: 13px;
}
</style>


  
{{-- STAT CARDS --}}
<div class="stat-grid">
    <div class="stat-card card-blue">
        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        <div class="stat-value">{{ $totalAnggota }}</div>
        <div class="stat-label">Total Anggota</div>
        <div class="stat-accent"></div>
    </div>

    <div class="stat-card card-amber">
        <div class="stat-icon"><i class="bi bi-book-fill"></i></div>
        <div class="stat-value">{{ $bukuDipinjam }}</div>
        <div class="stat-label">Buku Dipinjam</div>
        <div class="stat-accent"></div>
    </div>

    <div class="stat-card card-green">
        <div class="stat-icon"><i class="bi bi-arrow-return-left"></i></div>
        <div class="stat-value">{{ $pengembalian }}</div>
        <div class="stat-label">Dikembalikan</div>
        <div class="stat-accent"></div>
    </div>

    <div class="stat-card card-red">
        <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
        <div class="stat-value mono" style="font-size:20px;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        <div class="stat-label">Total Denda</div>
        <div class="stat-accent"></div>
    </div>
</div>

{{-- BOTTOM GRID --}}
<div class="bottom-grid">

    {{-- TABEL AKTIVITAS --}}
    <div class="section-card">
        <div class="card-head">
            <h6><i class="bi bi-activity me-2" style="color:#3b82f6;"></i>Aktivitas Peminjaman Terbaru</h6>
            <a href="{{ route('kepala.laporan') }}">Lihat semua →</a>
        </div>
        <div class="table-responsive">
            <table class="act-table">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aktivitas as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($item->user->name ?? '?', 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600; font-size:13px;">{{ $item->user->name ?? '-' }}</div>
                                    <div style="font-size:11px; color:#94a3b8;">{{ $item->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:500;">{{ Str::limit($item->buku->judul ?? '-', 30) }}</div>
                            <div style="font-size:11px; color:#94a3b8;">{{ $item->buku->penulis ?? '' }}</div>
                        </td>
                        <td>
                            {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}
                        </td>
                        <td>
                            {{ $item->batas_kembali ? \Carbon\Carbon::parse($item->batas_kembali)->format('d M Y') : '-' }}
                        </td>
                        <td>
                            @php
                                $pillMap = [
                                    'menunggu'         => ['pill-menunggu',         'Menunggu'],
                                    'dipinjam'         => ['pill-dipinjam',         'Dipinjam'],
                                    'menunggu_kembali' => ['pill-menunggu_kembali', 'Proses Kembali'],
                                    'dikembalikan'     => ['pill-dikembalikan',     'Dikembalikan'],
                                    'terlambat'        => ['pill-terlambat',        'Terlambat'],
                                    'ditolak'          => ['pill-ditolak',          'Ditolak'],
                                ];
                                [$pillCls, $pillLabel] = $pillMap[$item->status] ?? ['pill-dipinjam', $item->status];
                            @endphp
                            <span class="badge-pill {{ $pillCls }}">{{ $pillLabel }}</span>
                        </td>
                        <td>
                            @if($item->denda > 0)
                                <span style="color:#ef4444; font-weight:600; font-size:12px;">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span style="color:#cbd5e1;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="6">
                            <i class="bi bi-inbox" style="font-size:28px; opacity:0.3; display:block; margin-bottom:8px;"></i>
                            Belum ada aktivitas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SIDE PANEL --}}
    <div class="side-panel">

        {{-- RINGKASAN STATUS --}}
        <div class="section-card">
            <div class="card-head">
                <h6><i class="bi bi-bar-chart-fill me-2" style="color:#3b82f6;"></i>Ringkasan Status</h6>
            </div>
            @php
                $totalPeminjaman = \App\Models\Peminjaman::count() ?: 1;
                $jmlMenunggu     = \App\Models\Peminjaman::where('status', 'menunggu')->count();
                $jmlDipinjam     = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
                $jmlKembali      = \App\Models\Peminjaman::where('status', 'dikembalikan')->count();
                $jmlMenungguKembali = \App\Models\Peminjaman::where('status', 'menunggu_kembali')->count();
            @endphp
            <div class="status-bar-wrap">
                <div class="status-bar-label">
                    <span>Dipinjam</span>
                    <span style="color:#f59e0b; font-weight:700;">{{ $jmlDipinjam }}</span>
                </div>
                <div class="status-bar">
                    <div class="status-bar-fill" style="width:{{ round($jmlDipinjam/$totalPeminjaman*100) }}%; background:#f59e0b;"></div>
                </div>

                <div class="status-bar-label">
                    <span>Proses Kembali</span>
                    <span style="color:#f97316; font-weight:700;">{{ $jmlMenungguKembali }}</span>
                </div>
                <div class="status-bar">
                    <div class="status-bar-fill" style="width:{{ round($jmlMenungguKembali/$totalPeminjaman*100) }}%; background:#f97316;"></div>
                </div>

                <div class="status-bar-label">
                    <span>Dikembalikan</span>
                    <span style="color:#22c55e; font-weight:700;">{{ $jmlKembali }}</span>
                </div>
                <div class="status-bar">
                    <div class="status-bar-fill" style="width:{{ round($jmlKembali/$totalPeminjaman*100) }}%; background:#22c55e;"></div>
                </div>

                <div class="status-bar-label">
                    <span>Menunggu Konfirmasi</span>
                    <span style="color:#f59e0b; font-weight:700;">{{ $jmlMenunggu }}</span>
                </div>
                <div class="status-bar">
                    <div class="status-bar-fill" style="width:{{ round($jmlMenunggu/$totalPeminjaman*100) }}%; background:#fbbf24;"></div>
                </div>
            </div>
        </div>

        {{-- INFO CEPAT --}}
        <div class="section-card">
            <div class="card-head">
                <h6><i class="bi bi-info-circle-fill me-2" style="color:#3b82f6;"></i>Info Perpustakaan</h6>
            </div>
            @php
                $totalBuku  = \App\Models\Buku::count();
                $totalStok  = \App\Models\Buku::sum('stok');
                $totalPetugas = \App\Models\User::where('role', 'petugas')->count();
                $terlambatCount = \App\Models\Peminjaman::where('status', 'dipinjam')
                    ->where('batas_kembali', '<', \Carbon\Carbon::now())
                    ->count();
            @endphp
            <div class="info-row">
                <span class="info-label"><i class="bi bi-book me-2" style="color:#3b82f6;"></i>Total Judul Buku</span>
                <span class="info-val">{{ $totalBuku }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-stack me-2" style="color:#22c55e;"></i>Total Stok</span>
                <span class="info-val">{{ $totalStok }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-person-badge me-2" style="color:#f59e0b;"></i>Jumlah Petugas</span>
                <span class="info-val">{{ $totalPetugas }}</span>
            </div>
            <div class="info-row" style="border-bottom:none;">
                <span class="info-label"><i class="bi bi-exclamation-triangle me-2" style="color:#ef4444;"></i>Terlambat</span>
                <span class="info-val" style="color:#ef4444;">{{ $terlambatCount }}</span>
            </div>
        </div>

    </div>
</div>

@endsection
