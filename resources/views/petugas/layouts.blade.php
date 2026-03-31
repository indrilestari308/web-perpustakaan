<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: #f8fafc;
    }

    /* SIDEBAR */
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        background: linear-gradient(180deg, #3b82f6, #06b6d4);
        color: white;
        padding: 25px 20px;
        box-shadow: 4px 0 15px rgba(0,0,0,0.05);
    }

    .sidebar h4 {
        font-weight: 600;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255,255,255,0.9);
        padding: 12px 15px;
        margin-bottom: 12px;
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.25s ease;
        font-size: 14px;
    }

    .sidebar a i {
        width: 20px;
        text-align: center;
    }

    /* HOVER */
    .sidebar a:hover {
        background: rgba(255,255,255,0.15);
        transform: translateX(5px);
    }

    /* ACTIVE 🔥 */
    .sidebar a.active {
        background: white;
        color: #3b82f6;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* CONTENT */
    .content {
        margin-left: 260px;
        padding: 25px;
    }

    /* TOPBAR */
    .topbar {
        background: white;
        padding: 15px 25px;
        border-radius: 15px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .topbar h5 {
        margin: 0;
        font-weight: 600;
    }

    .topbar div {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #555;
    }

    .topbar i {
        font-size: 18px;
    }

    /* CARD */
    .card-dashboard {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .card-dashboard:hover {
        transform: translateY(-3px);
    }

    /* TABLE */
    .table {
        margin-top: 10px;
    }

    .table thead {
        background: #f1f5f9;
    }

    .table th {
        border: none;
        font-weight: 600;
        color: #555;
    }

    .table td {
        vertical-align: middle;
    }

    /* BUTTON */
    .btn {
        border-radius: 10px;
        padding: 6px 12px;
    }

    .btn-success {
        background: #22c55e;
        border: none;
    }

    .btn-success:hover {
        background: #16a34a;
    }

    /* BADGE */
    .badge {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
    }

    /* SCROLLBAR (BONUS 🔥) */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5f5;
        border-radius: 10px;
    }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4><i class="fa fa-book"></i> Petugas</h4>

        <a href="{{ route('petugas.dashboard') }}"
        class="{{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <i class="fa fa-home"></i> Dashboard
        </a>

        <a href="{{ route('buku.index') }}"
        class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
            <i class="fa fa-book-open"></i> Kelola Buku
        </a>

        <a href="{{ route('kategori.index') }}"
        class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="fa fa-layer-group"></i> Kelola Kategori
        </a>

        <a href="{{ route('petugas.anggota') }}"
        class="{{ request()->routeIs('anggota') ? 'active' : '' }}">
            <i class="fa fa-users"></i> Data Anggota
        </a>

        <a href="{{ route('petugas.denda') }}"
        class="{{ request()->routeIs('denda') ? 'active' : '' }}">
            <i class="fa fa-money-bill"></i> Data Denda
        </a>

    <hr>

    <a href="#">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <h5>@yield('title')</h5>
        <div>
            <i class="fa fa-user-circle"></i> Petugas
        </div>
    </div>

    <!-- ISI -->
    @yield('content')

</div>

</body>
</html>
