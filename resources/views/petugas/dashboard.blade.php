@extends('petugas.layouts')

@section('title', 'Dashboard')

@section('content')

<style>
    :root {
        --bg-page: #f8fafc;
        --bg-card: #ffffff;
        --text-main: #111827;
        --text-muted: #6b7280;
        --text-hint: #9ca3af;
        --border: #e5e7eb;
        --border-light: #f1f5f9;
        --radius: 14px;
        --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.05);
    }

    body { background: var(--bg-page); }

    /* ── GREETING ─────────────────────── */
    .dashboard-greeting {
        margin-bottom: 24px;
    }

    .greeting-name {
        font-size: 21px;
        font-weight: 700;
        color: var(--text-main);
    }

    .greeting-sub {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    /* ── STAT CARDS ───────────────────── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    @media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        padding: 18px 20px;
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
        transition: transform .15s, box-shadow .15s;
        cursor: default;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.09);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }

    .stat-icon i { font-size: 16px; }

    .stat-label {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--text-muted);
        margin-bottom: 5px;
    }

    .stat-val {
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-meta {
        font-size: 11.5px;
        color: var(--text-hint);
    }

    .stat-accent {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 0 0 14px 14px;
    }

    /* COLOR THEMES */
    .stat-blue  .stat-icon { background: #eff6ff; }
    .stat-blue  .stat-icon i { color: #3b82f6; }
    .stat-blue  .stat-val { color: #1d4ed8; }
    .stat-blue  .stat-accent { background: #3b82f6; }

    .stat-teal  .stat-icon { background: #e1f5ee; }
    .stat-teal  .stat-icon i { color: #1d9e75; }
    .stat-teal  .stat-val { color: #0f6e56; }
    .stat-teal  .stat-accent { background: #1d9e75; }

    .stat-amber .stat-icon { background: #faeeda; }
    .stat-amber .stat-icon i { color: #f59e0b; }
    .stat-amber .stat-val { color: #854f0b; }
    .stat-amber .stat-accent { background: #f59e0b; }

    .stat-red   .stat-icon { background: #fef2f2; }
    .stat-red   .stat-icon i { color: #ef4444; }
    .stat-red   .stat-val { color: #991b1b; }
    .stat-red   .stat-accent { background: #ef4444; }

    /* ── BOTTOM GRID ──────────────────── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
    }

    @media (max-width: 800px) { .bottom-grid { grid-template-columns: 1fr; } }

    /* ── SECTION CARD ─────────────────── */
    .section-card {
        background: var(--bg-card);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .section-head {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-head h3 {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }

    .section-head a {
        font-size: 12px;
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .section-head a:hover { text-decoration: underline; }

    /* ── TABLE ────────────────────────── */
    .pinjam-table { width: 100%; border-collapse: collapse; }

    .pinjam-table th {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--text-hint);
        padding: 10px 16px;
        text-align: left;
        background: #fafafa;
        border-bottom: 1px solid var(--border-light);
    }

    .pinjam-table td {
        font-size: 13px;
        color: #374151;
        padding: 11px 16px;
        border-bottom: 1px solid #f9fafb;
        vertical-align: middle;
    }

    .pinjam-table tbody tr:last-child td { border-bottom: none; }

    .pinjam-table tbody tr:hover td { background: #fafcff; }

    /* AVATAR */
    .member-row { display: flex; align-items: center; gap: 9px; }

    .avatar-initials {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* BADGE */
    .status-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
    }

    .badge-dipinjam  { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-terlambat { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    .badge-kembali   { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

    /* ── NOTIFIKASI ───────────────────── */
    .notif-list { }

    .notif-item {
        padding: 13px 18px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        gap: 11px;
        align-items: flex-start;
    }

    .notif-item:last-child { border-bottom: none; }

    .notif-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 5px;
    }

    .notif-dot.danger  { background: #ef4444; }
    .notif-dot.warning { background: #f59e0b; }
    .notif-dot.success { background: #22c55e; }
    .notif-dot.info    { background: #3b82f6; }

    .notif-text {
        font-size: 12.5px;
        color: #374151;
        line-height: 1.5;
    }

    .notif-time {
        font-size: 11px;
        color: var(--text-hint);
        margin-top: 2px;
    }

    /* EMPTY STATE */
    .empty-cell {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-hint);
        font-size: 13px;
    }
</style>



<!-- STAT CARDS -->
<div class="stat-grid">

    <div class="stat-card stat-blue">
        <div class="stat-icon">
            <i class="fa-solid fa-book-open"></i>
        </div>
        <div class="stat-label">Total Buku</div>
        <div class="stat-val">{{ number_format($totalBuku ?? 0) }}</div>
        <div class="stat-meta">
            @if(isset($bukuBaru) && $bukuBaru > 0)
                <span style="color:#1d4ed8; font-weight:600">+{{ $bukuBaru }}</span> buku bulan ini
            @else
                Koleksi perpustakaan
            @endif
        </div>
        <div class="stat-accent"></div>
    </div>

    <div class="stat-card stat-teal">
        <div class="stat-icon">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </div>
        <div class="stat-label">Sedang Dipinjam</div>
        <div class="stat-val">{{ number_format($totalDipinjam ?? 0) }}</div>
        <div class="stat-meta">
            @if(isset($totalTerlambat) && $totalTerlambat > 0)
                <span style="color:#dc2626; font-weight:600">{{ $totalTerlambat }}</span> terlambat dikembalikan
            @else
                Semua tepat waktu
            @endif
        </div>
        <div class="stat-accent"></div>
    </div>

    <div class="stat-card stat-amber">
        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-label">Total Anggota</div>
        <div class="stat-val">{{ number_format($totalAnggota ?? 0) }}</div>
        <div class="stat-meta">
            @if(isset($anggotaBaru) && $anggotaBaru > 0)
                <span style="color:#854f0b; font-weight:600">+{{ $anggotaBaru }}</span> anggota baru
            @else
                Anggota aktif
            @endif
        </div>
        <div class="stat-accent"></div>
    </div>

    <div class="stat-card stat-red">
        <div class="stat-icon">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div class="stat-label">Total Denda</div>
        <div class="stat-val" style="font-size: 18px; padding-top: 4px;">
            Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}
        </div>
        <div class="stat-meta">
            @if(isset($dendaBelumBayar) && $dendaBelumBayar > 0)
                <span style="color:#991b1b; font-weight:600">{{ $dendaBelumBayar }}</span> belum dibayar
            @else
                Semua lunas
            @endif
        </div>
        <div class="stat-accent"></div>
    </div>

</div>

<!-- BOTTOM SECTION -->
<div class="bottom-grid">
<!-- TABEL PEMINJAMAN TERBARU -->
    <div class="section-card">
        <div class="section-head">
            <h3><i class="fa-solid fa-clock-rotate-left" style="color:#2563eb; margin-right:7px;"></i> Peminjaman Terbaru</h3>
            <a href="{{ route('petugas.peminjaman') }}">Lihat semua →</a>
        </div>

        <div style="overflow-x: auto;">
            <table class="pinjam-table">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tenggat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamanTerbaru ?? [] as $p)
                    @php
                        $terlambat = $p->tanggal_kembali && now()->gt($p->tanggal_kembali) && !$p->tanggal_dikembalikan;
                        $kembali   = (bool) $p->tanggal_dikembalikan;
                        $menunggu  = $p->status === 'menunggu';
                        $inisial   = collect(explode(' ', $p->user->name ?? 'U N'))
                                        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                        ->take(2)
                                        ->join('');
                        $colors = ['#eff6ff|#1d4ed8','#faeeda|#854f0b','#eeedfe|#3c3489','#fbeaf0|#72243e','#e1f5ee|#0f6e56'];
                        $c = explode('|', $colors[$loop->index % count($colors)]);
                    @endphp
                    <tr>
                        <td>
                            <div class="member-row">
                                <div class="avatar-initials" style="background:{{ $c[0] }}; color:{{ $c[1] }}">
                                    {{ $inisial }}
                                </div>
                                <span>{{ $p->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($p->buku->judul ?? '-', 28) }}</td>
                        <td style="white-space:nowrap; color: {{ $terlambat ? '#991b1b' : 'inherit' }}; font-weight: {{ $terlambat ? '600' : '400' }}">
                            {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M') }}
                        </td>
                        <td>
                            @if($kembali)
                                <span class="status-badge badge-kembali">Dikembalikan</span>
                            @elseif($menunggu)
                                <span class="status-badge badge-menunggu">Menunggu</span>
                            @elseif($terlambat)
                                <span class="status-badge badge-terlambat">Terlambat</span>
                            @else
                                <span class="status-badge badge-dipinjam">Dipinjam</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-cell">
                            <i class="fa-solid fa-inbox" style="font-size:22px; margin-bottom:6px; display:block; color:#d1d5db"></i>
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- NOTIFIKASI -->
    <div class="section-card">
        <div class="section-head">
            <h3><i class="fa-solid fa-bell" style="color:#f59e0b; margin-right:7px;"></i> Notifikasi</h3>
        </div>
        <div class="notif-list">

            @if(isset($totalTerlambat) && $totalTerlambat > 0)
            <div class="notif-item">
                <div class="notif-dot danger"></div>
                <div>
                    <div class="notif-text">
                        <strong>{{ $totalTerlambat }} peminjaman</strong> melewati tenggat pengembalian
                    </div>
                    <div class="notif-time">Perlu tindakan</div>
                </div>
            </div>
            @endif

            @if(isset($stokHabis) && $stokHabis > 0)
            <div class="notif-item">
                <div class="notif-dot warning"></div>
                <div>
                    <div class="notif-text">
                        <strong>{{ $stokHabis }} buku</strong> stoknya habis atau hampir habis
                    </div>
                    <div class="notif-time">Segera restock</div>
                </div>
            </div>
            @endif

            @if(isset($dendaBelumBayar) && $dendaBelumBayar > 0)
            <div class="notif-item">
                <div class="notif-dot danger"></div>
                <div>
                    <div class="notif-text">
                        <strong>{{ $dendaBelumBayar }} denda</strong> belum dibayarkan
                    </div>
                    <div class="notif-time">Tagih ke anggota</div>
                </div>
            </div>
            @endif

            @if(isset($anggotaBaru) && $anggotaBaru > 0)
            <div class="notif-item">
                <div class="notif-dot info"></div>
                <div>
                    <div class="notif-text">
                        <strong>{{ $anggotaBaru }} anggota baru</strong> mendaftar bulan ini
                    </div>
                    <div class="notif-time">Bulan ini</div>
                </div>
            </div>
            @endif

            @if(isset($bukuBaru) && $bukuBaru > 0)
            <div class="notif-item">
                <div class="notif-dot success"></div>
                <div>
                    <div class="notif-text">
                        <strong>{{ $bukuBaru }} buku baru</strong> ditambahkan bulan ini
                    </div>
                    <div class="notif-time">Koleksi diperbarui</div>
                </div>
            </div>
            @endif

            @if(
                (!isset($totalTerlambat) || !$totalTerlambat) &&
                (!isset($stokHabis) || !$stokHabis) &&
                (!isset($dendaBelumBayar) || !$dendaBelumBayar) &&
                (!isset($anggotaBaru) || !$anggotaBaru) &&
                (!isset($bukuBaru) || !$bukuBaru)
            )
            <div class="notif-item">
                <div class="notif-dot success"></div>
                <div>
                    <div class="notif-text">Semua berjalan lancar, tidak ada notifikasi baru.</div>
                    <div class="notif-time">Hari ini</div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@endsection
