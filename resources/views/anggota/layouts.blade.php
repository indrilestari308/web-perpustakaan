<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f9;
        }

        .app { display: flex; min-height: 100vh; background: var(--color-background-tertiary); border-radius: var(--border-radius-lg); overflow: hidden; border: 0.5px solid var(--color-border-tertiary); }
        .sidebar { width: 220px; min-height: 100vh; background: #2B3990; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-top { padding: 0 20px; height: 60px; display: flex; align-items: center; border-bottom: 0.5px solid rgba(255,255,255,0.1); }
        .logo { color: white; font-size: 16px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
        .logo-icon { width: 28px; height: 28px; background: rgba(255,255,255,0.15); border-radius: 6px; display: flex; align-items: center; justify-content: center; }
        .sidebar-menu { padding: 16px 12px; flex: 1; }
        .menu-label { font-size: 10px; color: rgba(255,255,255,0.45); letter-spacing: 0.08em; text-transform: uppercase; padding: 0 8px; margin-bottom: 8px; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 8px; cursor: pointer; color: rgba(255,255,255,0.65); font-size: 13.5px; margin-bottom: 2px; text-decoration: none;}
        .menu-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .menu-item.active { background: rgba(255,255,255,0.15); color: white; }
        .menu-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .sidebar-bottom { padding: 12px; border-top: 0.5px solid rgba(255,255,255,0.1); }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 9px 10px; border-radius: 8px; cursor: pointer; color: rgba(255,255,255,0.5); font-size: 13.5px; }
        .logout-btn svg { width: 16px; height: 16px; }
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }


        .content {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
            min-height: 0;
        }

        /* ───── TOPBAR ───── */
        .topbar {
            background: #ffffff;
            border: 1px solid #e5e7ef;
            border-radius: 10px;
            padding: 0 20px;
            height: 56px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }
                .dropdown-avatar-initial {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #4f46e5; /* bisa kamu ganti */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-breadcrumb {
            font-size: 12px;
            color: #9ca3af;
        }

        .topbar-sep {
            font-size: 12px;
            color: #d1d5db;
        }

        .topbar-page {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-page i {
            font-size: 14px;
            color: #4361EE;
        }

        /* Notif button */
        .topbar-notif-btn {
            position: relative;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f3f4f6;
            border: 1px solid #e5e7ef;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #6b7280;
            transition: background 0.2s;
            text-decoration: none;
        }

        .topbar-notif-btn:hover {
            background: #e9eaf0;
            color: #374151;
        }

        .topbar-notif-btn i {
            font-size: 16px;
        }

        .notif-badge {
            position: absolute;
            top: 7px;
            right: 8px;
            width: 6px;
            height: 6px;
            background: #EF4444;
            border-radius: 50%;
            border: 1.5px solid #ffffff;
        }

        .topbar-divider {
            width: 1px;
            height: 22px;
            background: #e5e7ef;
            margin: 0 4px;
        }

        /* User chip */
        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px 5px 6px;
            border-radius: 40px;
            border: 1px solid #e5e7ef;
            background: #f9fafb;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }

        .user-chip:hover {
            background: #f0f1f6;
        }

        .user-avatar-chip {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #e5e7ef;
        }

        .user-name-chip {
            font-size: 13px;
            font-weight: 500;
            color: #111827;
        }

        .user-chip i {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Dropdown */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 220px;
            background: #ffffff;
            border: 1px solid #e5e7ef;
            border-radius: 12px;
            overflow: hidden;
            z-index: 200;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            display: none;
        }

        .user-dropdown.show {
            display: block;
        }

        .dropdown-header {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #e5e7ef;
            flex-shrink: 0;
        }

        .dropdown-name {
            font-size: 13px;
            font-weight: 600;
            color: #111827;
        }

        .dropdown-role {
            font-size: 11.5px;
            color: #9ca3af;
            margin-top: 1px;
        }

        .dropdown-body {
            padding: 6px;
        }

        .dropdown-item-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
            transition: background 0.15s;
        }

        .dropdown-item-link:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .dropdown-item-link i {
            font-size: 14px;
            width: 16px;
            text-align: center;
        }

        .dropdown-divider {
            height: 1px;
            background: #f3f4f6;
            margin: 4px 8px;
        }

        .dropdown-item-link.danger {
            color: #EF4444;
        }

        .dropdown-item-link.danger:hover {
            background: #FEF2F2;
            color: #DC2626;
        }


    </style>
</head>
<body>

<div class="app">
  <div class="sidebar">
    <div class="sidebar-top">
      <div class="logo">
        <div class="logo-icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        LibTrack
      </div>
    </div>
    <div class="sidebar-menu">
      <div class="menu-label">Menu</div>

      <a href="{{ route('anggota.dashboard') }}" class="menu-item {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>

      <a href="{{ route('anggota.buku') }}" class="menu-item {{ request()->routeIs('anggota.buku*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
        Katalog
      </a>

      <a href="{{ route('anggota.peminjaman') }}" class="menu-item {{ request()->routeIs('anggota.peminjaman*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
        Peminjaman
        <span class="badge-dot"></span>
      </a>

      <a href="{{ route('anggota.riwayat') }}" class="menu-item {{ request()->routeIs('anggota.riwayat') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Riwayat
      </a>

      <a href="{{ route('anggota.profil') }}" class="menu-item {{ request()->routeIs('anggota.profil*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profil
      </a>

    </div>
    <div class="sidebar-bottom">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn" style="background:none; border:none; width:100%; cursor:pointer;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Logout
        </button>
      </form>
    </div>
  </div>

<!-- CONTENT -->
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <span class="topbar-breadcrumb">Perpustakaan</span>
            <span class="topbar-sep">/</span>
            <span class="topbar-page">
                <i class="bi bi-grid-fill"></i>
                @yield('title')
            </span>
        </div>

        <div class="topbar-right">
            <!-- Notifikasi -->
         
            <div class="topbar-divider"></div>

            <!-- User chip -->
            <div class="user-chip" id="userChipBtn">

                @if(auth()->user()->foto)
                    <img src="{{ asset('storage/'.auth()->user()->foto) }}"
                        class="user-avatar-chip"
                        alt="{{ auth()->user()->name ?? 'User' }}">
                @else
                    <div class="user-avatar-initial">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                @endif

                <span class="user-name-chip">{{ auth()->user()->name ?? 'User' }}</span>
                <i class="bi bi-chevron-down"></i>
            </div>

            <!-- Dropdown -->
            <div class="user-dropdown" id="userDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-avatar-initial">
                        {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                    </div>
                <div>
                        <div class="dropdown-name">{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="dropdown-role">Anggota Perpustakaan</div>
                    </div>
                </div>
                <div class="dropdown-body">
                    <a href="{{route('anggota.profil')}}" class="dropdown-item-link">
                        <i class="bi bi-person-circle"></i> Lihat Profil
                    </a>

{{-- <a href="{{ route('anggota.profil') }}" class="menu-item {{ request()->routeIs('anggota.profil*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profil
      </a> --}}


                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <a href="#" class="dropdown-item-link danger"
                           onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const chipBtn = document.getElementById('userChipBtn');
    const dropdown = document.getElementById('userDropdown');

    chipBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    document.addEventListener('click', function () {
        dropdown.classList.remove('show');
    });

    dropdown.addEventListener('click', function (e) {
        e.stopPropagation();
    });
</script>
</body>
</html>
