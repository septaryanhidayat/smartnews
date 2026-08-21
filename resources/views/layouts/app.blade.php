<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SmartNews – Portal Berita Terpercaya & Cerdas')</title>
    <meta name="description" content="@yield('meta_description', 'SmartNews - Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.')">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'SmartNews – Portal Berita Terpercaya & Cerdas')">
    <meta property="og:description" content="@yield('meta_description', 'Portal berita Indonesia terpercaya dan cerdas.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.svg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Noto+Serif:wght@700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Swiper Carousel CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/digiterkini.css') }}">
    @stack('styles')
</head>
<body class="@yield('body_class', 'home blog')">

    <!-- READING SCROLL PROGRESS BAR (RED METER) -->
    <div class="scroll-progress-bar" id="scrollProgressBar"></div>

    <!-- 1. FIXED TOP NAVIGATION -->
    <header class="top-nav" id="topNav">
        <div class="top-nav__inner container">
            <div class="top-nav__left">
                <button class="menu-toggle" id="menuToggle" aria-label="Buka Menu">
                    <span class="menu-toggle__circle">
                        <i class="fas fa-bars"></i>
                    </span>
                    <span class="menu-toggle__label">MENU</span>
                </button>
            </div>

            <div class="top-nav__center">
                <form class="search-form" action="{{ route('search') }}" method="GET" role="search">
                    <button class="search-form__btn" type="submit" aria-label="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                    <input
                        class="search-form__input"
                        name="q"
                        type="search"
                        placeholder="Masukkan kata kunci berita..."
                        autocomplete="off"
                        value="{{ request('q') ?? request('s') }}"
                    />
                </form>
            </div>

            <div class="top-nav__right">
                <button class="btn-dark-mode" id="darkModeBtn" aria-label="Toggle dark mode" title="Mode Gelap / Terang">
                    <i class="fas fa-moon"></i>
                </button>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin">
                        <i class="fas fa-tachometer-alt"></i> Panel Admin
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-order">Daftar</a>
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- 2. OFFCANVAS MOBILE SIDEBAR DRAWER -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="sidebar-drawer" id="sidebarDrawer" role="dialog" aria-label="Menu Navigasi">
        <div class="sidebar-drawer__header">
            <a href="{{ route('home') }}" class="brand-logo-img">
                <img src="{{ asset('images/logo.svg') }}" alt="SmartNews Logo" class="site-logo-img" style="height: 38px;">
            </a>
            <button class="sidebar-drawer__close" id="sidebarClose" aria-label="Tutup menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="padding: 16px 20px 0;">
            <form class="search-form" action="{{ route('search') }}" method="GET">
                <button class="search-form__btn" type="submit"><i class="fas fa-search"></i></button>
                <input class="search-form__input" name="q" type="search" placeholder="Cari berita..." value="{{ request('q') }}">
            </form>
        </div>

        <nav class="sidebar-drawer__nav">
            <ul>
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fas fa-home" style="margin-right: 8px; width: 16px;"></i> Beranda</a>
                </li>
                @php
                    $drawerCategories = \App\Models\Category::orderBy('order', 'asc')->get();
                @endphp
                @foreach($drawerCategories as $cat)
                    <li class="{{ request()->is('kategori/' . $cat->slug) ? 'active' : '' }}">
                        <a href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div style="padding: 0 20px 16px; display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 13px; font-weight: 600;">Tema Tampilan:</span>
            <button class="btn-dark-mode" id="drawerDarkModeBtn" aria-label="Toggle tema">
                <i class="fas fa-moon"></i>
            </button>
        </div>

        <div class="sidebar-drawer__socials">
            <a href="https://facebook.com" class="sidebar-drawer__social" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com" class="sidebar-drawer__social" target="_blank" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
            <a href="https://tiktok.com" class="sidebar-drawer__social" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            <a href="https://youtube.com" class="sidebar-drawer__social" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>

        <div class="sidebar-drawer__copyright">
            <p>Copyright &copy; {{ date('Y') }} SmartNews. All Rights Reserved.</p>
        </div>
    </aside>

    <!-- 3. SITE HEADER BRANDING -->
    <section class="site-header">
        <div class="site-header__inner container">
            <div class="site-header__logo">
                <a href="{{ route('home') }}" class="logo-link">
                    <img src="{{ asset('images/logo.svg') }}" alt="SmartNews Logo" class="site-logo-main" style="height: 48px;">
                </a>
            </div>

            <div class="header-banner-ad">
                <span><i class="fas fa-bolt" style="margin-right: 6px; color: #fbbf24;"></i> Liputan Khusus: Transformasi Nasional Menuju Indonesia Emas</span>
            </div>
        </div>
    </section>

    <!-- 4. PRIMARY NAVIGATION MENU -->
    <nav class="main-nav" id="mainNav" aria-label="Navigasi Utama">
        <div class="main-nav__inner container">
            <ul class="menu" id="header-main-menu">
                <li class="{{ request()->routeIs('home') ? 'current-menu-item' : '' }}">
                    <a href="{{ route('home') }}">Beranda</a>
                </li>
                @foreach($drawerCategories as $cat)
                    <li class="{{ request()->is('kategori/' . $cat->slug) ? 'current-menu-item' : '' }}">
                        <a href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
                    </li>
                @endforeach
            </ul>

            <button class="main-nav__mobile-toggle" id="mobileNavToggle" aria-label="Buka semua menu">
                <i class="fas fa-th-large"></i>
                <span>Semua</span>
            </button>
        </div>
    </nav>

    <!-- 5. TRENDING TAGS TICKER -->
    @if(isset($trendingTags) && $trendingTags->count() > 0)
    <section class="trending-tags">
        <div class="trending-tags__inner container">
            <span class="trending-tags__label">
                <i class="fas fa-fire"></i> Trending:
            </span>
            <div class="trending-tags__scroll">
                @foreach($trendingTags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}" class="trending-tags__item">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- MAIN YIELD CONTENT -->
    @yield('content')

    <!-- 6. SITE FOOTER -->
    <footer class="site-footer" id="siteFooter">
        <div class="footer-main">
            <div class="container">
                <div class="footer-main__grid">
                    <!-- Col 1: Brand & Contact -->
                    <div class="footer-col footer-col--brand">
                        <a href="{{ route('home') }}" class="footer-logo">
                            <img src="{{ asset('images/logo-white.svg') }}" alt="SmartNews Logo" style="height: 44px; margin-bottom: 8px;">
                        </a>
                        <p class="footer-brand__desc">
                            Portal berita Indonesia terpercaya dan cerdas, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.
                        </p>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Jl. Sudirman Kav. 52–53, Jakarta Pusat 10220</span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>(012) 3456-7890</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>redaksi@smartnews.id</span>
                            </li>
                        </ul>
                        <div class="footer-socials">
                            <a href="https://facebook.com" class="footer-social" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com" class="footer-social" target="_blank" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                            <a href="https://tiktok.com" class="footer-social" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com" class="footer-social" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <!-- Col 2: About Links -->
                    <div class="footer-col">
                        <h4 class="footer-col__title">Tentang Kami</h4>
                        <nav class="footer-links">
                            <ul>
                                <li><a href="{{ route('page.show', 'tentang-kami') }}">Tentang Kami</a></li>
                                <li><a href="{{ route('page.show', 'redaksi') }}">Susunan Redaksi</a></li>
                                <li><a href="{{ route('page.show', 'pedoman-media-siber') }}">Pedoman Media Siber</a></li>
                                <li><a href="{{ route('page.show', 'disclaimer') }}">Kode Etik & Disclaimer</a></li>
                                <li><a href="{{ route('page.show', 'kontak') }}">Hubungi Kami</a></li>
                                <li><a href="{{ route('page.show', 'kontak') }}">Pasang Iklan</a></li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Col 3: Categories -->
                    <div class="footer-col">
                        <h4 class="footer-col__title">Kategori Berita</h4>
                        <nav class="footer-links">
                            <ul>
                                @foreach($drawerCategories->take(6) as $fcat)
                                    <li><a href="{{ route('category.show', $fcat->slug) }}">{{ $fcat->name }}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    <!-- Col 4: Badges & Info -->
                    <div class="footer-col">
                        <h4 class="footer-col__title">Informasi & Verifikasi</h4>
                        <nav class="footer-links">
                            <ul>
                                <li><a href="{{ route('page.show', 'disclaimer') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('page.show', 'disclaimer') }}">Terms & Conditions</a></li>
                                <li><a href="{{ route('page.show', 'pedoman-media-siber') }}">Pedoman Media Siber</a></li>
                            </ul>
                        </nav>
                        <div class="footer-badges">
                            <span class="footer-badge">
                                <i class="fas fa-certificate"></i> Terverifikasi Dewan Pers
                            </span>
                            <span class="footer-badge">
                                <i class="fas fa-shield-alt"></i> Media Siber Terpercaya
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <div class="container">
                <p>Copyright &copy; {{ date('Y') }} <strong>SmartNews</strong> by <a href="https://berandadigital.net" target="_blank" rel="noopener" class="footer-attribution-link">Beranda Teknologi Digital</a>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP BUTTON -->
    <button class="back-to-top" id="backToTop" aria-label="Kembali ke atas">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- MODAL COPY LINK TOAST -->
    <div class="copy-modal" id="copyModal" role="alert" aria-live="polite">
        <div class="copy-modal__inner">
            <div class="copy-modal__icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="copy-modal__body">
                <p class="copy-modal__title">Link Tersalin!</p>
                <p class="copy-modal__desc">Link artikel berhasil disalin ke clipboard.</p>
            </div>
        </div>
        <div class="copy-modal__progress" id="copyModalProgress"></div>
    </div>

    <!-- Swiper JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Theme Custom Scripts -->
    <script src="{{ asset('js/digiterkini.js') }}"></script>
    @stack('scripts')
</body>
</html>
