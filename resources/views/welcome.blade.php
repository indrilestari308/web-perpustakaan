<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LibTrack - Perpustakaan SMKN 3 Banjar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Segoe UI', sans-serif; color: #1a1a2e; }

        /* NAVBAR */
        .nav-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 48px;
            background: #fff;
            border-bottom: 1px solid #e8ecf0;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .nav-brand { font-size: 18px; font-weight: 800; color: #1a1a2e; letter-spacing: 1px; text-decoration: none; }
        .nav-links { display: flex; gap: 28px; }
        .nav-links a { font-size: 14px; color: #555; text-decoration: none; transition: color 0.2s; }
        .nav-links a:hover { color: #2f6df6; }
        .btn-masuk {
            background: #2f6df6; color: #fff; border: none;
            border-radius: 8px; padding: 8px 20px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: background 0.2s;
        }
        .btn-masuk:hover { background: #1a5ce6; color: #fff; }

        /* HERO */
        .hero {
            background: #0f1b3d;
            padding: 80px 48px;
            display: flex;
            align-items: center;
            gap: 60px;
        }
        .hero-left { flex: 1; }
        .hero-tag {
            display: inline-block;
            background: #1e3a7b; color: #7eb3ff;
            font-size: 11px; font-weight: 700;
            letter-spacing: 0.08em; padding: 4px 12px;
            border-radius: 20px; margin-bottom: 18px;
            text-transform: uppercase;
        }
        .hero-left h1 { font-size: 42px; font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 14px; }
        .hero-left h1 span { color: #4e8ff8; }
        .hero-left p { font-size: 15px; color: #9db4d8; line-height: 1.7; margin-bottom: 28px; max-width: 440px; }
        .hero-btns { display: flex; gap: 12px; }
        .btn-primary-hero {
            background: #2f6df6; color: #fff; border: none;
            border-radius: 10px; padding: 11px 24px;
            font-size: 14px; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: background 0.2s;
            display: inline-block;
        }
        .btn-primary-hero:hover { background: #1a5ce6; color: #fff; }
        .btn-ghost {
            background: transparent; color: #9db4d8;
            border: 1px solid #2a3f6e; border-radius: 10px;
            padding: 11px 24px; font-size: 14px; cursor: pointer;
            text-decoration: none; transition: all 0.2s;
            display: inline-block;
        }
        .btn-ghost:hover { background: #1e3a7b; color: #fff; }
        .hero-right { flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .stat-box {
            background: #162040;
            border: 1px solid #2a3f6e;
            border-radius: 14px; padding: 20px; text-align: center;
        }
        .stat-box.accent { background: #1e3a7b; }
        .stat-num { font-size: 28px; font-weight: 800; color: #4e8ff8; margin-bottom: 4px; }
        .stat-lbl { font-size: 12px; color: #7a94be; }

        /* SECTION */
        .section { padding: 56px 48px; }
        .section-bg { background: #f8f9fc; }
        .section-tag {
            font-size: 11px; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: #2f6df6; margin-bottom: 8px;
        }
        .section-title { font-size: 26px; font-weight: 800; color: #1a1a2e; margin-bottom: 8px; }
        .section-sub { font-size: 14px; color: #6c757d; margin-bottom: 32px; max-width: 500px; line-height: 1.6; }

        /* FITUR */
        .fitur-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .fitur-card {
            background: #f8f9ff;
            border: 1px solid #e0e7ff;
            border-radius: 14px; padding: 22px;
        }
        .buku-cover {
            height: 140px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fitur-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: #dbeafe;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px;
        }
        .fitur-icon svg { width: 20px; height: 20px; stroke: #2f6df6; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .fitur-card h4 { font-size: 14px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .fitur-card p { font-size: 12px; color: #6c757d; line-height: 1.6; margin: 0; }

        /* BUKU */
        .buku-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .buku-card { background: #fff; border: 1px solid #e8ecf0; border-radius: 14px; overflow: hidden; }
        .buku-cover { height: 140px; display: flex; align-items: center; justify-content: center; }
        .buku-cover svg { width: 36px; height: 36px; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
        .buku-info { padding: 14px; }
        .buku-kat { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #2f6df6; margin-bottom: 4px; }
        .buku-judul { font-size: 13px; font-weight: 700; color: #1a1a2e; margin-bottom: 3px; }
        .buku-pengarang { font-size: 11px; color: #6c757d; }
        .badge-tersedia { display: inline-block; margin-top: 8px; font-size: 10px; padding: 2px 8px; border-radius: 20px; background: #d1fae5; color: #065f46; font-weight: 600; }
        .badge-dipinjam { display: inline-block; margin-top: 8px; font-size: 10px; padding: 2px 8px; border-radius: 20px; background: #fee2e2; color: #991b1b; font-weight: 600; }

        /* CARA */
        .cara-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .cara-card { background: #fff; border: 1px solid #e8ecf0; border-radius: 14px; padding: 20px; text-align: center; }
        .cara-num {
            width: 36px; height: 36px; border-radius: 50%;
            background: #2f6df6; color: #fff;
            font-size: 14px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px;
        }
        .cara-card h4 { font-size: 13px; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .cara-card p { font-size: 12px; color: #6c757d; line-height: 1.5; margin: 0; }

        /* TENTANG */
        .tentang-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 8px; }
        .tentang-card { background: #f8f9fc; border: 1px solid #e8ecf0; border-radius: 14px; padding: 20px; }
        .tentang-num { font-size: 22px; font-weight: 800; color: #2f6df6; margin-bottom: 4px; }
        .tentang-lbl { font-size: 13px; color: #6c757d; }

        /* CTA */
        .cta-section { background: #0f1b3d; padding: 56px 48px; text-align: center; }
        .cta-section h2 { font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 10px; }
        .cta-section p { font-size: 14px; color: #9db4d8; margin-bottom: 24px; }

        /* FOOTER */
        .footer {
            background: #f8f9fc;
            padding: 24px 48px;
            display: flex; justify-content: space-between; align-items: center;
            border-top: 1px solid #e8ecf0;
        }
        .footer-brand { font-weight: 800; color: #1a1a2e; font-size: 14px; }
        .footer-copy { font-size: 12px; color: #adb5bd; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-custom { padding: 16px 24px; }
            .nav-links { display: none; }
            .hero { flex-direction: column; padding: 40px 24px; gap: 32px; }
            .hero-left h1 { font-size: 28px; }
            .hero-right { grid-template-columns: 1fr 1fr; }
            .section { padding: 40px 24px; }
            .fitur-grid { grid-template-columns: 1fr; }
            .buku-grid { grid-template-columns: repeat(2, 1fr); }
            .cara-grid { grid-template-columns: repeat(2, 1fr); }
            .tentang-grid { grid-template-columns: 1fr; }
            .footer { flex-direction: column; gap: 8px; text-align: center; }
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<div class="nav-custom">
    <a href="/" class="nav-brand">LibTrack</a>
    <div class="nav-links">
        <a href="#">Beranda</a>
        <a href="#koleksi">Koleksi Buku</a>
        <a href="#cara-pinjam">Cara Pinjam</a>
        <a href="#tentang">Tentang</a>
    </div>
    <a href="/login" class="btn-masuk">Masuk</a>
</div>

{{-- HERO --}}
<div class="hero">
    <div class="hero-left">
        <div class="hero-tag">SMK Negeri 3 Banjar</div>
        <h1>Perpustakaan<br>Digital <span>LibTrack</span></h1>
        <p>Temukan ribuan buku, pinjam kapan saja, dan pantau status pengembalian langsung dari genggamanmu.</p>
        <div class="hero-btns">
            <a href="/register" class="btn-primary-hero">Mulai Pinjam</a>
            <a href="#koleksi" class="btn-ghost">Lihat Koleksi</a>
        </div>
    </div>
    <div class="hero-right">
        <div class="stat-box accent">
            <div class="stat-num">1.240</div>
            <div class="stat-lbl">Total Koleksi Buku</div>
        </div>
        <div class="stat-box">
            <div class="stat-num">340</div>
            <div class="stat-lbl">Anggota Aktif</div>
        </div>
        <div class="stat-box">
            <div class="stat-num">87</div>
            <div class="stat-lbl">Dipinjam Bulan Ini</div>
        </div>
        <div class="stat-box accent">
            <div class="stat-num">12</div>
            <div class="stat-lbl">Kategori Buku</div>
        </div>
    </div>
</div>

{{-- FITUR --}}
<div class="section section-bg">
    <div class="section-tag">Fitur Unggulan</div>
    <div class="section-title">Semua yang kamu butuhkan</div>
    <div class="section-sub">Dirancang khusus untuk siswa dan petugas perpustakaan SMKN 3 Banjar.</div>
    <div class="fitur-grid">
        <div class="fitur-card">
            <div class="fitur-icon">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
            </div>
            <h4>Koleksi Lengkap</h4>
            <p>Ribuan buku tersedia dari berbagai kategori pelajaran dan bacaan umum.</p>
        </div>
        <div class="fitur-card">
            <div class="fitur-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <h4>Pantau Tenggat</h4>
            <p>Notifikasi otomatis sebelum batas pengembalian buku agar tidak terkena denda.</p>
        </div>
        <div class="fitur-card">
            <div class="fitur-icon">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h4>Riwayat Peminjaman</h4>
            <p>Lacak semua histori pinjam dan pengembalian buku dengan mudah.</p>
        </div>
    </div>
</div>

{{-- KOLEKSI BUKU --}}
<div class="section" id="koleksi">
    <div class="section-tag">Koleksi Terbaru</div>
    <div class="section-title">Buku pilihan minggu ini</div>
    <div class="section-sub">Temukan buku-buku baru yang baru saja ditambahkan ke perpustakaan.</div>
    <div class="buku-grid">

        @php
            $covers = [
                ['bg' => '#dbeafe', 'stroke' => '#2563eb'],
                ['bg' => '#fce7f3', 'stroke' => '#db2777'],
                ['bg' => '#d1fae5', 'stroke' => '#059669'],
                ['bg' => '#fef3c7', 'stroke' => '#d97706'],
            ];
        @endphp

@forelse($bukuTerbaru as $buku)
@php $c = $covers[$loop->index % 4]; @endphp
<div class="buku-card">
    <div class="buku-cover" style="background: {{ $c['bg'] }};">
        @if($buku->gambar)
            <img src="{{ asset('storage/' . $buku->gambar) }}"
                 style="width:100%; height:100%; object-fit:cover;">
        @else
            <svg viewBox="0 0 24 24" style="stroke: {{ $c['stroke'] }};">
                <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
            </svg>
        @endif
    </div>
    <div class="buku-info">
        <div class="buku-kat">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</div> {{-- ✅ fix --}}
        <div class="buku-judul">{{ $buku->judul }}</div>
        <div class="buku-pengarang">{{ $buku->penulis }}</div> {{-- ✅ fix --}}
        @if($buku->stok > 0)
            <span class="badge-tersedia">Tersedia</span>
        @else
            <span class="badge-dipinjam">Habis</span>
        @endif
    </div>
</div>
@empty
        @foreach([
            ['Fiksi', 'Perahu Kertas', 'Dewi Lestari', '#dbeafe', '#2563eb', true],
            ['Sains', 'Fisika Dasar', 'Halliday & Resnick', '#fce7f3', '#db2777', true],
            ['Sejarah', 'Bumi Manusia', 'Pramoedya A.T.', '#d1fae5', '#059669', false],
            ['Motivasi', 'Atomic Habits', 'James Clear', '#fef3c7', '#d97706', true],
        ] as $b)
        <div class="buku-card">
            <div class="buku-cover" style="background: {{ $b[3] }};">
                <svg viewBox="0 0 24 24" style="stroke: {{ $b[4] }};">
                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                </svg>
            </div>
            <div class="buku-info">
                <div class="buku-kat">{{ $b[0] }}</div>
                <div class="buku-judul">{{ $b[1] }}</div>
                <div class="buku-pengarang">{{ $b[2] }}</div>
                @if($b[5])
                    <span class="badge-tersedia">Tersedia</span>
                @else
                    <span class="badge-dipinjam">Dipinjam</span>
                @endif
            </div>
        </div>
        @endforeach
        @endforelse

    </div>
</div>

{{-- CARA PINJAM --}}
<div class="section section-bg" id="cara-pinjam">
    <div class="section-tag">Cara Kerja</div>
    <div class="section-title">Pinjam buku dalam 4 langkah</div>
    <div class="section-sub">Mudah, cepat, dan bisa dilakukan kapan saja.</div>
    <div class="cara-grid">
        <div class="cara-card">
            <div class="cara-num">1</div>
            <h4>Daftar Akun</h4>
            <p>Buat akun dengan Nama email dan Password kamu.</p>
        </div>
        <div class="cara-card">
            <div class="cara-num">2</div>
            <h4>Cari Buku</h4>
            <p>Telusuri koleksi berdasarkan judul, pengarang, atau kategori.</p>
        </div>
        <div class="cara-card">
            <div class="cara-num">3</div>
            <h4>Ajukan Pinjam</h4>
            <p>Klik tombol pinjam dan tunggu konfirmasi dari petugas.</p>
        </div>
        <div class="cara-card">
            <div class="cara-num">4</div>
            <h4>Kembalikan</h4>
            <p>Kembalikan tepat waktu agar tidak terkena denda keterlambatan.</p>
        </div>
    </div>
</div>

{{-- TENTANG --}}
<div class="section" id="tentang">
    <div class="section-tag">Tentang Kami</div>
    <div class="section-title">Perpustakaan SMKN 3 Banjar</div>
    <div class="section-sub" style="max-width: 100%;">
        Perpustakaan SMKN 3 Banjar adalah pusat sumber belajar yang menyediakan koleksi buku
        pelajaran, referensi, dan bacaan umum untuk seluruh siswa dan guru. LibTrack hadir
        untuk mempermudah proses peminjaman secara digital, cepat, dan transparan.
    </div>
    <div class="tentang-grid">
        <div class="tentang-card">
            <div class="tentang-num">2008</div>
            <div class="tentang-lbl">Tahun berdiri perpustakaan</div>
        </div>
        <div class="tentang-card">
            <div class="tentang-num">+</div>
            <div class="tentang-lbl">Koleksi buku tersedia</div>
        </div>
        <div class="tentang-card">
            <div class="tentang-num">Senin – Jumat</div>
            <div class="tentang-lbl">Jam operasional 07.00 – 15.00</div>
        </div>
    </div>
</div>

{{-- CTA --}}
<div class="cta-section">
    <h2>Siap menjelajahi koleksi buku?</h2>
    <p>Bergabung bersama 340+ anggota aktif perpustakaan SMKN 3 Banjar.</p>
    <a href="/register" class="btn-primary-hero" style="font-size: 15px; padding: 12px 32px;">
        Daftar Sekarang
    </a>
</div>

{{-- FOOTER --}}
<div class="footer">
    <span class="footer-brand">LibTrack</span>
    <span class="footer-copy">© {{ date('Y') }} Perpustakaan SMKN 3 Banjar. All rights reserved.</span>
</div>

</body>
</html>
