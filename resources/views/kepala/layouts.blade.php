<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #4e73df, #224abe);
            color: white;
            position: fixed;
            padding: 20px;
        }

        .sidebar h5 {
            font-weight: bold;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e2e8f0;
            text-decoration: none;
            margin: 10px 0;
            padding: 10px 15px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar a i {
            font-size: 18px;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: white;
            color: #1e293b;
            font-weight: bold;
        }

        .logout-btn {
            margin-top: 20px;
            width: 100%;
            background: #ef444400;
            border: none;
            padding: 10px;
            border-radius: 8px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        .content {
            margin-left: 260px;
            padding: 30px;
        }

        .card-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .card-box:hover {
            transform: translateY(-5px);
        }

    </style>
</head>
<body>

<div class="sidebar">
    <h5>Kepala Perpus</h5>

    <a href="{{ route('kepala.dashboard') }}"
       class="{{ request()->routeIs('kepala.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="{{ route('kepala.laporan') }}"
       class="{{ request()->routeIs('kepala.laporan') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-text"></i>
        Laporan
    </a>

    <a href="{{ route('kepala.petugas') }}"
       class="{{ request()->routeIs('kepala.petugas') ? 'active' : '' }}">
        <i class="bi bi-person-plus"></i>
        Tambah Petugas
    </a>

    <a href="{{ route('kepala.buku') }}"
       class="{{ request()->routeIs('kepala.buku') ? 'active' : '' }}">
        <i class="bi bi-book"></i>
        Data Buku
    </a>

    <hr style="border-color: rgba(255,255,255,0.2);">

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>
