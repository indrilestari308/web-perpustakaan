<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f9;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: #2B3990;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-top {
            padding: 0 20px;
            height: 60px;
            display: flex;
            align-items: center;
            border-bottom: 0.5px solid rgba(255,255,255,0.1);
        }

        .logo {
            color: white;
            font-size: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .logo-icon {
            width: 28px;
            height: 28px;
            background: rgba(255,255,255,0.15);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-menu { padding: 16px 12px; flex: 1; }

        .menu-label {
            font-size: 10px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0 8px;
            margin-bottom: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            cursor: pointer;
            color: rgba(255,255,255,0.65);
            font-size: 13.5px;
            margin-bottom: 2px;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }

        .menu-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .menu-item.active { background: rgba(255,255,255,0.15); color: white; }
        .menu-item svg { width: 16px; height: 16px; flex-shrink: 0; }

        .sidebar-bottom {
            padding: 12px;
            border-top: 0.5px solid rgba(255,255,255,0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            color: rgba(255,255,255,0.5);
            font-size: 13.5px;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        .logout-btn svg { width: 16px; height: 16px; }

        /* ─── CONTENT ─── */
        .content {
            margin-left: 220px;
            padding: 24px;
            min-height: 100vh;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            background: #ffffff;
            border: 1px solid #e5e7ef;
            border-radius: 10px;
            padding: 0 20px;
            height: 56px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-breadcrumb { font-size: 12px; color: #9ca3af; }
        .topbar-sep { font-size: 12px; color: #d1d5db; }

        .topbar-page {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

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

        .topbar-notif-btn:hover { background: #e9eaf0; color: #374151; }
        .topbar-notif-btn i { font-size: 16px; }

        .topbar-divider { width: 1px; height: 22px; background: #e5e7ef; margin: 0 4px; }

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
        }

        .user-chip:hover { background: #f0f1f6; }

        .user-avatar-chip {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #e5e7ef;
        }

        .user-name-chip { font-size: 13px; font-weight: 500; color: #111827; }
        .user-chip i { font-size: 12px; color: #9ca3af; }

        /* Dropdown */
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
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            display: none;
        }

        .user-dropdown.show { display: block; }

        .dropdown-header {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
        }
.user-avatar-initial {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #6366f1; /* bebas ganti */
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
    text-transform: uppercase;
}


        .dropdown-name { font-size: 13px; font-weight: 600; color: #111827; }
        .dropdown-role { font-size: 11.5px; color: #9ca3af; margin-top: 1px; }
        .dropdown-body { padding: 6px; }

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

        .dropdown-item-link:hover { background: #f3f4f6; color: #111827; }
        .dropdown-item-link i { font-size: 14px; width: 16px; text-align: center; }
        .dropdown-divider { height: 1px; background: #f3f4f6; margin: 4px 8px; }
        .dropdown-item-link.danger { color: #EF4444; }
        .dropdown-item-link.danger:hover { background: #FEF2F2; color: #DC2626; }

        /* ─── CARD ─── */
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .card-header { background: white; border-bottom: 1px solid #f1f5f9; border-radius: 12px 12px 0 0 !important; padding: 14px 18px; }

        /* ─── TABLE ─── */
        .table { margin: 0; font-size: 13.5px; }
        .table thead th { background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; padding: 10px 16px; }
        .table td { padding: 12px 16px; vertical-align: middle; color: #1e293b; border-color: #f1f5f9; }

        /* ─── BADGE STATUS ─── */
        .badge-status { display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; font-weight: 500; padding: 3px 10px; border-radius: 20px; }
        .badge-status::before { content: ''; width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .badge-aktif { background: #d1fae5; color: #065f46; }
        .badge-aktif::before { background: #22c55e; }
        .badge-nonaktif { background: #fee2e2; color: #991b1b; }
        .badge-nonaktif::before { background: #ef4444; }

        /* ─── BUTTONS ─── */
        .btn { border-radius: 8px; }
        .btn-primary { background: #4e73df; border-color: #4e73df; }
        .btn-primary:hover { background: #224abe; border-color: #224abe; }
        .btn-sm { padding: 5px 11px; font-size: 12px; }

        /* ─── FORM ─── */
        .form-control, .form-select { border-color: #e2e8f0; border-radius: 8px; font-size: 13.5px; }
        .form-control:focus, .form-select:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78,115,223,0.15); }

        /* ─── ALERT ─── */
        .alert { border-radius: 10px; font-size: 13.5px; border: none; }

        /* ─── STAT CARD ─── */
        .stat-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .stat-val { font-size: 24px; font-weight: 700; color: #1e293b; line-height: 1; }
        .stat-label { font-size: 12px; color: #64748b; margin-top: 4px; }
    </style>

    @stack('styles')
</head>
<body>

<!-- ─── SIDEBAR ─── -->
<div class="sidebar">
    <div class="sidebar-top">
        <a href="{{ route('kepala.dashboard') }}" class="logo">
            <div class="logo-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
                </svg>
            </div>
            LibTrack
        </a>
    </div>

    <div class="sidebar-menu">
        <div class="menu-label">Menu</div>

        <a href="{{ route('kepala.dashboard') }}"
           class="menu-item {{ request()->routeIs('kepala.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('kepala.laporan') }}"
           class="menu-item {{ request()->routeIs('kepala.laporan*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="18" y1="13" x2="6" y2="13"/>
                <line x1="18" y1="17" x2="6" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            Laporan
        </a>

        <a href="{{ route('kepala.petugas.index') }}"
           class="menu-item {{ request()->routeIs('kepala.petugas*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                <path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
            Tambah Petugas
        </a>

        <a href="{{ route('kepala.buku') }}"
           class="menu-item {{ request()->routeIs('kepala.buku*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/>
            </svg>
            Data Buku
        </a>
    </div>

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</div>

<!-- ─── CONTENT ─── -->
<div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <span class="topbar-breadcrumb">Perpustakaan</span>
            <span class="topbar-sep">/</span>
            <span class="topbar-page">@yield('title')</span>
        </div>

        <div class="topbar-right">
          

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

            <div class="user-dropdown" id="userDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-avatar-initial">
                        {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
                    </div>
                <div>
                        <div class="dropdown-name">{{ auth()->user()->name ?? 'Kepala Perpus' }}</div>
                        <div class="dropdown-role">Kepala Perpustakaan</div>
                    </div>
                </div>
                <div class="dropdown-body">
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST" id="logoutFormKepala">
                        @csrf
                        <a href="#" class="dropdown-item-link danger"
                           onclick="event.preventDefault(); document.getElementById('logoutFormKepala').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const chipBtn = document.getElementById('userChipBtn');
    const dropdown = document.getElementById('userDropdown');

    chipBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    document.addEventListener('click', function() {
        dropdown.classList.remove('show');
    });

    dropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });
</script>
@stack('scripts')
</body>
</html>
