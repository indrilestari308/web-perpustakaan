<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background: #f8f9fa;
            padding: 15px 40px;
        }

        .navbar a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
        }

        .btn-login {
            background: #2f6df6;
            color: white;
            border-radius: 8px;
            padding: 8px 20px;
        }

        /* HERO */
        .hero {
            height: 450px;
            background: url('{{ asset("img/login.jpeg") }}') center/cover;
            position: relative;
            color: white;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.5);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            top: 50%;
            transform: translateY(-50%);
        }

        .hero h1 {
            font-weight: bold;
        }

        .btn-hero {
            background: #2f6df6;
            color: white;
            border-radius: 10px;
            padding: 10px 25px;
        }

        /* SECTION */
        .section {
            padding: 50px 60px;
        }

        .section h3 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* CARD BUKU */
        .card-buku {
            border-radius: 15px;
            padding: 15px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card-buku img {
            width: 100%;
            border-radius: 10px;
        }

        /* BOX BAWAH */
        .box {
            height: 120px;
            background: #eee;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar d-flex justify-content-between align-items-center">
    <div>
        <a href="#">Beranda</a>
        <a href="#">Buku</a>
        <a href="#">Layanan</a>
        <a href="#">Tentang</a>
    </div>

    <a href="/login" class="btn-login">Masuk</a>
</div>

<!-- HERO -->
<div class="hero">
    <div class="hero-content">
        <h1>L i b T r a c k</h1>
        <h4>SMK Negeri 3 Banjar</h4>
        <p>Jelajahi Dunia Dengan Meminjam Buku Di Perpustakaan</p>

        <a href="#" class="btn btn-hero">Coba Pinjam</a>
    </div>
</div>

<!-- TENTANG -->
<div class="section">
    <h3>Tentang Perpustakaan</h3>
    <p>
        Perpustakaan Sekolah adalah pusat pengetahuan yang memicu eksplorasi dan kreativitas siswa.
    </p>

    <img src="{{ asset('img/perpus.jpg') }}" class="img-fluid rounded">
</div>

<!-- BUKU -->
<div class="section">
    <div class="row">

        @for($i = 0; $i < 3; $i++)
        <div class="col-md-4 mb-4">
            <div class="card-buku">
                <img src="{{ asset('img/buku.jpg') }}">
                <h5 class="mt-3">Perahu Kertas</h5>
            </div>
        </div>
        @endfor

    </div>
</div>

<!-- BOX GRID -->
<div class="section">
    <div class="row g-3">

        @for($i = 0; $i < 8; $i++)
        <div class="col-md-3">
            <div class="box"></div>
        </div>
        @endfor

    </div>
</div>

</body>
</html>
