<div class="article-share-card {{ $class ?? '' }}">
    <div class="article-share-card__head">
        <div class="article-share-card__title">
            <i class="fas fa-share-alt"></i>
            <span>Bagikan Artikel Ini</span>
        </div>
        <span class="article-share-card__hint">Pilih platform media sosial favorit Anda</span>
    </div>
    <div class="article-share-card__grid">
        {{-- 1. WhatsApp --}}
        <a href="https://api.whatsapp.com/send?text={{ rawurlencode(($title ?? '') . "\n\n" . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-grid-btn share-grid-btn--wa" aria-label="Bagikan ke WhatsApp" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>

        {{-- 2. Telegram --}}
        <a href="https://t.me/share/url?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-grid-btn share-grid-btn--tg" aria-label="Bagikan ke Telegram" title="Telegram">
            <i class="fab fa-telegram-plane"></i>
            <span>Telegram</span>
        </a>

        {{-- 3. Facebook --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-grid-btn share-grid-btn--fb" aria-label="Bagikan ke Facebook" title="Facebook">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </a>

        {{-- 4. Threads --}}
        <a href="https://www.threads.net/intent/post?text={{ rawurlencode(($title ?? '') . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-grid-btn share-grid-btn--threads" aria-label="Bagikan ke Threads" title="Threads">
            <i class="fab fa-threads"></i>
            <span>Threads</span>
        </a>

        {{-- 5. Twitter / X --}}
        <a href="https://twitter.com/intent/tweet?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-grid-btn share-grid-btn--x" aria-label="Bagikan ke Twitter / X" title="Twitter / X">
            <i class="fab fa-x-twitter"></i>
            <span>X / Twitter</span>
        </a>

        {{-- 6. Instagram --}}
        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="share-grid-btn share-grid-btn--ig js-copy-link" data-url="{{ url()->current() }}" data-feedback="Tautan disalin! Silakan bagikan di Instagram." aria-label="Bagikan ke Instagram" title="Instagram">
            <i class="fab fa-instagram"></i>
            <span>Instagram</span>
        </a>

        {{-- 7. TikTok --}}
        <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer" class="share-grid-btn share-grid-btn--tiktok js-copy-link" data-url="{{ url()->current() }}" data-feedback="Tautan disalin! Silakan bagikan di TikTok." aria-label="Bagikan ke TikTok" title="TikTok">
            <i class="fab fa-tiktok"></i>
            <span>TikTok</span>
        </a>

        {{-- 8. Salin Tautan --}}
        <button class="share-grid-btn share-grid-btn--copy js-copy-link" data-url="{{ url()->current() }}" data-feedback="Link tautan artikel berhasil disalin ke clipboard!" type="button" aria-label="Salin Tautan Berita" title="Salin Tautan">
            <i class="fas fa-link"></i>
            <span>Salin Tautan</span>
        </button>
    </div>
</div>
