@extends('layouts.app')

@section('title', 'Hasil Pencarian: "' . $query . '" – Digiterkini')

@section('content')
<main id="mainContent" class="main-layout">
    <div class="container">
        
        <!-- Search Header -->
        <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 24px 28px; margin-bottom: 28px;">
            <nav class="breadcrumb" style="margin-bottom: 8px;">
                <ol class="breadcrumb__list">
                    <li class="breadcrumb__item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb__sep"><i class="fas fa-chevron-right"></i></li>
                    <li class="breadcrumb__item breadcrumb__item--active">Pencarian</li>
                </ol>
            </nav>
            <h1 style="font-size: 24px; font-weight: 800; color: var(--text-main); margin-bottom: 6px;">
                <i class="fas fa-search" style="color: var(--color-primary);"></i> Hasil Pencarian: "{{ $query }}"
            </h1>
            <p style="color: var(--text-muted); font-size: 14px;">
                Ditemukan {{ $articles->total() }} berita yang relevan dengan kata kunci tersebut.
            </p>
        </div>

        <div class="main-layout__grid">
            <!-- Main Content -->
            <div class="main-content">
                <div class="article-feed-list">
                    @forelse($articles as $article)
                    <article class="feed-item">
                        <div class="feed-item__img-wrap">
                            <a href="{{ route('article.show', $article->slug) }}">
                                <img class="feed-item__img" src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy">
                            </a>
                            @if($article->media_type === 'video')
                                <div class="media-badge media-badge--video">
                                    <i class="fas fa-play"></i> <span>{{ $article->media_badge ?? 'Video' }}</span>
                                </div>
                            @elseif($article->media_type === 'photo')
                                <div class="media-badge media-badge--photo">
                                    <i class="fas fa-camera"></i> <span>{{ $article->media_badge ?? 'Foto' }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="feed-item__body">
                            <div>
                                <a class="feed-item__cat" href="{{ route('category.show', $article->category->slug) }}">
                                    {{ $article->category->name }}
                                </a>
                                <h3 class="feed-item__title">
                                    <a href="{{ route('article.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p class="feed-item__excerpt">
                                    {{ $article->excerpt }}
                                </p>
                            </div>
                            <div class="feed-item__meta">
                                <span><i class="fas fa-user-circle"></i> {{ $article->user->name ?? 'Redaksi' }}</span>
                                <span><i class="fas fa-calendar-alt"></i> {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}</span>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 40px; text-align: center;">
                        <i class="fas fa-search-minus" style="font-size: 36px; color: var(--text-light); margin-bottom: 12px;"></i>
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 6px;">Tidak ada berita yang ditemukan</h3>
                        <p style="color: var(--text-muted); font-size: 14px;">Silakan coba dengan kata kunci lain yang lebih umum.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div style="margin-top: 28px;">
                    {{ $articles->appends(['q' => $query])->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            @include('partials.sidebar')
        </div>
    </div>
</main>
@endsection
