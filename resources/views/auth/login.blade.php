<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LibTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; height: 100vh; overflow: hidden; display: flex; }

        .auth-left {
            width: 360px;
            flex-shrink: 0;
            background: #0f1b3d;
            padding: 40px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .auth-brand { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: 1px; }
        .auth-brand-sub { font-size: 12px; color: #7a94be; margin-top: 2px; }
        .auth-left-body { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 40px 0; }
        .auth-left-body h2 { font-size: 30px; font-weight: 800; color: #fff; line-height: 1.3; margin-bottom: 12px; }
        .auth-left-body p { font-size: 14px; color: #9db4d8; line-height: 1.7; }
        .auth-ilustrasi { margin-top: 32px; background: #162040; border: 1px solid #2a3f6e; border-radius: 14px; padding: 20px; }
        .auth-ilustrasi-item { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .auth-ilustrasi-item:last-child { margin-bottom: 0; }
        .auth-ilustrasi-dot { width: 8px; height: 8px; border-radius: 50%; background: #4e8ff8; flex-shrink: 0; }
        .auth-ilustrasi-text { font-size: 13px; color: #9db4d8; }
        .auth-copy { font-size: 11px; color: #2a3f6e; }

        .auth-right {
            flex: 1;
            background: #f8f9fc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .auth-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border: 1px solid #e8ecf0;
            border-radius: 20px;
            padding: 36px 32px;
        }
        .auth-tag {
            font-size: 11px; font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: #2f6df6; margin-bottom: 6px;
        }
        .auth-card h3 { font-size: 24px; font-weight: 800; color: #1a1a2e; margin-bottom: 4px; }
        .auth-card > p { font-size: 13px; color: #6c757d; margin-bottom: 24px; }
        .auth-field { margin-bottom: 16px; }
        .auth-field label {
            display: block; font-size: 11px; font-weight: 700;
            letter-spacing: 0.05em; text-transform: uppercase;
            color: #6c757d; margin-bottom: 6px;
        }
        .auth-input {
            width: 100%; background: #f8f9fc;
            border: 1px solid #e8ecf0; border-radius: 10px;
            padding: 11px 14px; font-size: 14px; color: #1a1a2e;
            outline: none; transition: border-color 0.15s, box-shadow 0.15s;
            font-family: 'Segoe UI', sans-serif;
        }
        .auth-input:focus { border-color: #2f6df6; box-shadow: 0 0 0 3px rgba(47,109,246,0.1); background: #fff; }
        .auth-input.is-invalid { border-color: #dc3545; }
        .invalid-msg { font-size: 12px; color: #dc3545; margin-top: 4px; }
        .auth-forgot { text-align: right; margin-top: -10px; margin-bottom: 16px; }
        .auth-forgot a { font-size: 12px; color: #2f6df6; text-decoration: none; }
        .auth-btn {
            width: 100%; background: #2f6df6; color: #fff;
            border: none; border-radius: 10px;
            padding: 13px; font-size: 15px; font-weight: 700;
            cursor: pointer; transition: background 0.2s;
        }
        .auth-btn:hover { background: #1a5ce6; }
        .auth-footer { text-align: center; font-size: 13px; color: #6c757d; margin-top: 18px; }
        .auth-footer a { color: #2f6df6; font-weight: 600; text-decoration: none; }
        .auth-alert {
            background: #fee2e2; border: 1px solid #fca5a5;
            border-radius: 10px; padding: 10px 14px;
            font-size: 13px; color: #991b1b; margin-bottom: 16px;
        }

        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { padding: 24px; }
        }
    </style>
</head>
<body>

{{-- KIRI --}}
<div class="auth-left">
    <div>
        <div class="auth-brand">LibTrack</div>
        <div class="auth-brand-sub">SMKN 3 Banjar</div>
    </div>
    <div class="auth-left-body">
        <h2>Selamat datang kembali</h2>
        <p>Lanjutkan perjalanan membacamu bersama perpustakaan digital SMKN 3 Banjar.</p>
        <div class="auth-ilustrasi">
            <div class="auth-ilustrasi-item">
                <div class="auth-ilustrasi-dot"></div>
                <div class="auth-ilustrasi-text">Akses 1.240+ koleksi buku</div>
            </div>
            <div class="auth-ilustrasi-item">
                <div class="auth-ilustrasi-dot"></div>
                <div class="auth-ilustrasi-text">Pantau tenggat pengembalian</div>
            </div>
            <div class="auth-ilustrasi-item">
                <div class="auth-ilustrasi-dot"></div>
                <div class="auth-ilustrasi-text">Riwayat peminjaman lengkap</div>
            </div>
        </div>
    </div>
    <div class="auth-copy">© {{ date('Y') }} LibTrack</div>
</div>

{{-- KANAN --}}
<div class="auth-right">
    <div class="auth-card">
        <div class="auth-tag">Masuk ke akun</div>
        <h3>Login</h3>
        <p>Masukkan email dan password kamu</p>

        @if(session('error'))
            <div class="auth-alert">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="auth-alert">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="auth-field">
                <label>Email</label>
                <input type="email" name="email"
                       class="auth-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       value="{{ old('email') }}"
                       placeholder="Masukkan email" required autofocus>
                @error('email') <div class="invalid-msg">{{ $message }}</div> @enderror
            </div>

            <div class="auth-field">
                <label>Password</label>
                <input type="password" name="password"
                       class="auth-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       placeholder="Masukkan password" required>
                @error('password') <div class="invalid-msg">{{ $message }}</div> @enderror
            </div>

            <div class="auth-forgot">
                <a href="#">Lupa password?</a>
            </div>

            <button type="submit" class="auth-btn">Masuk</button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="/register">Daftar sekarang</a>
        </div>
    </div>
</div>

</body>
</html>