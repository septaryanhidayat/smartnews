@if ($paginator->hasPages())
    <nav class="custom-pagination" role="navigation" aria-label="Navigasi Halaman">
        <div class="custom-pagination__summary">
            <span>Menampilkan <strong>{{ $paginator->firstItem() ?? 1 }}</strong> - <strong>{{ $paginator->lastItem() ?? $paginator->total() }}</strong> dari <strong>{{ $paginator->total() }}</strong> hasil</span>
        </div>

        <ul class="custom-pagination__list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="custom-pagination__item disabled" aria-disabled="true" aria-label="Sebelumnya">
                    <span class="custom-pagination__link"><i class="fas fa-chevron-left"></i></span>
                </li>
            @else
                <li class="custom-pagination__item">
                    <a class="custom-pagination__link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="custom-pagination__item disabled" aria-disabled="true">
                        <span class="custom-pagination__link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="custom-pagination__item active" aria-current="page">
                                <span class="custom-pagination__link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="custom-pagination__item">
                                <a class="custom-pagination__link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="custom-pagination__item">
                    <a class="custom-pagination__link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="custom-pagination__item disabled" aria-disabled="true" aria-label="Berikutnya">
                    <span class="custom-pagination__link"><i class="fas fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@elseif($paginator->total() > 0)
    <div class="custom-pagination__summary" style="margin-top: 16px; color: var(--admin-muted, #64748b); font-size: 13px;">
        <span>Menampilkan seluruh <strong>{{ $paginator->total() }}</strong> hasil</span>
    </div>
@endif
