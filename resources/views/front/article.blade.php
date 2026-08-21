@extends('layouts.app')

@section('title', $article->title . ' – ' . setting('site_name', 'SmartNews'))
@section('meta_description', Str::limit(strip_tags($article->excerpt ?: $article->content), 160))
@section('meta_keywords', $article->tags->pluck('name')->implode(', ') . ', ' . $article->category->name . ', ' . setting('site_keywords'))
@section('meta_author', $article->user->name ?? setting('site_name', 'SmartNews'))
@section('canonical_url', route('article.show', $article->slug))
@section('og_type', 'article')
@section('og_title', $article->title)
@section('og_image', $article->image_url)

@section('extra_og_tags')
    @if($article->published_at || $article->created_at)
    <meta property="article:published_time" content="{{ optional($article->published_at ?? $article->created_at)->toIso8601String() }}">
    @endif
    @if($article->updated_at)
    <meta property="article:modified_time" content="{{ optional($article->updated_at)->toIso8601String() }}">
    @endif
    <meta property="article:section" content="{{ $article->category->name ?? 'Nasional' }}">
    @foreach($article->tags as $tag)
    <meta property="article:tag" content="{{ $tag->name }}">
    @endforeach
@endsection

@section('schema_jsonld')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "NewsArticle",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ route('article.show', $article->slug) }}"
  },
  "headline": "{{ addslashes($article->title) }}",
  "description": "{{ addslashes(Str::limit(strip_tags($article->excerpt ?: $article->content), 160)) }}",
  "image": [
    "{{ $article->image_url }}"
  ],
  "datePublished": "{{ optional($article->published_at ?? $article->created_at)->toIso8601String() }}",
  "dateModified": "{{ optional($article->updated_at)->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ addslashes($article->user->name ?? setting('site_name', 'SmartNews')) }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ addslashes(setting('site_name', 'SmartNews')) }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ site_logo() }}"
    }
  }
}
</script>
@endsection

@section('content')
<main id="mainContent" class="main-layout single-layout">
    <div class="container">
        <div class="main-layout__grid">

            <!-- MAIN ARTICLE CONTENT -->
            <article class="main-content single-content">
                
                <!-- 1. Breadcrumb -->
                <nav class="breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb__list">
                        <li class="breadcrumb__item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb__sep"><i class="fas fa-chevron-right"></i></li>
                        <li class="breadcrumb__item"><a href="{{ route('category.show', $article->category->slug) }}">{{ $article->category->name }}</a></li>
                        <li class="breadcrumb__sep"><i class="fas fa-chevron-right"></i></li>
                        <li class="breadcrumb__item breadcrumb__item--active">{{ Str::limit($article->title, 40) }}</li>
                    </ol>
                </nav>

                <!-- 2. Category & Title -->
                <a class="single-meta__cat" href="{{ route('category.show', $article->category->slug) }}">
                    {{ $article->category->name }}
                </a>
                <h1 class="single-title">{{ $article->title }}</h1>

                <!-- 3. Article Metadata -->
                <div class="single-meta">
                    <div class="single-meta__left">
                        <span class="single-meta__item">
                            <i class="fas fa-user-circle"></i>
                            <strong>{{ $article->user->name ?? 'Redaksi SmartNews' }}</strong>
                        </span>
                        <span class="single-meta__item">
                            <i class="fas fa-calendar-alt"></i>
                            <time>{{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}</time>
                        </span>
                        <span class="single-meta__item">
                            <i class="fas fa-sync-alt"></i>
                            Diperbarui {{ $article->updated_at->format('H:i') }} WIB
                        </span>
                        <span class="single-meta__item">
                            <i class="fas fa-clock"></i>
                            {{ $article->reading_time }} menit membaca
                        </span>
                    </div>
                </div>

                <!-- 4. Top Share Bar -->
                @include('partials.share-bar', ['title' => $article->title])

                <!-- 5. Featured Media / Video Player -->
                <div class="single-media">
                    @if($article->media_type === 'video' && $article->video_id)
                        <div class="single-video">
                            <div class="single-video-wrapper">
                                <iframe 
                                    src="https://www.youtube.com/embed/{{ $article->video_id }}?rel=0&modestbranding=1" 
                                    title="{{ $article->title }}" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    @else
                        <img class="single-hero-img" src="{{ $article->image_url }}" alt="{{ $article->title }}" onerror="this.src='{{ asset('images/default-news.webp') }}'">
                    @endif

                    @if($article->image_caption || $article->image_source)
                        <div class="single-caption">
                            <span><i class="fas fa-camera"></i> {{ $article->image_caption ?? $article->title }}</span>
                            @if($article->image_source)
                                <span>Sumber: {{ $article->image_source }}</span>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- 6. Font Size Resizer Controls -->
                <div class="font-resizer">
                    <span class="font-resizer__label">Ukuran Teks:</span>
                    <div class="font-resizer__controls">
                        <button class="font-resizer__btn" id="fontDecrease" type="button" aria-label="Perkecil teks">A<sup>−</sup></button>
                        <button class="font-resizer__btn font-resizer__btn--active" id="fontReset" type="button" aria-label="Reset ukuran teks">A</button>
                        <button class="font-resizer__btn" id="fontIncrease" type="button" aria-label="Perbesar teks">A<sup>+</sup></button>
                    </div>
                </div>

                <!-- 7. Article Body -->
                <div class="article-body" id="articleBody">
                    {!! $article->content !!}

                    <!-- Inline Related Article ("Baca Juga") -->
                    @if(isset($inlineRelated))
                    <div class="inline-related">
                        <div class="inline-related__head">
                            <i class="fas fa-newspaper"></i> Baca Juga:
                        </div>
                        <div class="inline-related__title">
                            <a href="{{ route('article.show', $inlineRelated->slug) }}">
                                {{ $inlineRelated->title }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- 8. Tags Cloud -->
                @if($article->tags->count() > 0)
                <div class="article-tags-wrap">
                    <span class="article-tags-label"><i class="fas fa-tags"></i> Topik:</span>
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}" class="widget-tag">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
                @endif

                <!-- 9. Author Box -->
                <div class="author-box">
                    <div class="author-box__avatar">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80" alt="{{ $article->user->name }}">
                    </div>
                    <div class="author-box__body">
                        <div class="author-box__header">
                            <div>
                                <span class="author-box__role">Jurnalis Senior</span>
                                <h4 class="author-box__name">{{ $article->user->name ?? 'Bima Saputra' }}</h4>
                                <span class="author-box__desk">Divisi Redaksi – SmartNews</span>
                            </div>
                        </div>
                        <p class="author-box__desc">
                            Jurnalis berpengalaman di bidang liputan nasional, investigasi, dan kebijakan publik dengan komitmen menyajikan berita faktual, berimbang, dan berintegritas tinggi untuk masyarakat.
                        </p>
                    </div>
                </div>

                <!-- 10. Bottom Share Bar -->
                @include('partials.share-bar', ['title' => $article->title, 'class' => 'share-bar--bottom'])

                <!-- 11. Previous & Next Post Navigation -->
                <nav class="article-nav">
                    @if($prevArticle)
                    <a href="{{ route('article.show', $prevArticle->slug) }}" class="article-nav__item article-nav__item--prev">
                        <div class="article-nav__img-wrap">
                            <img src="{{ $prevArticle->image_url }}" alt="{{ $prevArticle->title }}" onerror="this.src='{{ asset('images/default-news.webp') }}'">
                        </div>
                        <div>
                            <span class="article-nav__dir"><i class="fas fa-arrow-left"></i> Artikel Sebelumnya</span>
                            <h4 class="article-nav__title">{{ $prevArticle->title }}</h4>
                        </div>
                    </a>
                    @else
                    <div></div>
                    @endif

                    @if($nextArticle)
                    <a href="{{ route('article.show', $nextArticle->slug) }}" class="article-nav__item article-nav__item--next">
                        <div class="article-nav__img-wrap">
                            <img src="{{ $nextArticle->image_url }}" alt="{{ $nextArticle->title }}" onerror="this.src='{{ asset('images/default-news.webp') }}'">
                        </div>
                        <div>
                            <span class="article-nav__dir">Artikel Selanjutnya <i class="fas fa-arrow-right"></i></span>
                            <h4 class="article-nav__title">{{ $nextArticle->title }}</h4>
                        </div>
                    </a>
                    @endif
                </nav>

                <!-- 12. Related Articles Grid -->
                @if(isset($relatedArticles) && $relatedArticles->count() > 0)
                <div class="section-head" style="margin-top: 36px;">
                    <h2 class="section-head__title"><i class="fas fa-layer-group"></i> Berita Terkait</h2>
                </div>
                <div class="article-grid">
                    @foreach($relatedArticles as $rel)
                        @include('partials.article-card', ['article' => $rel])
                    @endforeach
                </div>
                @endif

                <!-- 13. Comments Section -->
                <section class="comments-section" id="comments">
                    <div class="section-head">
                        <h2 class="section-head__title">
                            <i class="fas fa-comments"></i> Komentar ({{ $article->approvedComments->count() }})
                        </h2>
                    </div>

                    <div id="commentAlert" style="display: none; padding: 12px 16px; background-color: #d1fae5; color: #065f46; border-radius: var(--radius-md); margin-bottom: 16px; font-weight: 600;"></div>

                    <div class="comment-list" id="commentList">
                        @forelse($article->approvedComments as $comment)
                        <div class="comment-item">
                            <div class="comment-item__head">
                                <span class="comment-item__author"><i class="fas fa-user-circle"></i> {{ $comment->name }}</span>
                                <span class="comment-item__date">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="comment-item__text">{{ $comment->comment }}</p>
                        </div>
                        @empty
                        <p style="color: var(--text-muted); font-size: 14px; font-style: italic;">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</p>
                        @endforelse
                    </div>

                    <!-- Comment Submission Form -->
                    <form class="comment-form" id="commentForm" action="{{ route('comment.store', $article->slug) }}" method="POST">
                        @csrf
                        <h3 class="comment-form__title">Tinggalkan Komentar</h3>
                        <div class="form-group">
                            <label for="commentName">Nama Lengkap *</label>
                            <input type="text" id="commentName" name="name" class="form-control" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label for="commentEmail">Alamat Email *</label>
                            <input type="email" id="commentEmail" name="email" class="form-control" placeholder="nama@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="commentText">Tulis Komentar *</label>
                            <textarea id="commentText" name="comment" class="form-control" placeholder="Sampaikan pendapat atau tanggapan Anda mengenai berita ini..." required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Kirim Komentar
                        </button>
                    </form>
                </section>

            </article>

            <!-- SIDEBAR -->
            @include('partials.sidebar')

        </div>
    </div>
</main>
@endsection
