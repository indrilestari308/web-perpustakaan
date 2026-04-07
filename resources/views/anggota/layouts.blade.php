<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f9;
        }

        /* SIDEBAR */
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
        }

        .sidebar-brand i {
            font-size: 24px;
        }

        .sidebar-brand span {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
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

        .sidebar hr {
            border-color: rgba(255,255,255,0.2);
            margin: 16px 0;
        }

        .sidebar-footer {
            margin-top: auto;
        }

        /* CONTENT */
        .content {
            margin-left: 240px;
            padding: 24px;
            min-height: 100vh;
        }

        /* TOPBAR */
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
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-journal-bookmark-fill"></i>
        <span>Perpustakaan</span>
    </div>

    <div class="sidebar-label">Menu</div>

    <a href="/anggota/dashboard" class="{{ request()->is('anggota/dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i> Dashboard
    </a>

    <a href="/anggota/buku" class="{{ request()->is('anggota/buku') ? 'active' : '' }}">
        <i class="bi bi-book"></i> Daftar Buku
    </a>

    <a href="/anggota/peminjaman" class="{{ request()->is('anggota/peminjaman*') ? 'active' : '' }}">
        <i class="bi bi-bookmark-check"></i> Buku Saya
    </a>

    <a href="/anggota/riwayat" class="{{ request()->is('anggota/riwayat') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Riwayat
    </a>

    <a href="/anggota/profil" class="{{ request()->is('anggota/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil
    </a>

    <div class="sidebar-footer">
        <hr>
        <a href="/logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title">
            <i class="bi bi-grid"></i>
            @yield('title')
        </div>

        <div class="user-info">
            <span>Halo, {{ auth()->user()->name ?? 'User' }}</span>
            <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://i.pravatar.cc/40?u='.auth()->id() }}"
                 class="user-avatar">
        </div>
    </div>

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>