<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SICAKAP - Sistem Absensi & Kegiatan Satpam Caraka')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        /* Extra inline micro-adjustments */
        .badge-night {
            background: linear-gradient(135deg, rgba(99,102,241,0.2) 0%, rgba(168,85,247,0.2) 100%);
            border: 1px solid rgba(168,85,247,0.4);
            color: #d8b4fe;
        }
        .btn-filter {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid var(--border-subtle);
            color: var(--text-primary);
            padding: 0.65rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-filter:hover {
            border-color: var(--indigo-primary);
            background: rgba(49, 46, 129, 0.3);
        }
        .btn-tab-filter {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            padding: 0.45rem 0.95rem;
            border-radius: var(--radius-md);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-tab-filter:hover {
            color: #fff;
            border-color: var(--indigo-primary);
        }
        .btn-tab-filter.active {
            background: var(--indigo-primary);
            border-color: var(--indigo-primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar">
        <div class="container navbar-inner">
            <div style="display:flex; align-items:center; gap:0.65rem;">
                <!-- Mobile Hamburger Toggle Button -->
                <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" onclick="toggleMobileMenu()" aria-label="Menu Utama" title="Menu Navigasi">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>

                <a href="{{ route('dashboard') }}" class="brand-logo" title="SICAKAP - Sistem Absensi & Logbook Terpadu">
                    <div class="brand-icon-wrapper">
                        <img src="{{ asset('images/logo-emblem.png') }}" alt="SICAKAP">
                    </div>
                    <div class="brand-text">
                        <h1>SICAKAP SATPAM & CARAKA</h1>
                        <p class="brand-tagline">Sistem Absensi & Logbook Terpadu</p>
                    </div>
                </a>
            </div>

            <!-- Nav Links (Desktop) -->
            <ul class="nav-links">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m14 9 3 3-3 3"/>
                        </svg>
                        Menu Utama
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('attendances.history') ? 'active' : '' }}">
                    <a href="{{ route('attendances.history') }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/>
                        </svg>
                        Riwayat Absensi
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                    <a href="{{ route('leave.index') }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/>
                        </svg>
                        Izin / Sakit
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                    <a href="{{ route('activities.index') }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                        </svg>
                        Logbook Kegiatan
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('shifts.*') ? 'active' : '' }}">
                    <a href="{{ route('shifts.index') }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Jadwal Shift
                    </a>
                </li>

                @if($activeUser->isAdmin())
                    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" style="color:#fbbf24;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            Kelola User
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.schedules.index') }}" style="color:#fbbf24;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                            Atur Jadwal & Off
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.shifts.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.shifts.index') }}" style="color:#fbbf24;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Master Shift
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.backup.index') }}" style="color:#fbbf24;" title="Backup & Restore Data">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Backup & Restore
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.location.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.location.index') }}" style="color:#fbbf24;" title="Setting Pembatasan Lokasi Maps">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            Radius Lokasi
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Right Controls: Profile & Logout -->
            <div class="navbar-right-controls" style="display:flex; align-items:center; gap:0.5rem;">
                <!-- Profile Switcher Dropdown (Testing & Demo) -->
                <div class="user-menu-wrapper">
                    <button type="button" class="user-badge-trigger" id="userDropdownTrigger" title="Menu Profil Saya">
                        <img src="{{ $activeUser->avatar ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100' }}" alt="{{ $activeUser->name }}" class="user-avatar">
                        <div class="user-info-text">
                            <div class="user-name">{{ $activeUser->name }}</div>
                            <span class="user-role-badge role-{{ $activeUser->role }}">{{ strtoupper($activeUser->role) }}</span>
                        </div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted); margin-left:2px;">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <!-- User Info Card Header -->
                        <div style="padding:0.75rem 0.85rem; background:rgba(30,41,59,0.7); border-radius:var(--radius-md); border:1px solid var(--border-subtle); margin-bottom:0.65rem;">
                            <div style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase; font-weight:700;">Masuk Sebagai:</div>
                            <div style="font-size:0.925rem; font-weight:800; color:#fff; white-space:nowrap; text-overflow:ellipsis; overflow:hidden;">{{ $activeUser->name }}</div>
                            <div style="display:flex; align-items:center; gap:0.4rem; margin-top:3px;">
                                <span class="user-role-badge role-{{ $activeUser->role }}" style="font-size:0.65rem;">{{ strtoupper($activeUser->role) }}</span>
                                <span style="font-size:0.7rem; color:var(--text-muted); font-family:var(--font-mono);">{{ $activeUser->nip }}</span>
                            </div>
                        </div>

                        <!-- Edit Profil Saya (Untuk Seluruh Pengguna) -->
                        <a href="{{ route('profile.edit') }}" class="dropdown-user-item {{ request()->routeIs('profile.*') ? 'active' : '' }}" style="margin-bottom:0.5rem; background:rgba(99,102,241,0.12); border:1px solid rgba(99,102,241,0.25);">
                            <div style="width:30px; height:30px; border-radius:50%; background:rgba(99,102,241,0.2); display:flex; align-items:center; justify-content:center; color:#a5b4fc; flex-shrink:0;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="m19 8 2 2-4 4"/></svg>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:0.85rem; font-weight:700; color:#fff;">Edit Profil Saya</div>
                                <div style="font-size:0.7rem; color:#cbd5e1;">Kelola biodata & kata sandi</div>
                            </div>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted);"><path d="m9 18 6-6-6-6"/></svg>
                        </a>

                        {{-- Ganti Akun Demo / Uji Coba (DITAMPILKAN KEPADA ADMIN ATAU SESI SIMULASI ADMIN) --}}
                        @if($activeUser->isAdmin() || session()->has('original_admin_id'))
                            <div class="dropdown-header" style="border-top:1px solid var(--border-subtle); margin-top:0.5rem; padding-top:0.6rem;">
                                Ganti Akun Demo (Admin):
                            </div>
                            <div style="max-height:220px; overflow-y:auto;">
                                @foreach($allUsers as $u)
                                    <a href="{{ route('session.switchUser', $u->id) }}" class="dropdown-user-item {{ $activeUser->id === $u->id ? 'active' : '' }}">
                                        <img src="{{ $u->avatar ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80' }}" style="width:28px; height:28px; border-radius:50%; object-fit:cover;" alt="{{ $u->name }}">
                                        <div style="flex:1; overflow:hidden;">
                                            <div style="font-size:0.8rem; font-weight:700; color:#fff; white-space:nowrap; text-overflow:ellipsis; overflow:hidden;">{{ $u->name }}</div>
                                            <div style="font-size:0.68rem; color:var(--text-muted);">{{ $u->position }}</div>
                                        </div>
                                        <span class="user-role-badge role-{{ $u->role }}" style="font-size:0.58rem;">{{ substr($u->role, 0, 3) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Logout Option -->
                        <div style="border-top:1px solid var(--border-subtle); margin-top:0.5rem; padding-top:0.5rem;">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="width:100%; display:flex; align-items:center; gap:0.5rem; padding:0.5rem; background:rgba(244,63,94,0.1); border:1px solid rgba(244,63,94,0.25); border-radius:var(--radius-md); color:#f43f5e; font-size:0.8rem; font-weight:700; cursor:pointer;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                    Keluar Sistem (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Quick Logout Button -->
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-filter" style="padding:0.4rem 0.65rem; color:#f43f5e; border-color:rgba(244,63,94,0.3); background:rgba(244,63,94,0.1);" title="Keluar / Logout">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Mobile Drawer Overlay & Menu Drawer -->
    <div class="mobile-drawer-overlay" id="mobileDrawerOverlay" onclick="closeMobileMenu()"></div>
    <aside class="mobile-nav-drawer" id="mobileNavDrawer" aria-hidden="true">
        <div class="mobile-drawer-header">
            <div class="mobile-drawer-user">
                <img src="{{ $activeUser->avatar ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100' }}" alt="{{ $activeUser->name }}" class="drawer-user-avatar">
                <div style="flex:1; min-width:0;">
                    <div class="drawer-user-name">{{ $activeUser->name }}</div>
                    <div class="drawer-user-sub">
                        <span class="user-role-badge role-{{ $activeUser->role }}">{{ strtoupper($activeUser->role) }}</span>
                        <span style="font-size:0.7rem; color:var(--text-muted); font-family:var(--font-mono); margin-left:4px;">{{ $activeUser->nip }}</span>
                    </div>
                </div>
            </div>
            <button type="button" class="mobile-drawer-close" onclick="closeMobileMenu()" aria-label="Tutup Menu">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="mobile-drawer-body">
            <div class="drawer-section-title">Navigasi Utama</div>
            <ul class="drawer-nav-list">
                <li>
                    <a href="{{ route('dashboard') }}" class="drawer-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" onclick="closeMobileMenu()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18"/><path d="m14 9 3 3-3 3"/></svg>
                        <span>Menu Utama (Absen)</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('attendances.history') }}" class="drawer-nav-link {{ request()->routeIs('attendances.history') ? 'active' : '' }}" onclick="closeMobileMenu()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/></svg>
                        <span>Riwayat Absensi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('leave.index') }}" class="drawer-nav-link {{ request()->routeIs('leave.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                        <span>Pengajuan Izin & Sakit</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('activities.index') }}" class="drawer-nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        <span>Logbook Kegiatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('shifts.index') }}" class="drawer-nav-link {{ request()->routeIs('shifts.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Jadwal Shift & Off</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="drawer-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="m19 8 2 2-4 4"/></svg>
                        <span>Edit Profil Saya</span>
                    </a>
                </li>
            </ul>

            @if($activeUser->isAdmin())
                <div class="drawer-section-title" style="color:#fbbf24; margin-top:1.25rem;">Administrator Menu</div>
                <ul class="drawer-nav-list">
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            <span style="color:#fde68a;">Kelola Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.schedules.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                            <span style="color:#fde68a;">Atur Jadwal & Hari Off</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.shifts.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.shifts.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span style="color:#fde68a;">Master Shift Kerja</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.backup.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            <span style="color:#fde68a;">Backup & Restore Data</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.location.index') }}" class="drawer-nav-link {{ request()->routeIs('admin.location.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span style="color:#fde68a;">Radius Lokasi Maps</span>
                        </a>
                    </li>
                </ul>
            @endif

            @if($activeUser->isAdmin() || session()->has('original_admin_id'))
                <!-- Quick Switch User (ADMIN / SESI SIMULASI ADMIN) -->
                <div class="drawer-section-title" style="margin-top:1.25rem;">Ganti Akun Demo (Admin)</div>
                <div class="drawer-user-switch-list">
                    @foreach($allUsers as $u)
                        <a href="{{ route('session.switchUser', $u->id) }}" class="drawer-switch-item {{ $activeUser->id === $u->id ? 'active' : '' }}">
                            <img src="{{ $u->avatar ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80' }}" alt="{{ $u->name }}">
                            <div style="flex:1; min-width:0;">
                                <div style="font-weight:700; color:#fff; font-size:0.8rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $u->name }}</div>
                                <div style="font-size:0.7rem; color:var(--text-muted);">{{ $u->position }}</div>
                            </div>
                            <span class="user-role-badge role-{{ $u->role }}" style="font-size:0.6rem;">{{ strtoupper(substr($u->role, 0, 3)) }}</span>
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Logout Button -->
            <div style="margin-top:1.25rem; padding-bottom:1.5rem;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="drawer-btn-logout">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        <span>Keluar Sistem (Logout)</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Container Content -->
    <main class="main-content">
        <div class="container">
            @if(session()->has('original_admin_id'))
                <div class="alert-banner" style="background:rgba(245,158,11,0.15); border:1px solid rgba(245,158,11,0.4); color:#fde68a; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.5rem;">
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        <span>Mode Simulasi: Anda sedang melihat sistem sebagai <strong>{{ $activeUser->name }}</strong>.</span>
                    </div>
                    <a href="{{ route('session.switchUser', session('original_admin_id')) }}" style="background:#f59e0b; color:#0f172a; padding:0.35rem 0.85rem; border-radius:6px; font-weight:700; text-decoration:none; font-size:0.8rem;">
                        Kembali ke Akun Administrator &rarr;
                    </a>
                </div>
            @endif

            @if(session('success'))
                <div class="alert-banner alert-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-banner alert-danger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Mobile Bottom Navigation Bar (Thumb-Friendly App Style) -->
    <nav class="mobile-bottom-nav" aria-label="Navigasi Bawah">
        <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="mobile-nav-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/>
                </svg>
            </div>
            <span class="mobile-nav-label">Absen</span>
        </a>

        <a href="{{ route('attendances.history') }}" class="mobile-nav-item {{ request()->routeIs('attendances.history') ? 'active' : '' }}">
            <div class="mobile-nav-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
            </div>
            <span class="mobile-nav-label">Riwayat</span>
        </a>

        <a href="{{ route('activities.index') }}" class="mobile-nav-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
            <div class="mobile-nav-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                </svg>
            </div>
            <span class="mobile-nav-label">Logbook</span>
        </a>

        <a href="{{ route('leave.index') }}" class="mobile-nav-item {{ request()->routeIs('leave.*') ? 'active' : '' }}">
            <div class="mobile-nav-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <span class="mobile-nav-label">Izin</span>
        </a>

        <a href="{{ route('shifts.index') }}" class="mobile-nav-item {{ request()->routeIs('shifts.*') ? 'active' : '' }}">
            <div class="mobile-nav-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <span class="mobile-nav-label">Shift</span>
        </a>
    </nav>

    <!-- Global Image Preview Modal -->
    <div class="modal-overlay" id="imagePreviewModal" onclick="closeImageModal()">
        <div class="modal-dialog" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 style="font-size:1rem; font-weight:700; color:#fff;" id="modalPreviewTitle">Pratinjau Foto</h3>
                <button onclick="closeImageModal()" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>
            </div>
            <div class="modal-body" style="text-align:center;">
                <img id="modalPreviewImg" src="" alt="Preview" style="max-width:100%; max-height:480px; border-radius:12px; object-fit:contain; border:1px solid var(--border-subtle);">
            </div>
        </div>
    </div>

    <!-- Custom Scripts -->
    <script>
        window.ACTIVE_USER_ID = {{ $activeUser->id }};
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
