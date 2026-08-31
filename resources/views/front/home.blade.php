@extends('layouts.app')

@section('title', 'SmartNews – Portal Berita Terpercaya & Cerdas')

@section('content')
<main id="mainContent">

    @php
        $heroSliderCols = (int) setting('hero_slider_count', 3);
        if ($heroSliderCols < 1) $heroSliderCols = 3;
    @endphp

    <!-- 1. HERO SLIDER SECTION (SWIPER CAROUSEL) -->
    @if(isset($sliderArticles) && $sliderArticles->count() > 0)
    <section class="hero-slider-section">
        <div class="container">
            <div class="hero-slider-section__overflow">
                <div class="swiper hero-swiper hero-swiper--cols-{{ min($heroSliderCols, 8) }}" id="heroSwiper" data-per-view="{{ $heroSliderCols }}">
                    <div class="swiper-wrapper">
                        @foreach($sliderArticles as $slide)
                        <div class="swiper-slide">
                            <article class="slide-card">
                                <div class="slide-card__img-wrap">
                                    <a href="{{ route('article.show', $slide->slug) }}" aria-label="{{ $slide->title }}">
                                        <img class="slide-card__img" src="{{ $slide->image_url }}" alt="{{ $slide->title }}" onerror="this.src='{{ asset('images/default-news.webp') }}'">
                                    </a>
                                    @if($slide->media_type === 'video')
                                        <div class="media-badge media-badge--video">
                                            <i class="fas fa-play"></i> <span>{{ $slide->media_badge ?? '02:07' }}</span>
                                        </div>
                                    @elseif($slide->media_type === 'photo')
                                        <div class="media-badge media-badge--photo">
                                            <i class="fas fa-camera"></i> <span>{{ $slide->media_badge ?? '3 Foto' }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="slide-card__overlay">
                                    <a class="slide-card__cat" href="{{ route('category.show', $slide->category->slug) }}">
                                        {{ $slide->category->name }}
                                    </a>
                                    <h3 class="slide-card__title">
                                        <a href="{{ route('article.show', $slide->slug) }}">
                                            {{ $slide->title }}
                                        </a>
                                    </h3>
                                    <span class="slide-card__time">
                                        <i class="fas fa-clock"></i> {{ $slide->published_at ? $slide->published_at->format('d F Y') : $slide->created_at->format('d F Y') }}
                                    </span>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>

                    <!-- Swiper Navigation Arrows -->
                    <div class="swiper-button-prev hero-swiper__prev" aria-label="Slide sebelumnya"></div>
                    <div class="swiper-button-next hero-swiper__next" aria-label="Slide berikutnya"></div>
                    <!-- Swiper Pagination -->
                    <div class="swiper-pagination hero-swiper__pagination"></div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 2. MAIN LAYOUT (CONTENT + SIDEBAR) -->
    <div class="main-layout">
        <div class="container">
            <div class="main-layout__grid">
                
                <!-- LEFT CONTENT (8 COLS) -->
                <div class="main-content">

                    <!-- STICKY / FEATURED HEADLINE ARTICLE -->
                    @if(isset($featuredArticle))
                    <article class="featured-article">
                        <div class="featured-article__img-wrap">
                            <a href="{{ route('article.show', $featuredArticle->slug) }}" aria-label="{{ $featuredArticle->title }}">
                                <img class="featured-article__img" src="{{ $featuredArticle->image_url }}" alt="{{ $featuredArticle->title }}" onerror="this.src='{{ asset('images/default-news.webp') }}'">
                            </a>
                        </div>
                        <div class="featured-article__body">
                            <a class="featured-article__cat" href="{{ route('category.show', $featuredArticle->category->slug) }}">
                                {{ $featuredArticle->category->name }}
                            </a>
                            <h2 class="featured-article__title">
                                <a href="{{ route('article.show', $featuredArticle->slug) }}">
                                    {{ $featuredArticle->title }}
                                </a>
                            </h2>
                            <p class="featured-article__excerpt">
                                {{ $featuredArticle->excerpt }}
                            </p>
                            <div class="featured-article__meta">
                                <span class="featured-article__author">
                                    <i class="fas fa-user-circle"></i>
                                    <a href="#">{{ $featuredArticle->user->name ?? 'Bima Saputra' }}</a>
                                </span>
                                <span class="featured-article__date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $featuredArticle->published_at ? $featuredArticle->published_at->format('d F Y') : $featuredArticle->created_at->format('d F Y') }}
                                </span>
                            </div>
                        </div>
                    </article>
                    @endif

                    <!-- CATEGORY SECTION: NASIONAL (GRID OF 4-6) -->
                    @if(isset($nasionalArticles) && $nasionalArticles->count() > 0)
                    <div class="section-head">
                        <h2 class="section-head__title">
                            <i class="fas fa-flag"></i> Nasional
                        </h2>
                        @if(isset($nasionalCategory))
                        <a href="{{ route('category.show', $nasionalCategory->slug) }}" class="section-head__more">
                            Lihat Semua <i class="fas fa-chevron-right"></i>
                        </a>
                        @endif
                    </div>

                    <div class="article-grid">
                        @foreach($nasionalArticles as $article)
                            @include('partials.article-card', ['article' => $article])
                        @endforeach
                    </div>
                    @endif

                    <!-- LATEST NEWS FEED -->
                    <div class="section-head">
                        <h2 class="section-head__title">
                            <i class="fas fa-newspaper"></i> Berita Terkini
                        </h2>
                    </div>

                    <div class="article-feed-list" id="articleList">
                        @include('partials.article-feed-items', ['articles' => $latestArticles])
                    </div>

                    <!-- LOAD MORE AJAX BUTTON -->
                    @if($latestArticles->hasMorePages())
                    <div class="load-more-wrap">
                        <button type="button" class="btn-load-more" id="btnLoadMore" data-page="1">
                            <i class="fas fa-sync-alt"></i> Muat Lainnya
                        </button>
                    </div>
                    @endif

                </div>

                <!-- RIGHT SIDEBAR (4 COLS) -->
                @include('partials.sidebar')

            </div>
        </div>
    </div>

</main>
@endsection
