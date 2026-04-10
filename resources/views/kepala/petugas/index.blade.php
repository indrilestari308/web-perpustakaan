@extends('kepala.layouts')

@section('title', 'Data Petugas')

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
    grid-template-columns: repeat(3, 1fr);
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
    font-size: 20px; flex-shrink: 0;
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

.toolbar {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.search-wrap { position: relative; width: 240px; }
.search-wrap i { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; }
.search-input {
    padding: 8px 12px 8px 32px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    font-size: 13px;
    width: 100%;
    outline: none;
    transition: border 0.18s, box-shadow 0.18s;
    font-family: inherit;
}
.search-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

.toolbar-right { display: flex; align-items: center; gap: 10px; }

.data-count {
    font-size: 12px;
    color: #64748b;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 5px 12px;
    font-weight: 600;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #3b82f6;
    color: #fff;
    padding: 8px 16px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.15s;
}
.btn-add:hover { background: #2563eb; color: #fff; }

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

.avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: #eff6ff;
    color: #3b82f6;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}

.badge-pill {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}
.pill-petugas { background: #eff6ff; color: #1d4ed8; }

.btn-edit {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 11px;
    border-radius: 7px;
    border: 1px solid #e2e8f0;
    background: #fff;
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    text-decoration: none;
    transition: background 0.12s;
    font-family: inherit;
}
.btn-edit:hover { background: #f8fafc; color: #334155; }

.btn-del {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 11px;
    border-radius: 7px;
    border: 1px solid #fecaca;
    background: #fef2f2;
    color: #dc2626;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.12s;
    font-family: inherit;
}
.btn-del:hover { background: #fee2e2; }

.table-footer {
    padding: 12px 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12px;
    color: #94a3b8;
}

.empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
.empty-state i { font-size: 40px; opacity: 0.3; display: block; margin-bottom: 10px; }
</style>

{{-- HEADER --}}
<div class="dash-header">
    <h4><i class="bi bi-people-fill me-2"></i>Data Petugas</h4>
    <p>Manajemen akun petugas sistem perpustakaan</p>
</div>

{{-- STATS --}}
@php $totalPetugas = $petugas->total(); @endphp

<div class="stats-row">
    <div class="stat-card">
        <div class="s-icon" style="background:#eff6ff;"><i class="bi bi-people-fill" style="color:#3b82f6;"></i></div>
        <div><div class="s-val">{{ $totalPetugas }}</div><div class="s-label">Total Petugas</div></div>
    </div>
    <div class="stat-card">
        <div class="s-icon" style="background:#f0fdf4;"><i class="bi bi-shield-check" style="color:#22c55e;"></i></div>
        <div>
            <div class="s-val">{{ \App\Models\User::where('role', 'petugas')->count() }}</div>
            <div class="s-label">Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="s-icon" style="background:#fffbeb;"><i class="bi bi-person-badge" style="color:#f59e0b;"></i></div>
        <div>
            <div class="s-val">{{ \App\Models\User::where('role', 'anggota')->count() }}</div>
            <div class="s-label">Total Anggota</div>
        </div>
    </div>
</div>

{{-- NOTIF --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:12px; font-size:13px;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- TABLE CARD --}}
<div class="table-card">
    <div class="toolbar">
        <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Cari nama atau email...">
        </div>
        <div class="toolbar-right">
            <span class="data-count" id="dataCount">{{ $totalPetugas }} data</span>
            <a href="{{ route('kepala.petugas.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Petugas
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="act-table">
            <thead>
                <tr>
                    <th style="width:45px;">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($petugas as $p)
                <tr class="row-data" data-search="{{ strtolower($p->name . ' ' . $p->email) }}">
                    <td style="color:#cbd5e1; font-size:12px;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar">
                                {{ strtoupper(substr($p->name, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:600; font-size:13px;">{{ $p->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:#64748b;">{{ $p->email }}</td>
                    <td>
                        <span class="badge-pill pill-petugas">{{ ucfirst($p->role) }}</span>
                    </td>
                    <td style="text-align:center;">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('kepala.petugas.edit', $p->id) }}" class="btn-edit">
                                <i class="bi bi-pencil" style="font-size:11px;"></i> Edit
                            </a>
                            <form action="{{ route('kepala.petugas.destroy', $p->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus petugas {{ $p->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del">
                                    <i class="bi bi-trash3" style="font-size:11px;"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>Belum ada data petugas</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($petugas->hasPages())
    <div class="table-footer">
        Menampilkan {{ $petugas->firstItem() }}–{{ $petugas->lastItem() }} dari {{ $petugas->total() }} data
        <div class="mt-2">{{ $petugas->links() }}</div>
    </div>
    @else
    <div class="table-footer">
        Menampilkan {{ $petugas->count() }} data
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('.row-data');
    let visible = 0;

    rows.forEach(row => {
        const match = !q || row.dataset.search.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    document.getElementById('dataCount').textContent = visible + ' data';
});
</script>
@endpush