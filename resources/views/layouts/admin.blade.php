<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel – SmartNews')</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --admin-primary: #1a56db;
            --admin-dark: #0f172a;
            --admin-sidebar: #1e293b;
            --admin-bg: #f1f5f9;
            --admin-card: #ffffff;
            --admin-border: #e2e8f0;
            --admin-text: #1e293b;
            --admin-muted: #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Noto Sans', sans-serif;
            background-color: var(--admin-bg);
            color: var(--admin-text);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
            overflow-x: hidden;
            position: relative;
        }
        a { text-decoration: none; color: inherit; }

        /* Mobile Sidebar Backdrop */
        .admin-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(3px);
            z-index: 1040;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .admin-backdrop.active {
            display: block;
            opacity: 1;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background-color: var(--admin-sidebar);
            color: #e2e8f0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            min-height: 100vh;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .admin-brand {
            padding: 18px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 18px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .admin-brand span.logo-digi { color: #60a5fa; }
        .admin-brand span.logo-terkini { color: #f87171; }
        .admin-sidebar-close {
            display: none;
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 18px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .admin-sidebar-close:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }

        .admin-menu { list-style: none; padding: 12px 0; flex: 1; }
        .admin-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: #94a3b8;
            font-weight: 600;
            font-size: 13.5px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .admin-menu li a:hover, .admin-menu li.active a {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border-left-color: #60a5fa;
        }
        .admin-menu li a i { width: 20px; font-size: 15px; }

        /* Content Area */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            width: 100%;
            overflow-y: auto;
        }
        .admin-topbar {
            height: 60px;
            background-color: var(--admin-card);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .admin-topbar__left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }
        .admin-sidebar-toggle {
            display: none;
            background: #f1f5f9;
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
            width: 36px;
            height: 36px;
            border-radius: 6px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: 0.2s;
        }
        .admin-sidebar-toggle:hover {
            background: #e2e8f0;
        }
        .admin-topbar__title {
            font-weight: 700;
            font-size: 16px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .admin-topbar__right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .admin-body { padding: 24px; flex: 1; min-width: 0; }

        .card {
            background-color: var(--admin-card);
            border-radius: 8px;
            border: 1px solid var(--admin-border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 24px;
            min-width: 0;
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--admin-border);
            padding-bottom: 12px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .card-title { font-size: 16px; font-weight: 700; }

        /* Responsive Tables */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 550px;
        }
        th {
            background-color: #f8fafc;
            padding: 10px 14px;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            color: var(--admin-muted);
            border-bottom: 1px solid var(--admin-border);
            white-space: nowrap;
        }
        td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--admin-border);
            vertical-align: middle;
        }
        tr:hover td { background-color: #f8fafc; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: 0.2s;
            white-space: nowrap;
        }
        .btn-primary { background-color: var(--admin-primary); color: #fff; }
        .btn-primary:hover { background-color: #1442a6; }
        .btn-success { background-color: #059669; color: #fff; }
        .btn-danger { background-color: #dc2626; color: #fff; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px; }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--admin-border);
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15);
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-weight: 600;
        }

        /* Custom Modern Pagination */
        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--admin-border);
        }
        .custom-pagination__summary {
            font-size: 13px;
            color: var(--admin-muted);
        }
        .custom-pagination__list {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 6px;
            margin: 0;
            padding: 0;
        }
        .custom-pagination__item {
            display: inline-flex;
        }
        .custom-pagination__link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 6px;
            border: 1px solid var(--admin-border);
            background-color: #ffffff;
            color: var(--admin-text);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .custom-pagination__link:hover:not(.disabled) {
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            color: var(--admin-primary);
        }
        .custom-pagination__item.active .custom-pagination__link {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(26, 86, 219, 0.25);
        }
        .custom-pagination__item.disabled .custom-pagination__link {
            opacity: 0.4;
            cursor: not-allowed;
            background-color: #f8fafc;
        }
        /* Strict SVG size cap to avoid giant unstyled icons */
        nav[role="navigation"] svg,
        .custom-pagination svg {
            max-width: 14px !important;
            max-height: 14px !important;
            width: 14px !important;
            height: 14px !important;
            display: inline-block !important;
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                height: 100%;
                transform: translateX(-100%);
                box-shadow: 4px 0 20px rgba(0,0,0,0.25);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-sidebar-close {
                display: block;
            }
            .admin-sidebar-toggle {
                display: inline-flex;
            }
            .admin-topbar {
                padding: 0 16px;
            }
            .admin-body {
                padding: 16px;
            }
            .admin-topbar__btn-label {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .admin-body {
                padding: 12px;
            }
            .card {
                padding: 15px;
                margin-bottom: 16px;
            }
            .admin-topbar__title {
                font-size: 14px;
                max-width: 150px;
            }
            .btn-sm {
                padding: 5px 8px;
                font-size: 11px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Backdrop for mobile drawer -->
    <div class="admin-backdrop" id="adminBackdrop"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-brand">
            <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ asset('images/logo-white.svg') }}" alt="SmartNews Logo" style="height: 30px;">
                <span style="font-size: 10px; background: rgba(255,255,255,0.15); padding: 2px 6px; border-radius: 4px; font-weight: 700;">CMS</span>
            </a>
            <button class="admin-sidebar-close" id="adminSidebarClose" aria-label="Tutup Menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="admin-menu">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <a href="{{ route('admin.articles.index') }}"><i class="fas fa-newspaper"></i> Kelola Berita</a>
            </li>
            <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <a href="{{ route('admin.categories.index') }}"><i class="fas fa-folder"></i> Kategori</a>
            </li>
            <li class="{{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <a href="{{ route('admin.tags.index') }}"><i class="fas fa-tags"></i> Topik Tags</a>
            </li>
            <li class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <a href="{{ route('admin.comments.index') }}"><i class="fas fa-comments"></i> Komentar</a>
            </li>
            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}"><i class="fas fa-users-cog"></i> Kelola Pengguna</a>
            </li>
            <li class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <a href="{{ route('admin.profile.index') }}"><i class="fas fa-user-circle"></i> Pengaturan Profil</a>
            </li>
            <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i> Pengaturan Website & SEO</a>
            </li>
            <li class="{{ request()->routeIs('admin.ads.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ads.index') }}"><i class="fas fa-ad"></i> Manajemen Iklan (Ads)</a>
            </li>
            <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                <a href="{{ route('home') }}" target="_blank"><i class="fas fa-external-link-alt"></i> Lihat Website</a>
            </li>
        </ul>
        <div style="padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 12px; color: #64748b;">
            Logged as: <a href="{{ route('admin.profile.index') }}" style="color: #60a5fa; font-weight: 700; text-decoration: underline;">{{ Auth::user()->name ?? 'Administrator' }}</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar__left">
                <button class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Buka Navigasi">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="admin-topbar__title">
                    @yield('page_title', 'Admin Dashboard')
                </div>
            </div>
            <div class="admin-topbar__right">
                <a href="{{ route('admin.profile.index') }}" class="btn btn-sm" style="background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;" title="Profil Admin">
                    <i class="fas fa-user-shield"></i> <span class="admin-topbar__btn-label">{{ Auth::user()->name ?? 'Admin' }}</span>
                </a>
                <a href="{{ route('home') }}" class="btn btn-sm btn-primary" target="_blank" title="Lihat Portal Publik">
                    <i class="fas fa-globe"></i> <span class="admin-topbar__btn-label">Portal</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" title="Keluar">
                        <i class="fas fa-sign-out-alt"></i> <span class="admin-topbar__btn-label">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <div class="admin-body">
            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        // Admin Mobile Sidebar Drawer Script
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('adminSidebar');
            const toggleBtn = document.getElementById('adminSidebarToggle');
            const closeBtn = document.getElementById('adminSidebarClose');
            const backdrop = document.getElementById('adminBackdrop');

            function openSidebar() {
                if (sidebar && backdrop) {
                    sidebar.classList.add('open');
                    backdrop.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeSidebar() {
                if (sidebar && backdrop) {
                    sidebar.classList.remove('open');
                    backdrop.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });

            // Close sidebar when clicking any menu link on mobile
            const menuLinks = document.querySelectorAll('.admin-menu a');
            menuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 992) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>

