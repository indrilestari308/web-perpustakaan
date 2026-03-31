<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f5f6fa;
}

/* SIDEBAR */
.sidebar {
    width: 250px;
    height: 100vh;
    background: linear-gradient(180deg, #4e73df, #224abe);
    color: white;
    position: fixed;
    padding: 20px;
}

/* LOGO / TITLE */
.sidebar h4 {
    font-weight: 600;
    margin-bottom: 30px;
    letter-spacing: 1px;
}

/* MENU */
.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
    padding: 12px;
    text-decoration: none;
    border-radius: 10px;
    margin-bottom: 6px;
    transition: 0.3s;
    font-size: 15px;
}

.sidebar a i {
    font-size: 18px;
}

/* HOVER */
.sidebar a:hover {
    background: rgba(255,255,255,0.2);
    padding-left: 16px;
}

/* ACTIVE */
.sidebar a.active {
    background: rgba(255,255,255,0.3);
}

/* CONTENT */
.content {
    margin-left: 250px;
    padding: 20px;
}

/* NAVBAR */
.navbar-custom {
    background: linear-gradient(90deg, #4e73df, #224abe);
    padding: 15px 20px;
    border-radius: 15px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* USER INFO */
.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-info img {
    width: 40px;
    height: 40px;
}

/* CARD */
.card-box {
    background: #ffffff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

/* TABLE */
.table thead {
    background: #4e73df;
    color: white;
}

/* BADGE */
.badge-warning {
    background: orange;
}

.badge-success {
    background: green;
}
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>Perpustakaan</h4>

    <a href="/anggota/dashboard" class="{{ request()->is('anggota/dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i> Dashboard
    </a>

    <a href="/anggota/buku" class="{{ request()->is('anggota/buku') ? 'active' : '' }}">
        <i class="bi bi-book"></i> Daftar Buku
    </a>


    <a href="/anggota/profil" class="{{ request()->is('anggota/profil') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profil
    </a>

    <hr>

    <a href="/logout">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- NAVBAR -->
    <div class="navbar-custom mb-4">
        <strong>@yield('title')</strong>

        <div class="user-info">
            <span>Halo, {{ auth()->user()->name ?? 'User' }}</span>
            <img src="https://i.pravatar.cc/40" class="rounded-circle">
        </div>
    </div>

    @yield('content')

</div>

</body>
</html>
