<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
body {
    margin: 0;
    height: 100vh;
    overflow: hidden;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.container-fluid {
    height: 100vh;
    padding: 0;
    display: flex;
}

.left-side {
    width: 320px;
    overflow: hidden;
}

.left-side img.bg {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.right-side {
    flex: 1;
    background: linear-gradient(135deg, #eaeaea, #6fd1c7);
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-wrapper {
    width: 100%;
    max-width: 420px;
}

.title-login {
    text-align: center;
    font-weight: bold;
    color: #142c8e;
    margin-bottom: 20px;
    font-size: 28px;
}

.login-card {
    background: #f4f4f4;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.form-control {
    border-radius: 15px;
    height: 50px;
    border: 2px solid #ccc;
}

.btn-login {
    background: #142c8e;
    border: none;
    border-radius: 15px;
    height: 50px;
    font-weight: bold;
    font-size: 18px;
    color: white;
}

.link-text {
    text-align: center;
    margin-top: 15px;
}
    </style>
</head>

<body>

<div class="container-fluid">

    <!-- KIRI -->
    <div class="left-side">
        <img src="{{ asset('img/login.jpeg') }}" class="bg">
    </div>

    <!-- KANAN -->
    <div class="right-side">

        <div class="login-wrapper">

            <div class="title-login">
                Login
            </div>

            <div class="login-card">

                {{-- ERROR --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" class="btn btn-login w-100">
                        Login
                    </button>

                </form>

                <div class="link-text">
                    Belum punya akun? <a href="/register">Daftar</a>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
