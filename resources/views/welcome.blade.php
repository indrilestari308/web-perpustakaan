<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eee;
        }

        .main-box {
            max-width: 1200px;
            margin: 40px auto;
            border-radius: 20px;
            overflow: hidden;
            background: white;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.11);
            backdrop-filter: blur(8px);
        }

        .hero {
            position: relative;
            height: 500px;
            background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') center/cover no-repeat;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }

        .hero-content {
            position: absolute;
            top: 40%;
            left: 10%;
            color: white;
        }

        .hero-content h2 {
            background: rgba(255,255,255,0.7);
            color: #1d4ed8;
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-block;
        }

        .footer {
            background: #1d4ed8;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom px-4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('img/logoperpus.png') }}" alt="logo" style="height:40px;"> Perpustakaan
            </a>
            <div class="ms-auto">
                <a href="/" class="me-3 text-dark text-decoration-none">HOME</a>
                <a href="/login" class="me-3 text-dark text-decoration-none">LOGIN</a>
                <a href="/register" class="text-dark text-decoration-none">SIGN IN</a>
            </div>

    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h4>Perpustakaan SMK Negeri 3 Banjar</h4>
            <h2>Selamat Datang di Perpustakaan SMK Negeri 3 Banjar</h2>

            <br>
            <a href="/register" class="btn btn-primary mt-3">Daftar Sekarang</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        COPYRIGHT @ 2008 LIBRARY.THREEBAN.EDU. ALL RIGHTS RESERVED
    </div>

</div>

</body>
</html>
