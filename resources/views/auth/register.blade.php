<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LibTrack</title>
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
        .auth-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 32px; }
        .auth-stat { background: #162040; border: 1px solid #2a3f6e; border-radius: 12px; padding: 14px; }
        .auth-stat-num { font-size: 20px; font-weight: 800; color: #4e8ff8; }
        .auth-stat-lbl { font-size: 11px; color: #7a94be; margin-top: 2px; }
        .auth-copy { font-size: 11px; color: #2a3f6e; }

        .auth-right {
            flex: 1;
            background: #f8f9fc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow-y: auto;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
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
        .auth-btn {
            width: 100%; background: #2f6df6; color: #fff;
            border: none; border-radius: 10px;
            padding: 13px; font-size: 15px; font-weight: 700;
            cursor: pointer; transition: background 0.2s;
            margin-top: 4px;
        }
        .auth-btn:hover { background: #1a5ce6; }
        .auth-footer { text-align: center; font-size: 13px; color: #6c757d; margin-top: 18px; }
        .auth-footer a { color: #2f6df6; font-weight: 600; text-decoration: none; }
        .auth-alert {
            background: #fee2e2; border: 1px solid #fca5a5;
            border-radius: 10px; padding: 10px 14px;
            font-size: 13px; color: #991b1b; margin-bottom: 16px;
        }
        .auth-alert ul { margin: 0; padding-left: 16px; }

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
        <h2>Bergabung &amp; mulai membaca</h2>
        <p>Akses ribuan koleksi buku perpustakaan digital SMKN 3 Banjar kapan saja dan di mana saja.</p>
        <div class="auth-stats">
            <div class="auth-stat">
                <div class="auth-stat-num">1.240</div>
                <div class="auth-stat-lbl">Koleksi Buku</div>
            </div>
            <div class="auth-stat">
                <div class="auth-stat-num">340+</div>
                <div class="auth-stat-lbl">Anggota Aktif</div>
            </div>
        </div>
    </div>
    <div class="auth-copy">© {{ date('Y') }} LibTrack</div>
</div>

{{-- KANAN --}}
<div class="auth-right">
    <div class="auth-card">
        <div class="auth-tag">Mulai sekarang</div>
        <h3>Buat akun baru</h3>
        <p>Isi data di bawah untuk mendaftar</p>

        @if($errors->any())
            <div class="auth-alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf

            <div class="auth-field">
                <label>Nama Lengkap</label>
                <input type="text" name="name"
                       class="auth-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama lengkap" required>
                @error('name') <div class="invalid-msg">{{ $message }}</div> @enderror
            </div>

            <div class="auth-field">
                <label>Email</label>
                <input type="email" name="email"
                       class="auth-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       value="{{ old('email') }}"
                       placeholder="Masukkan email" required>
                @error('email') <div class="invalid-msg">{{ $message }}</div> @enderror
            </div>

            <div class="auth-field">
                <label>Password</label>
                <input type="password" name="password"
                       class="auth-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                       placeholder="Min. 6 karakter" required>
                @error('password') <div class="invalid-msg">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="auth-btn">Daftar Sekarang</button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="/login">Masuk di sini</a>
        </div>
    </div>
</div>

</body>
</html>