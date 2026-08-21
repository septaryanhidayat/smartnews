<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        body { font-family: 'Noto Sans', sans-serif; background-color: var(--admin-bg); color: var(--admin-text); display: flex; min-height: 100vh; font-size: 14px; }
        a { text-decoration: none; color: inherit; }

        /* Sidebar */
        .admin-sidebar { width: 250px; background-color: var(--admin-sidebar); color: #e2e8f0; display: flex; flex-direction: column; flex-shrink: 0; }
        .admin-brand { padding: 20px 22px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); font-size: 18px; font-weight: 800; display: flex; align-items: center; justify-content: space-between; }
        .admin-brand span.logo-digi { color: #60a5fa; }
        .admin-brand span.logo-terkini { color: #f87171; }
        .admin-menu { list-style: none; padding: 16px 0; flex: 1; }
        .admin-menu li a { display: flex; align-items: center; gap: 12px; padding: 12px 22px; color: #94a3b8; font-weight: 600; font-size: 14px; transition: all 0.2s; border-left: 3px solid transparent; }
        .admin-menu li a:hover, .admin-menu li.active a { background-color: rgba(255, 255, 255, 0.06); color: #ffffff; border-left-color: #60a5fa; }
        .admin-menu li a i { width: 20px; font-size: 15px; }

        /* Content Area */
        .admin-main { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow-y: auto; }
        .admin-topbar { height: 60px; background-color: var(--admin-card); border-bottom: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; }
        .admin-body { padding: 28px; flex: 1; }

        .card { background-color: var(--admin-card); border-radius: 8px; border: 1px solid var(--admin-border); box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); padding: 22px; margin-bottom: 24px; }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; border-bottom: 1px solid var(--admin-border); padding-bottom: 12px; }
        .card-title { font-size: 16px; font-weight: 700; }

        /* Tables & Forms */
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background-color: #f8fafc; padding: 10px 14px; font-weight: 700; font-size: 12px; text-transform: uppercase; color: var(--admin-muted); border-bottom: 1px solid var(--admin-border); }
        td { padding: 12px 14px; border-bottom: 1px solid var(--admin-border); vertical-align: middle; }
        tr:hover td { background-color: #f8fafc; }

        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; border: none; transition: 0.2s; }
        .btn-primary { background-color: var(--admin-primary); color: #fff; }
        .btn-primary:hover { background-color: #1442a6; }
        .btn-success { background-color: #059669; color: #fff; }
        .btn-danger { background-color: #dc2626; color: #fff; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }

        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px; }
        .form-control { width: 100%; padding: 8px 12px; border: 1px solid var(--admin-border); border-radius: 6px; font-size: 14px; font-family: inherit; }
        .form-control:focus { outline: none; border-color: var(--admin-primary); box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.15); }
        
        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }

        .alert-success { background-color: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 18px; font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 8px;">
                <img src="{{ asset('images/logo-white.svg') }}" alt="SmartNews Logo" style="height: 32px;">
                <span style="font-size: 11px; background: rgba(255,255,255,0.15); padding: 2px 6px; border-radius: 4px;">CMS</span>
            </a>
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
            <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                <a href="{{ route('home') }}" target="_blank"><i class="fas fa-external-link-alt"></i> Lihat Website</a>
            </li>
        </ul>
        <div style="padding: 16px 22px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 12px; color: #64748b;">
            Logged as: <a href="{{ route('admin.profile.index') }}" style="color: #60a5fa; font-weight: 700; text-decoration: underline;">{{ Auth::user()->name }}</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <header class="admin-topbar">
            <div style="font-weight: 700; font-size: 16px;">
                @yield('page_title', 'Admin Dashboard')
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="{{ route('admin.profile.index') }}" class="btn btn-sm" style="background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                    <i class="fas fa-user-shield"></i> {{ Auth::user()->name }}
                </a>
                <a href="{{ route('home') }}" class="btn btn-sm btn-primary" target="_blank">
                    <i class="fas fa-globe"></i> Portal Publik
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Keluar
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

    @stack('scripts')
</body>
</html>
