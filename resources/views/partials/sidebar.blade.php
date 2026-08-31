<aside class="sidebar">

    <!-- 1. Widget: Trending (Ranked 1 - 5) -->
    @if(isset($popularArticles) && $popularArticles->count() > 0)
    <section class="sidebar-widget widget-popular">
        <h3 class="widget-title">
            <i class="fas fa-fire"></i> {{ strtoupper(__('messages.popular_news')) }}
        </h3>
        <div class="widget-popular__list">
            @foreach($popularArticles as $index => $pop)
            <div class="popular-item">
                <span class="popular-item__rank {{ $index < 3 ? 'popular-item__rank--top' : '' }}">
                    {{ $index + 1 }}
                </span>
                <div class="popular-item__body">
                    <a class="popular-item__cat" href="{{ route('category.show', $pop->category->slug) }}">
                        {{ $pop->category->name }}
                    </a>
                    <h4 class="popular-item__title">
                        <a href="{{ route('article.show', $pop->slug) }}">
                            {{ $pop->title }}
                        </a>
                    </h4>
                    <span class="popular-item__date">
                        <i class="fas fa-clock"></i> {{ $pop->published_at ? $pop->published_at->format('d F Y') : $pop->created_at->format('d F Y') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- OPTIONAL SIDEBAR SPONSOR BANNER AD -->
    {!! ad_render('sidebar', 'ad-slot--sidebar') !!}

    <!-- 2. Widget: Berita Terbaru -->
    @if(isset($sidebarLatest) && $sidebarLatest->count() > 0)
    <section class="sidebar-widget widget-recent">
        <h3 class="widget-title">
            <i class="fas fa-bolt"></i> {{ strtoupper(__('messages.latest_news')) }}
        </h3>
        <div class="widget-recent__list">
            @foreach($sidebarLatest as $rec)
            <div class="cat-item">
                <div class="cat-item__img-wrap">
                    <a href="{{ route('article.show', $rec->slug) }}">
                        <img class="cat-item__img" src="{{ $rec->image_url }}" alt="{{ $rec->title }}" loading="lazy" decoding="async" onerror="this.src='{{ asset('images/default-news.webp') }}'">
                    </a>
                </div>
                <div class="cat-item__body">
                    <a class="cat-item__cat" href="{{ route('category.show', $rec->category->slug) }}">
                        {{ $rec->category->name }}
                    </a>
                    <h4 class="cat-item__title">
                        <a href="{{ route('article.show', $rec->slug) }}">
                            {{ $rec->title }}
                        </a>
                    </h4>
                    <span class="cat-item__date">
                        <i class="fas fa-clock"></i> {{ $rec->published_at ? $rec->published_at->format('d F Y') : $rec->created_at->format('d F Y') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- 3. Widget: Topik Populer (Tags Cloud) -->
    @if(isset($popularTags) && $popularTags->count() > 0)
    <section class="sidebar-widget widget-tags">
        <h3 class="widget-title">
            <i class="fas fa-tags"></i> {{ strtoupper(__('messages.trending_topics')) }}
        </h3>
        <div class="widget-tags__cloud">
            @foreach($popularTags as $tag)
            <a href="{{ route('tag.show', $tag->slug) }}" class="widget-tag">
                #{{ $tag->name }}
            </a>
            @endforeach
        </div>
    </section>
    @endif

</aside>
