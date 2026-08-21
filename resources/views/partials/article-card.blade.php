<article class="article-card">
    <div class="article-card__img-wrap">
        <a href="{{ route('article.show', $article->slug) }}" aria-label="{{ $article->title }}">
            <img class="article-card__img" src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy">
        </a>
        <a class="article-card__cat" href="{{ route('category.show', $article->category->slug) }}">
            {{ $article->category->name }}
        </a>
        @if($article->media_type === 'video')
            <div class="media-badge media-badge--video">
                <i class="fas fa-play"></i>
                <span>{{ $article->media_badge ?? 'Video' }}</span>
            </div>
        @elseif($article->media_type === 'photo')
            <div class="media-badge media-badge--photo">
                <i class="fas fa-camera"></i>
                <span>{{ $article->media_badge ?? 'Foto' }}</span>
            </div>
        @endif
    </div>
    <div class="article-card__body">
        <h3 class="article-card__title">
            <a href="{{ route('article.show', $article->slug) }}">
                {{ $article->title }}
            </a>
        </h3>
        <span class="article-card__date">
            <i class="fas fa-clock"></i> {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}
        </span>
    </div>
</article>
