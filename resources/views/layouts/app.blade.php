<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', setting('site_name', 'SmartNews') . ' - ' . setting('site_tagline', 'Portal Berita Terpercaya & Cerdas'))</title>
    <meta name="description" content="@yield('meta_description', setting('site_description', 'SmartNews - Portal berita Indonesia terpercaya, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('site_keywords', 'smartnews, berita terkini, berita indonesia, portal berita, nasional, politik, ekonomi, teknologi, olahraga'))">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="@yield('meta_author', setting('site_name', 'SmartNews'))">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    @if(setting('google_site_verification'))
    <meta name="google-site-verification" content="{{ setting('google_site_verification') }}">
    @endif

    <!-- Open Graph Meta Tags (Facebook, WhatsApp, Telegram, LinkedIn) -->
    <meta property="og:site_name" content="{{ setting('site_name', 'SmartNews') }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'en' ? 'en_US' : 'id_ID' }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', setting('site_name', 'SmartNews') . ' - ' . setting('site_tagline', 'Portal Berita Terpercaya & Cerdas'))">
    <meta property="og:description" content="@yield('meta_description', setting('site_description', 'Portal berita Indonesia terpercaya dan cerdas.'))">
    <meta property="og:image" content="@yield('og_image', site_logo())">
    <meta property="og:image:secure_url" content="@yield('og_image', site_logo())">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('og_title', setting('site_name', 'SmartNews'))">
    @yield('extra_og_tags')

    <!-- Twitter / X Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="@yield('canonical_url', url()->current())">
    <meta name="twitter:title" content="@yield('og_title', setting('site_name', 'SmartNews'))">
    <meta name="twitter:description" content="@yield('meta_description', setting('site_description', 'Portal berita Indonesia terpercaya dan cerdas.'))">
    <meta name="twitter:image" content="@yield('og_image', site_logo())">
    @if(setting('social_twitter'))
    <meta name="twitter:site" content="{{ '@' . ltrim(parse_url(setting('social_twitter'), PHP_URL_PATH), '/') }}">
    @endif

    <!-- Schema.org JSON-LD Structured Data for SEO -->
    @yield('schema_jsonld')

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ site_favicon() }}">
    <link rel="apple-touch-icon" href="{{ site_favicon() }}">

    <!-- DNS Prefetch & Preconnect for High Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Noto+Serif:wght@700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons (Async Loaded for Zero Render-Blocking) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Swiper Carousel CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Theme Stylesheet (Cached with Static Versioning) -->
    <link rel="stylesheet" href="{{ asset('css/smartnews.css') }}?v=1.5">
    @stack('styles')

    <!-- Early theme init: Default to light mode unless user explicitly selected dark -->
    <script>
        (function() {
            try {
                if (localStorage.getItem('smartnews_theme') === 'dark') {
                    document.documentElement.classList.add('dark-mode');
                } else {
                    document.documentElement.classList.remove('dark-mode');
                }
            } catch (e) {}
        })();
    </script>
</head>
<body class="@yield('body_class', 'home blog')">

    <!-- SKIP TO MAIN CONTENT LINK FOR KEYBOARD & SCREEN READERS (WCAG 2.1) -->
    <a href="#mainContent" class="skip-link">Lewati ke konten utama</a>

    <!-- READING SCROLL PROGRESS BAR (RED METER) -->
    <div class="scroll-progress-bar" id="scrollProgressBar"></div>

    <!-- 1. FIXED TOP NAVIGATION -->
    <header class="top-nav" id="topNav">
        <div class="top-nav__inner container">
            <div class="top-nav__left">
                <!-- Mobile Top-Left Brand Logo (visible on mobile <= 768px) -->
                <a href="{{ route('home') }}" class="top-nav__brand-mobile" aria-label="{{ setting('site_name', 'SmartNews') }}">
                    <img src="{{ site_logo() }}" data-logo-light="{{ site_logo() }}" data-logo-dark="{{ site_logo_dark() }}" alt="{{ setting('site_name', 'SmartNews') }} Logo" class="site-logo-main site-logo-mobile-top">
                </a>

                <!-- Desktop Menu Toggle (hidden on mobile) -->
                <button class="menu-toggle d-desktop-only" id="menuToggle" type="button" aria-label="Buka Menu">
                    <span class="menu-toggle__circle">
                        <i class="fas fa-bars"></i>
                    </span>
                    <span class="menu-toggle__label">MENU</span>
                </button>
            </div>

            <div class="top-nav__center">
                <form class="search-form" action="{{ route('search') }}" method="GET" role="search">
                    <label for="topNavSearchInput" class="sr-only">{{ __('messages.search') }}</label>
                    <button class="search-form__btn" type="submit" aria-label="Cari">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                    <input
                        id="topNavSearchInput"
                        class="search-form__input"
                        name="q"
                        type="search"
                        aria-label="{{ __('messages.search_placeholder') }}"
                        placeholder="{{ __('messages.search_placeholder') }}"
                        autocomplete="off"
                        value="{{ request('q') ?? request('s') }}"
                    />
                </form>
            </div>

            <div class="top-nav__right">
                <!-- Language Switcher Pill -->
                <div class="lang-switcher">
                    <a href="{{ route('lang.switch', 'id') }}" onclick="switchLanguage('id'); return false;" class="lang-btn {{ app()->getLocale() === 'id' ? 'active' : '' }}" aria-label="Bahasa Indonesia" title="Bahasa Indonesia">
                        <span>ID</span>
                    </a>
                    <span class="lang-divider" aria-hidden="true">|</span>
                    <a href="{{ route('lang.switch', 'en') }}" onclick="switchLanguage('en'); return false;" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}" aria-label="English Language" title="English Language">
                        <span>EN</span>
                    </a>
                </div>

                <!-- Mobile Search Toggle Button (visible on mobile) -->
                <button class="btn-mobile-search" id="mobileSearchToggle" type="button" aria-label="{{ __('messages.search') }}" title="{{ __('messages.search') }}">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </button>

                <!-- Dark Mode Toggle Button -->
                <button class="btn-dark-mode" id="darkModeBtn" type="button" aria-label="{{ __('messages.dark_mode') }}" title="{{ __('messages.dark_mode') }}">
                    <i class="fas fa-moon" aria-hidden="true"></i>
                </button>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin d-desktop-only" title="{{ __('messages.admin_panel') }}" aria-label="{{ __('messages.admin_panel') }}">
                        <i class="fas fa-tachometer-alt"></i> <span class="btn-text">Admin</span>
                    </a>
                @else
                    <a href="{{ route('landing') }}" class="btn-order d-desktop-only" style="background: linear-gradient(135deg, #dc2626, #b91c1c); color: #ffffff !important; font-weight: 700; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);" title="Pesan Website Portal Berita Siap Pakai Rp 3 Juta" aria-label="Pesan Web Portal Berita">
                        <i class="fas fa-shopping-cart" style="font-size: 11px;"></i> <span>Pesan Web</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn-login d-desktop-only" title="{{ __('messages.login') }}" aria-label="{{ __('messages.login') }}">
                        <i class="fas fa-user-circle"></i> <span class="btn-text">{{ __('messages.login') }}</span>
                    </a>
                @endauth

                <!-- Mobile Menu Hamburger Button (visible on mobile) -->
                <button class="menu-toggle-mobile" id="mobileMenuToggle" type="button" aria-label="Menu">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Expandable Search Bar -->
        <div class="mobile-search-bar" id="mobileSearchBar">
            <div class="container">
                <form class="search-form search-form--mobile" action="{{ route('search') }}" method="GET" role="search">
                    <label for="mobileSearchInput" class="sr-only">{{ __('messages.search') }}</label>
                    <button class="search-form__btn" type="submit" aria-label="Cari">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                    <input
                        class="search-form__input"
                        id="mobileSearchInput"
                        name="q"
                        type="search"
                        aria-label="{{ __('messages.search_placeholder') }}"
                        placeholder="Ketik kata kunci berita lalu tekan enter..."
                        autocomplete="off"
                        value="{{ request('q') ?? request('s') }}"
                    />
                    <button class="mobile-search-close" id="mobileSearchClose" type="button" aria-label="Tutup pencarian">
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- 2. OFFCANVAS MOBILE SIDEBAR DRAWER -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="sidebar-drawer" id="sidebarDrawer" role="dialog" aria-label="Menu Navigasi">
        <div class="sidebar-drawer__header">
            <a href="{{ route('home') }}" class="brand-logo-img" aria-label="{{ setting('site_name', 'SmartNews') }}">
                <img src="{{ site_logo() }}" data-logo-light="{{ site_logo() }}" data-logo-dark="{{ site_logo_dark() }}" alt="{{ setting('site_name', 'SmartNews') }} Logo" class="site-logo-img" style="height: 38px;">
            </a>
            <button class="sidebar-drawer__close" id="sidebarClose" type="button" aria-label="Tutup menu">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Auth Status Box in Drawer -->
        <div style="padding: 14px 20px; border-bottom: 1px solid var(--border-color);">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-admin" style="display: flex; align-items: center; justify-content: center; padding: 9px; border-radius: 8px; font-weight: 700; text-decoration: none;">
                    <i class="fas fa-tachometer-alt"></i> &nbsp;Panel Admin
                </a>
            @else
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('login') }}" class="btn-login" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 8px; border-radius: 8px; font-weight: 600; text-decoration: none;">
                        <i class="fas fa-sign-in-alt"></i> &nbsp;{{ __('messages.login') }}
                    </a>
                    <a href="{{ route('landing') }}" class="btn-order" style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 8px; border-radius: 8px; font-weight: 700; text-decoration: none; background: #dc2626; color: #fff;">
                        <i class="fas fa-shopping-cart"></i> Pesan Web
                    </a>
                </div>
            @endauth
        </div>

        <div style="padding: 16px 20px 0;">
            <form class="search-form" action="{{ route('search') }}" method="GET" role="search">
                <label for="drawerSearchInput" class="sr-only">{{ __('messages.search') }}</label>
                <button class="search-form__btn" type="submit" aria-label="Cari"><i class="fas fa-search" aria-hidden="true"></i></button>
                <input id="drawerSearchInput" class="search-form__input" name="q" type="search" aria-label="{{ __('messages.search_placeholder') }}" placeholder="{{ __('messages.search_placeholder') }}" value="{{ request('q') }}">
            </form>
        </div>

        <nav class="sidebar-drawer__nav" aria-label="Navigasi Menu Drawer">
            <ul>
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fas fa-home" style="margin-right: 8px; width: 16px;"></i> {{ __('messages.home') }}</a>
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

        <div style="padding: 0 20px 16px; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 14px;">
            <span style="font-size: 13px; font-weight: 600;">Bahasa / Language:</span>
            <div class="lang-switcher">
                <a href="{{ route('lang.switch', 'id') }}" onclick="switchLanguage('id'); return false;" class="lang-btn {{ app()->getLocale() === 'id' ? 'active' : '' }}" title="Bahasa Indonesia">
                    <span>ID</span>
                </a>
                <span class="lang-divider">|</span>
                <a href="{{ route('lang.switch', 'en') }}" onclick="switchLanguage('en'); return false;" class="lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}" title="English Language">
                    <span>EN</span>
                </a>
            </div>
        </div>

        <div style="padding: 0 20px 16px; display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 13px; font-weight: 600;">{{ __('messages.dark_mode') }}:</span>
            <button class="btn-dark-mode" id="drawerDarkModeBtn" type="button" aria-label="Toggle tema mode gelap">
                <i class="fas fa-moon" aria-hidden="true"></i>
            </button>
        </div>

        <div class="sidebar-drawer__socials">
            <a href="{{ setting('social_facebook', 'https://facebook.com') }}" class="sidebar-drawer__social" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="{{ setting('social_twitter', 'https://twitter.com') }}" class="sidebar-drawer__social" target="_blank" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
            <a href="{{ setting('social_instagram', 'https://instagram.com') }}" class="sidebar-drawer__social" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="{{ setting('social_tiktok', 'https://tiktok.com') }}" class="sidebar-drawer__social" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            <a href="{{ setting('social_youtube', 'https://youtube.com') }}" class="sidebar-drawer__social" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>

        <div class="sidebar-drawer__copyright">
            <p>Copyright &copy; {{ date('Y') }} {{ setting('site_name', 'SmartNews') }}. All Rights Reserved.</p>
        </div>
    </aside>

    <!-- 3. SITE HEADER BRANDING -->
    <section class="site-branding" id="siteBranding">
        <div class="container site-branding__inner">
            <div class="site-branding__logo">
                <a href="{{ route('home') }}" class="custom-logo-link" rel="home" aria-label="{{ setting('site_name', 'SmartNews') }}">
                    <img src="{{ site_logo() }}" data-logo-light="{{ site_logo() }}" data-logo-dark="{{ site_logo_dark() }}" alt="{{ setting('site_name', 'SmartNews') }} Logo" class="site-logo-main" style="height: 48px;">
                </a>
            </div>

            <div class="header-banner-ad">
                <span><i class="fas fa-bolt" style="margin-right: 6px; color: #fbbf24;"></i> {{ setting('site_tagline', 'Portal Berita Terpercaya & Cerdas') }}</span>
            </div>
        </div>
    </section>

    <!-- 4. PRIMARY NAVIGATION MENU -->
    <nav class="main-nav" id="mainNav" aria-label="Navigasi Utama">
        <div class="main-nav__inner container">
            <div class="main-nav__scroll-wrap">
                <ul class="menu" id="header-main-menu">
                    <li class="{{ request()->routeIs('home') ? 'current-menu-item' : '' }}">
                        <a href="{{ route('home') }}"><i class="fas fa-home"></i> {{ __('messages.home') }}</a>
                    </li>
                    @php
                        $allNavCats = \App\Models\Category::orderBy('order', 'asc')->get();
                        $primaryCats = $allNavCats->take(6);
                        $moreCats = $allNavCats->slice(6);
                    @endphp

                    @foreach($primaryCats as $cat)
                        <li class="{{ request()->is('kategori/' . $cat->slug) ? 'current-menu-item' : '' }}">
                            <a href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a>
                        </li>
                    @endforeach

                    @foreach($moreCats as $mCat)
                        <li class="menu-item-mobile-only {{ request()->is('kategori/' . $mCat->slug) ? 'current-menu-item' : '' }}">
                            <a href="{{ route('category.show', $mCat->slug) }}">{{ $mCat->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="main-nav__actions">
                @if($moreCats->count() > 0)
                <div class="nav-dropdown d-desktop-only" id="navDropdownMore">
                    <button type="button" class="nav-dropdown__btn" id="navDropdownBtn" aria-haspopup="true" aria-expanded="false" title="Kategori Lainnya">
                        <span>{{ __('messages.more') }}</span>
                        <i class="fas fa-chevron-down nav-dropdown__icon"></i>
                    </button>
                    <div class="nav-dropdown__popover" id="navDropdownPopover">
                        <div class="nav-dropdown__popover-header">
                            <span class="nav-dropdown__title"><i class="fas fa-layer-group"></i> {{ __('messages.other_rubrics') }}</span>
                        </div>
                        <div class="nav-dropdown__grid">
                            @foreach($moreCats as $mCat)
                                <a href="{{ route('category.show', $mCat->slug) }}" class="nav-dropdown__item {{ request()->is('kategori/' . $mCat->slug) ? 'active' : '' }}">
                                    <i class="fas fa-angle-right"></i>
                                    <span>{{ $mCat->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <button class="main-nav__all-toggle" id="mobileNavToggle" type="button" aria-label="Buka semua kategori">
                    <i class="fas fa-th-large" aria-hidden="true"></i>
                    <span class="d-desktop-only">{{ __('messages.all_rubrics') }}</span>
                    <span class="d-mobile-only">{{ __('messages.all_rubrics') }}</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- 4b. BREAKING NEWS MARQUEE TICKER -->
    @if(isset($breakingNews) && $breakingNews->count() > 0)
    <section class="breaking-news-bar" aria-label="Breaking News">
        <div class="breaking-news__inner container">
            <div class="breaking-news__badge">
                <span class="breaking-news__pulse"></span>
                <i class="fas fa-bolt"></i>
                <span class="badge-text-desktop">BREAKING NEWS</span>
                <span class="badge-text-mobile">BREAKING</span>
            </div>
            <div class="breaking-news__ticker-wrap">
                <div class="breaking-news__ticker-track">
                    @foreach($breakingNews as $bNews)
                        <a href="{{ route('article.show', $bNews->slug) }}" class="breaking-news__item">
                            <span class="breaking-news__category">{{ $bNews->category->name }}</span>
                            <span class="breaking-news__title">{{ $bNews->title }}</span>
                            <span class="breaking-news__time"><i class="far fa-clock"></i> {{ $bNews->published_at ? $bNews->published_at->diffForHumans() : '' }}</span>
                            <span class="breaking-news__divider">&bull;</span>
                        </a>
                    @endforeach
                    @foreach($breakingNews as $bNews)
                        <a href="{{ route('article.show', $bNews->slug) }}" class="breaking-news__item" aria-hidden="true" tabindex="-1">
                            <span class="breaking-news__category">{{ $bNews->category->name }}</span>
                            <span class="breaking-news__title">{{ $bNews->title }}</span>
                            <span class="breaking-news__time"><i class="far fa-clock"></i> {{ $bNews->published_at ? $bNews->published_at->diffForHumans() : '' }}</span>
                            <span class="breaking-news__divider">&bull;</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 5. TRENDING TAGS TICKER -->
    @if(isset($trendingTags) && $trendingTags->count() > 0)
    <section class="trending-tags">
        <div class="trending-tags__inner container">
            <span class="trending-tags__label">
                <i class="fas fa-fire"></i> Trending:
            </span>
            <div class="trending-tags__scroll">
                @foreach($trendingTags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}" class="trending-tags__item" aria-label="Topik trending {{ $tag->name }}">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- OPTIONAL HEADER AD BANNER -->
    {!! ad_render('header', 'container') !!}

    <!-- MAIN YIELD CONTENT -->
    @yield('content')

    <!-- 6. SITE FOOTER -->
    <footer class="site-footer" id="siteFooter">
        <div class="footer-main">
            <div class="container">
                <div class="footer-main__grid">
                    <!-- Col 1: Brand & Contact -->
                    <div class="footer-col footer-col--brand">
                        <a href="{{ route('home') }}" class="footer-logo" aria-label="{{ setting('site_name', 'SmartNews') }}">
                            <img src="{{ site_logo_dark() }}" alt="{{ setting('site_name', 'SmartNews') }} Logo" style="height: 44px; margin-bottom: 8px;">
                        </a>
                        <p class="footer-brand__desc">
                            {{ setting('site_description', 'Portal berita Indonesia terpercaya dan cerdas, menyajikan informasi terkini, akurat, dan berimbang untuk seluruh lapisan masyarakat.') }}
                        </p>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ setting('contact_address', 'Jl. Sarjana, Timbangan, Ogan Ilir 30862') }}</span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>{{ setting('contact_phone', '(012) 3456-7890') }}</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>{{ setting('contact_email', 'redaksi@smartnews.id') }}</span>
                            </li>
                        </ul>
                        <div class="footer-socials">
                            <a href="{{ setting('social_facebook', 'https://facebook.com') }}" class="footer-social" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ setting('social_twitter', 'https://twitter.com') }}" class="footer-social" target="_blank" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                            <a href="{{ setting('social_instagram', 'https://instagram.com') }}" class="footer-social" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ setting('social_tiktok', 'https://tiktok.com') }}" class="footer-social" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                            <a href="{{ setting('social_youtube', 'https://youtube.com') }}" class="footer-social" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <!-- Col 2: About Links -->
                    <div class="footer-col">
                        <h3 class="footer-col__title">Tentang Kami</h3>
                        <nav class="footer-links" aria-label="Tautan Tentang Kami">
                            <ul>
                                <li><a href="{{ route('page.show', 'tentang-kami') }}">Tentang Kami</a></li>
                                <li><a href="{{ route('page.show', 'redaksi') }}">Susunan Redaksi</a></li>
                                <li><a href="{{ route('page.show', 'pedoman-media-siber') }}">Pedoman Media Siber</a></li>
                                <li><a href="{{ route('page.show', 'kode-etik') }}">Kode Etik & Disclaimer</a></li>
                                <li><a href="{{ route('page.show', 'kontak') }}">Hubungi Kami</a></li>
                                <li><a href="{{ route('page.show', 'pasang-iklan') }}">Pasang Iklan</a></li>
                                <li><a href="{{ route('landing') }}" style="color: #f87171 !important; font-weight: 700;"><i class="fas fa-fire"></i> Beli Source Code Web (3 Juta)</a></li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Col 3: Categories -->
                    <div class="footer-col">
                        <h3 class="footer-col__title">Kategori Berita</h3>
                        <nav class="footer-links" aria-label="Tautan Kategori Berita">
                            <ul>
                                @foreach(\App\Models\Category::orderBy('order', 'asc')->take(6)->get() as $fcat)
                                    <li><a href="{{ route('category.show', $fcat->slug) }}">{{ $fcat->name }}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    <!-- Col 4: Badges & Info -->
                    <div class="footer-col">
                        <h3 class="footer-col__title">Informasi & Verifikasi</h3>
                        <nav class="footer-links" aria-label="Tautan Informasi dan Kebijakan">
                            <ul>
                                <li><a href="{{ route('page.show', 'privacy-policy') }}">Kebijakan Privasi (Privacy Policy)</a></li>
                                <li><a href="{{ route('page.show', 'terms') }}">Syarat & Ketentuan (Terms)</a></li>
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
    <button class="back-to-top" id="backToTop" type="button" aria-label="Kembali ke atas">
        <i class="fas fa-chevron-up" aria-hidden="true"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    <!-- Google Translate Engine for Dual-Language Auto-Switching -->
    <div id="google_translate_element" style="display: none;"></div>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en',
                autoDisplay: false
            }, 'google_translate_element');
        }

        function switchLanguage(lang) {
            var hostname = window.location.hostname;
            var parts = hostname.split('.');
            var domain = parts.length > 2 ? '.' + parts.slice(-2).join('.') : '.' + hostname;

            if (lang === 'en') {
                document.cookie = "googtrans=/id/en; path=/";
                document.cookie = "googtrans=/id/en; domain=" + hostname + "; path=/";
                document.cookie = "googtrans=/id/en; domain=" + domain + "; path=/";
                document.cookie = "locale=en; path=/; max-age=31536000";
                window.location.href = "{{ route('lang.switch', 'en') }}";
            } else {
                document.cookie = "googtrans=/id/id; path=/";
                document.cookie = "googtrans=/id/id; domain=" + hostname + "; path=/";
                document.cookie = "googtrans=/id/id; domain=" + domain + "; path=/";
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=" + hostname + "; path=/;";
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=" + domain + "; path=/;";
                document.cookie = "locale=id; path=/; max-age=31536000";
                window.location.href = "{{ route('lang.switch', 'id') }}";
            }
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" defer></script>

    <!-- Theme Custom Scripts -->
    <script src="{{ asset('js/smartnews.js') }}?v=1.4" defer></script>
    @stack('scripts')
</body>
</html>
