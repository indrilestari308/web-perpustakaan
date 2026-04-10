@extends('kepala.layouts')

@section('title', 'Data Buku')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
* { font-family: 'Plus Jakarta Sans', sans-serif; }

.dash-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 60%, #1a8cff 100%);
    border-radius: 20px;
    padding: 24px 32px;
    margin-bottom: 24px;
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
.dash-header h4 { font-size: 20px; font-weight: 800; margin: 0 0 4px; letter-spacing: -0.3px; }
.dash-header p  { margin: 0; opacity: 0.75; font-size: 13px; }

.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #f0f4ff;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }

.stat-card .s-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.stat-card .s-val { font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1; }
.stat-card .s-label { font-size: 11.5px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px; }

.table-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #f0f4ff;
    overflow: hidden;
}

.table-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}

.table-card-header .title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-wrap { position: relative; width: 240px; }
.search-wrap i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; }
.search-input {
    padding: 8px 12px 8px 32px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    font-size: 13px;
    width: 100%;
    outline: none;
    transition: border 0.18s, box-shadow 0.18s;
}
.search-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

.act-table { width: 100%; border-collapse: collapse; }
.act-table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 11px 16px;
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

.book-cover {
    width: 38px; height: 50px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #e2e8f0;
    flex-shrink: 0;
}
.book-cover-placeholder {
    width: 38px; height: 50px;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-radius: 5px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    border: 1px solid #bfdbfe;
}
.book-cover-placeholder i { color: #60a5fa; font-size: 16px; }

.badge-pill {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}
.pill-kategori  { background: #eff6ff; color: #1d4ed8; }
.pill-tersedia  { background: #f0fdf4; color: #16a34a; }
.pill-sedikit   { background: #fffbeb; color: #d97706; }
.pill-habis     { background: #fef2f2; color: #dc2626; }

.table-footer {
    padding: 12px 22px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.table-footer .info-text { font-size: 12.5px; color: #94a3b8; }

.empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
.empty-state i { font-size: 48px; margin-bottom: 12px; display: block; opacity: 0.4; }
</style>

{{-- HEADER --}}
<div class="dash-header">
    <h4><i class="bi bi-book me-2"></i>Data Buku</h4>
    <p>Pantau seluruh koleksi buku perpustakaan</p>
</div>

{{-- STATS --}}
@php
    $totalBuku   = $buku->count();
    $stokOke     = $buku->where('stok', '>', 3)->count();
    $stokSedikit = $buku->filter(fn($b) => $b->stok >= 1 && $b->stok <= 3)->count();
    $stokHabis   = $buku->where('stok', 0)->count();
@endphp

<div class="stats-row">
    <div class="stat-card">
        <div class="s-icon" style="background:#eff6ff;"><i class="bi bi-book-fill" style="color:#3b82f6;"></i></div>
        <div><div class="s-val">{{ $totalBuku }}</div><div class="s-label">Total Buku</div></div>
    </div>
    <div class="stat-card">
        <div class="s-icon" style="background:#f0fdf4;"><i class="bi bi-check-circle-fill" style="color:#22c55e;"></i></div>
        <div><div class="s-val">{{ $stokOke }}</div><div class="s-label">Stok Tersedia</div></div>
    </div>
    <div class="stat-card">
        <div class="s-icon" style="background:#fffbeb;"><i class="bi bi-exclamation-triangle-fill" style="color:#f59e0b;"></i></div>
        <div><div class="s-val">{{ $stokSedikit }}</div><div class="s-label">Stok Sedikit</div></div>
    </div>
    <div class="stat-card">
        <div class="s-icon" style="background:#fef2f2;"><i class="bi bi-x-circle-fill" style="color:#ef4444;"></i></div>
        <div><div class="s-val">{{ $stokHabis }}</div><div class="s-label">Stok Habis</div></div>
    </div>
</div>

{{-- TABLE --}}
<div class="table-card">
    <div class="table-card-header">
        <div class="title">
            <i class="bi bi-table" style="color:#3b82f6;"></i>
            Daftar Buku
        </div>
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Cari judul atau penulis...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="act-table" id="bukuTable">
            <thead>
                <tr>
                    <th style="width:45px;">No</th>
                    <th>Buku</th>
                    <th>Kategori</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Bahasa</th>
                    <th>Halaman</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="bukuBody">
                @forelse($buku as $i => $item)
                <tr class="buku-row"
                    data-judul="{{ strtolower($item->judul) }}"
                    data-penulis="{{ strtolower($item->penulis) }}">

                    <td style="color:#cbd5e1; font-size:12px;">{{ $i + 1 }}</td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="book-cover" alt="{{ $item->judul }}">
                            @else
                                <div class="book-cover-placeholder"><i class="bi bi-book"></i></div>
                            @endif
                            <div>
                                <div style="font-weight:600; font-size:13px; color:#0f172a;">{{ $item->judul }}</div>
                                <div style="font-size:11.5px; color:#94a3b8;">{{ $item->penulis }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        @php
                            // handle nama_kategori atau nama
                            $namaKategori = $item->kategori->nama_kategori
                                ?? $item->kategori->nama
                                ?? null;
                        @endphp
                        @if($namaKategori)
                            <span class="badge-pill pill-kategori">{{ $namaKategori }}</span>
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>

                    <td>{{ $item->penerbit ?? '—' }}</td>
                    <td>{{ $item->tahun_terbit ?? '—' }}</td>
                    <td>{{ $item->bahasa ?? '—' }}</td>
                    <td>{{ $item->jumlah_halaman ? number_format($item->jumlah_halaman) . ' hal' : '—' }}</td>

                    <td>
                        @if($item->stok == 0)
                            <span class="badge-pill pill-habis"><i class="bi bi-x-circle me-1"></i>Habis</span>
                        @elseif($item->stok <= 3)
                            <span class="badge-pill pill-sedikit"><i class="bi bi-exclamation-circle me-1"></i>{{ $item->stok }}</span>
                        @else
                            <span class="badge-pill pill-tersedia"><i class="bi bi-check-circle me-1"></i>{{ $item->stok }}</span>
                        @endif
                    </td>

                    <td>
                        @if($item->stok > 0)
                            <span class="badge-pill pill-tersedia">Tersedia</span>
                        @else
                            <span class="badge-pill pill-habis">Tidak Tersedia</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="bi bi-book"></i>
                            <p>Belum ada data buku</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span class="info-text" id="searchInfo">Menampilkan {{ $totalBuku }} buku</span>
    </div>
</div>

@endsection

@push('scripts')
<script>
const searchInput = document.getElementById('searchInput');
const rows        = document.querySelectorAll('.buku-row');
const searchInfo  = document.getElementById('searchInfo');

searchInput.addEventListener('input', function () {
    const keyword = this.value.toLowerCase().trim();
    let visible   = 0;

    rows.forEach(row => {
        const match = row.dataset.judul.includes(keyword) || row.dataset.penulis.includes(keyword);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    searchInfo.textContent = keyword
        ? `Menampilkan ${visible} dari ${rows.length} buku`
        : `Menampilkan ${rows.length} buku`;
});
</script>
@endpush