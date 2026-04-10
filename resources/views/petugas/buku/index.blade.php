@extends('petugas.layouts')

@section('title', 'Data Buku')

@section('content')

@php use Illuminate\Support\Str; @endphp

<style>
    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --primary-hover: #1d4ed8;
        --danger: #ef4444;
        --danger-light: #fef2f2;
        --success: #22c55e;
        --success-light: #f0fdf4;
        --warning: #f59e0b;
        --text-main: #111827;
        --text-muted: #6b7280;
        --border: #e5e7eb;
        --bg-page: #f8fafc;
        --bg-card: #ffffff;
        --radius: 14px;
        --shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.06);
    }

    body { background: var(--bg-page); }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .page-title .icon-wrap {
        width: 38px; height: 38px;
        background: var(--primary-light);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    .page-title .icon-wrap i { color: var(--primary); font-size: 18px; }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--primary);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        padding: 9px 18px;
        border-radius: 10px;
        text-decoration: none;
        transition: background 0.18s, transform 0.15s;
        box-shadow: 0 2px 8px rgba(37,99,235,0.18);
        border: none;
    }

    .btn-add:hover {
        background: var(--primary-hover);
        color: #fff;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .card-box {
        background: var(--bg-card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .search-bar {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .search-wrap {
        position: relative;
        flex: 1;
        max-width: 340px;
    }

    .search-wrap i {
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 14px;
    }

    .search-wrap input {
        width: 100%;
        padding: 8px 12px 8px 36px;
        border: 1px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        color: var(--text-main);
        outline: none;
        transition: border 0.18s;
        background: var(--bg-page);
    }

    .search-wrap input:focus { border-color: var(--primary); }

    .buku-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .buku-table thead tr {
        background: #f8fafc;
        border-bottom: 2px solid var(--border);
    }

    .buku-table th {
        padding: 11px 14px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--text-muted);
        text-align: left;
        white-space: nowrap;
    }

    .buku-table th.center, .buku-table td.center { text-align: center; }

    .buku-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.12s;
    }

    .buku-table tbody tr:hover { background: #f8fafd; }
    .buku-table tbody tr:last-child { border-bottom: none; }

    .buku-table td {
        padding: 12px 14px;
        vertical-align: middle;
        color: var(--text-main);
    }

    .book-cover {
        width: 44px;
        height: 60px;
        object-fit: cover;
        border-radius: 7px;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.13);
        display: block;
        border: 1.5px solid #e5e7eb;
        margin: auto;
    }

    .book-cover-placeholder {
        width: 44px;
        height: 60px;
        border-radius: 7px;
        background: #eff6ff;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #bfdbfe;
        margin: auto;
    }

    .book-cover-placeholder i { color: #93c5fd; font-size: 20px; }

    .book-title {
        font-weight: 600;
        color: var(--text-main);
        font-size: 13px;
        line-height: 1.4;
        display: block;
        max-width: 160px;
    }

    .book-author {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
        display: block;
    }

    .badge-kategori {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 30px;
        border: 1px solid #bfdbfe;
    }

    .badge-stok {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 30px;
        min-width: 36px;
        text-align: center;
    }

    .badge-stok.ok    { background: var(--success-light); color: #166534; border: 1px solid #bbf7d0; }
    .badge-stok.low   { background: #fffbeb; color: #92400e; border: 1px solid #fcd34d; }
    .badge-stok.empty { background: var(--danger-light); color: #991b1b; border: 1px solid #fecaca; }

    .row-no {
        width: 36px; height: 36px;
        background: #f1f5f9;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        margin: auto;
    }

    .action-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }

    .btn-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        border: 1px solid transparent;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
    }

    .btn-icon-edit {
        background: var(--primary-light);
        color: var(--primary);
        border-color: #bfdbfe;
    }

    .btn-icon-edit:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        transform: translateY(-1px);
    }

    .btn-icon-delete {
        background: var(--danger-light);
        color: var(--danger);
        border-color: #fecaca;
    }

    .btn-icon-delete:hover {
        background: var(--danger);
        color: #fff;
        border-color: var(--danger);
        transform: translateY(-1px);
    }

    .alert-success-custom {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--success-light);
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 13px;
        font-weight: 500;
        padding: 11px 16px;
        border-radius: 10px;
        margin-bottom: 18px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state .empty-icon {
        width: 64px; height: 64px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }

    .empty-state .empty-icon i { font-size: 28px; color: #cbd5e1; }
    .empty-state p { font-size: 14px; color: var(--text-muted); margin: 0; }

    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-top: 1px solid var(--border);
        font-size: 12.5px;
        color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .hide-sm { display: none !important; }
        .book-title { max-width: 110px; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <h1 class="page-title">
        <span class="icon-wrap"><i class="bi bi-book"></i></span>
        Data Buku
    </h1>
    <a href="{{ route('buku.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Tambah Buku
    </a>
</div>

<!-- ALERT -->
@if(session('success'))
    <div class="alert-success-custom">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

<!-- CARD TABLE -->
<div class="card-box">

    <!-- SEARCH -->
    <div class="search-bar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari judul, penulis, penerbit...">
        </div>
        <span style="font-size:12.5px; color:var(--text-muted);">
            {{ method_exists($buku, 'total') ? $buku->total() : count($buku) }} buku ditemukan
        </span>
    </div>

    <!-- TABLE -->
    <div style="overflow-x: auto;">
        <table class="buku-table" id="bukuTable">
            <thead>
                <tr>
                    <th class="center" style="width:52px;">No</th>
                    <th class="center" style="width:64px;">Cover</th>
                    <th>Judul / Penulis</th>
                    <th class="hide-sm">Penerbit</th>
                    <th class="hide-sm">Kategori</th>
                    <th class="center hide-sm">Tahun</th>
                    <th class="center hide-sm">Bahasa</th>
                    <th class="center hide-sm">Hal</th>
                    <th class="center">Stok</th>
                    <th class="center" style="width:90px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($buku as $b)
                <tr class="buku-row" data-search="{{ strtolower($b->judul . ' ' . $b->penulis . ' ' . $b->penerbit) }}">

                    <!-- NO -->
                    <td class="center">
                        <div class="row-no">
                            {{ $loop->iteration + (method_exists($buku, 'firstItem') ? $buku->firstItem() - 1 : 0) }}
                        </div>
                    </td>

                    <!-- COVER -->
                    <td class="center">
                        @if($b->gambar)
                            <img src="{{ asset('storage/' . $b->gambar) }}"
                                 alt="{{ $b->judul }}"
                                 class="book-cover" >
                        @else
                            <div class="book-cover-placeholder">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                    </td>

                    <!-- JUDUL + PENULIS -->
                    <td>
                        <span class="book-title">{{ Str::limit($b->judul, 35) }}</span>
                        <span class="book-author">{{ $b->penulis }}</span>
                    </td>

                    <!-- PENERBIT -->
                    <td class="hide-sm" style="color: var(--text-muted); font-size:12.5px;">
                        {{ $b->penerbit ?? '-' }}
                    </td>

                    <!-- KATEGORI -->
                    <td class="hide-sm">
                        @if(optional($b->kategori)->nama_kategori)
                            <span class="badge-kategori">{{ $b->kategori->nama_kategori }}</span>
                        @else
                            <span style="color:var(--text-muted);">-</span>
                        @endif
                    </td>

                    <!-- TAHUN -->
                    <td class="center hide-sm" style="color:var(--text-muted); font-size:12.5px;">
                        {{ $b->tahun_terbit ?? '-' }}
                    </td>

                    <!-- BAHASA -->
                    <td class="center hide-sm" style="color:var(--text-muted); font-size:12.5px;">
                        {{ $b->bahasa ?? '-' }}
                    </td>

                    <!-- HALAMAN -->
                    <td class="center hide-sm" style="color:var(--text-muted); font-size:12.5px;">
                        {{ $b->jumlah_halaman ? number_format($b->jumlah_halaman) : '-' }}
                    </td>

                    <!-- STOK -->
                    <td class="center">
                        @php
                            $stok = $b->stok ?? 0;
                            $cls  = $stok > 5 ? 'ok' : ($stok > 0 ? 'low' : 'empty');
                        @endphp
                        <span class="badge-stok {{ $cls }}">{{ $stok }}</span>
                    </td>

                    <!-- AKSI -->
                    <td class="center">
                        <div class="action-wrap">
                            <a href="{{ route('buku.edit', $b->id) }}"
                               class="btn-icon btn-icon-edit" title="Edit buku">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('buku.destroy', $b->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-delete" title="Hapus buku">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <p>Belum ada data buku. Silakan tambahkan buku baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- FOOTER PAGINATION -->
    @if(method_exists($buku, 'links') && $buku->lastPage() > 1)
    <div class="table-footer">
        <span>
            Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }}
            dari {{ $buku->total() }} buku
        </span>
        <div>{{ $buku->links() }}</div>
    </div>
    @endif

</div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.buku-row').forEach(function (row) {
        const text = row.getAttribute('data-search') || '';
        row.style.display = text.includes(q) ? '' : 'none';
    });
});
</script>

@endsection
