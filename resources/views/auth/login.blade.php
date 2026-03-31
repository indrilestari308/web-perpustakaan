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

/* KIRI */
.left-side {
    width: 320px;
    position: relative;
    overflow: hidden;
}

/* LOGO */
.logo-title {
    position: absolute;
    top: 25px;
    left: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 2;
}

.logo-title img {
    height: 35px;
}

.logo-title span {
    font-weight: bold;
    color: #1b2a7a;
    font-size: 20px;
}

.left-side img.bg {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* KANAN */
.right-side {
    flex: 1;
    background: linear-gradient(135deg, #eaeaea, #6fd1c7);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD */
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

.form-control:focus {
    border-color: #6fd1c7;
    box-shadow: none;
}

/* BUTTON */
.btn-login {
    background: #f5b623;
    border: none;
    border-radius: 15px;
    height: 50px;
    font-weight: bold;
    font-size: 18px;
    color: white;
    transition: 0.3s;
}

.btn-login:hover {
    background: #e0a315;
}

/* LINK */
.register-text {
    text-align: center;
    margin-top: 15px;
}

.register-text a {
    color: #142c8e;
    text-decoration: none;
    font-weight: 500;
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
                Silahkan Login
            </div>

            <div class="login-card">

                <form>

                    <div class="mb-3">
                        <label>Email / Username</label>
                        <input type="text" class="form-control" placeholder="Masukkan email atau username">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Masukkan password">
                    </div>

                    <button type="button" class="btn btn-login w-100">
                        Login
                    </button>

                </form>

                <div class="register-text">
                    Belum punya akun? <a href="/register">Daftar</a>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
