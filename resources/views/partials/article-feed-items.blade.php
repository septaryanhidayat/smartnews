@foreach($articles as $index => $article)
    @php
        // Varied structure: Every 4th item is styled as a large featured highlight card
        $isHighlight = ($loop->iteration % 4 === 0);
    @endphp

    @if($isHighlight)
    <article class="feed-item feed-item--big">
        <div class="feed-item__img-wrap feed-item__img-wrap--big">
            <a href="{{ route('article.show', $article->slug) }}">
                <img class="feed-item__img feed-item__img--big" src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy" onerror="this.src='{{ asset('images/default-news.webp') }}'">
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
        <div class="feed-item__body feed-item__body--big">
            <div>
                <a class="feed-item__cat" href="{{ route('category.show', $article->category->slug) }}">
                    {{ $article->category->name }}
                </a>
                <h3 class="feed-item__title feed-item__title--big">
                    <a href="{{ route('article.show', $article->slug) }}">
                        {{ $article->title }}
                    </a>
                </h3>
                @if(!empty($article->excerpt))
                <p class="feed-item__excerpt feed-item__excerpt--big">
                    {{ $article->excerpt }}
                </p>
                @endif
            </div>
            <div class="feed-item__meta">
                <span><i class="fas fa-user-circle"></i> {{ $article->user->name ?? 'Redaksi' }}</span>
                <span><i class="fas fa-calendar-alt"></i> {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}</span>
                @if($article->reading_time)
                <span><i class="fas fa-clock"></i> {{ $article->reading_time }} menit baca</span>
                @endif
            </div>
        </div>
    </article>
    @else
    <article class="feed-item">
        <div class="feed-item__img-wrap">
            <a href="{{ route('article.show', $article->slug) }}">
                <img class="feed-item__img" src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy" onerror="this.src='{{ asset('images/default-news.webp') }}'">
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
    @endif

    {{-- Optimal In-Feed Ad Injection after 3rd item --}}
    @if($loop->iteration === 3 && function_exists('ad_render'))
        {!! ad_render('home_feed') !!}
    @endif
@endforeach
