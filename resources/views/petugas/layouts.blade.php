<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f9;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 8px;
            margin-bottom: 32px;
            text-decoration: none;
        }

        .sidebar-brand i {
            font-size: 24px;
            color: white;
        }

        .sidebar-brand span {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: white;
        }

        .sidebar-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0.6;
            padding: 0 12px;
            margin-bottom: 8px;
            margin-top: 8px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.85);
            padding: 11px 14px;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 4px;
            transition: all 0.25s;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar a i {
            font-size: 17px;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            padding-left: 18px;
        }

        .sidebar a.active {
            background: rgba(255,255,255,0.25);
            color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        /* Badge notif merah di sidebar */
        .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            border-radius: 10px;
            padding: 1px 7px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar hr {
            border-color: rgba(255,255,255,0.2);
            margin: 16px 0;
        }

        .sidebar-footer {
            margin-top: auto;
        }

        /* ─── CONTENT ─── */
        .content {
            margin-left: 240px;
            padding: 24px;
            min-height: 100vh;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            background: linear-gradient(90deg, #4e73df, #224abe);
            padding: 14px 22px;
            border-radius: 14px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(78,115,223,0.35);
        }

        .topbar-title {
            font-weight: 600;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info span {
            font-size: 14px;
            font-weight: 500;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.5);
        }

        /* ─── CARD ─── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 12px 12px 0 0 !important;
            padding: 14px 18px;
        }

        /* ─── TABS ─── */
        .nav-tabs-custom {
            border-bottom: 1px solid #e2e8f0;
            padding: 0 18px;
            display: flex;
            gap: 4px;
            background: #fff;
            border-radius: 12px 12px 0 0;
        }

        .nav-tabs-custom .nav-link {
            font-size: 13px;
            padding: 11px 14px;
            color: #64748b;
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
            font-weight: 500;
            background: transparent;
            transition: color 0.15s;
        }

        .nav-tabs-custom .nav-link:hover {
            color: #4e73df;
            border-bottom-color: #c7d2fe;
        }

        .nav-tabs-custom .nav-link.active {
            color: #4e73df;
            border-bottom-color: #4e73df;
            font-weight: 600;
        }

        .tab-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
            border-radius: 10px;
            padding: 1px 7px;
            margin-left: 6px;
            height: 16px;
        }

        .tab-count-warning { background: #fef3c7; color: #92400e; }
        .tab-count-info    { background: #dbeafe; color: #1e40af; }
        .tab-count-success { background: #d1fae5; color: #065f46; }
        .tab-count-danger  { background: #fee2e2; color: #991b1b; }

        /* ─── BADGE STATUS ─── */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11.5px;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .badge-status::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .badge-menunggu         { background: #fef3c7; color: #92400e; }
        .badge-menunggu::before         { background: #f59e0b; }

        .badge-dipinjam         { background: #dbeafe; color: #1e40af; }
        .badge-dipinjam::before         { background: #3b82f6; }

        .badge-dikembalikan     { background: #d1fae5; color: #065f46; }
        .badge-dikembalikan::before     { background: #22c55e; }

        .badge-terlambat        { background: #fee2e2; color: #991b1b; }
        .badge-terlambat::before        { background: #ef4444; }

        /* ─── TABLE ─── */
        .table {
            margin: 0;
            font-size: 13.5px;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 16px;
        }

        .table td {
            padding: 12px 16px;
            vertical-align: middle;
            color: #1e293b;
            border-color: #f1f5f9;
        }

        /* ─── BUTTONS ─── */
        .btn { border-radius: 8px; }

        .btn-primary {
            background: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background: #224abe;
            border-color: #224abe;
        }

        .btn-sm { padding: 5px 11px; font-size: 12px; }

        /* ─── FORM ─── */
        .form-control, .form-select {
            border-color: #e2e8f0;
            border-radius: 8px;
            font-size: 13.5px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78,115,223,0.15);
        }

        /* ─── ALERT ─── */
        .alert { border-radius: 10px; font-size: 13.5px; border: none; }

        /* ─── SECTION LABEL (dipakai di modal detail) ─── */
        .section-label {
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #94a3b8;
            margin-bottom: 10px;
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- ─── SIDEBAR ─── -->
<div class="sidebar">
    <a href="{{ route('petugas.dashboard') }}" class="sidebar-brand">
        <i class="bi bi-journal-bookmark-fill"></i>
        <span>Perpustakaan</span>
    </a>

    {{-- Hitung pending sekali, dipakai sidebar & topbar --}}
    @php $pendingCount = \App\Models\Peminjaman::where('status', 'menunggu')->count(); @endphp

    <div class="sidebar-label">Menu</div>

    <a href="{{ route('petugas.dashboard') }}"
       class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i> Dashboard
    </a>

    <a href="{{ route('buku.index') }}"
       class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
        <i class="bi bi-book"></i> Kelola Buku
    </a>

    <a href="{{ route('kategori.index') }}"
       class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
        <i class="bi bi-grid"></i> Kelola Kategori
    </a>

    <a href="{{ route('petugas.anggota') }}"
       class="{{ request()->routeIs('petugas.anggota') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Data Anggota
    </a>

    <a href="{{ route('petugas.peminjaman') }}"
       class="{{ request()->routeIs('petugas.peminjaman.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i> Manajemen Peminjaman
        @if($pendingCount > 0)
            <span class="nav-badge">{{ $pendingCount }}</span>
        @endif
    </a>

    <div class="sidebar-footer">
        <hr>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

<!-- ─── CONTENT ─── -->
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title">
            <i class="bi bi-grid"></i>
            @yield('title')
        </div>
        <div class="user-info">
            <span>Halo, {{ auth()->user()->name ?? 'Petugas' }}</span>
            
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
