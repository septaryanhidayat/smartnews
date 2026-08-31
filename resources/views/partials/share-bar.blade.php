<div class="article-share-strip {{ $class ?? '' }}">
    <div class="article-share-strip__label">
        <i class="fas fa-share-alt"></i>
        <span>Bagikan:</span>
    </div>
    <div class="article-share-strip__btns">
        {{-- 1. WhatsApp --}}
        <a href="https://api.whatsapp.com/send?text={{ rawurlencode(($title ?? '') . "\n\n" . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-icon-btn share-icon-btn--wa" title="Bagikan ke WhatsApp" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>

        {{-- 2. Telegram --}}
        <a href="https://t.me/share/url?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-icon-btn share-icon-btn--tg" title="Bagikan ke Telegram" aria-label="Telegram">
            <i class="fab fa-telegram-plane"></i>
        </a>

        {{-- 3. Facebook --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-icon-btn share-icon-btn--fb" title="Bagikan ke Facebook" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>

        {{-- 4. Threads --}}
        <a href="https://www.threads.net/intent/post?text={{ rawurlencode(($title ?? '') . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-icon-btn share-icon-btn--threads" title="Bagikan ke Threads" aria-label="Threads">
            <i class="fab fa-threads"></i>
        </a>

        {{-- 5. Twitter / X --}}
        <a href="https://twitter.com/intent/tweet?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-icon-btn share-icon-btn--x" title="Bagikan ke X / Twitter" aria-label="X / Twitter">
            <i class="fab fa-x-twitter"></i>
        </a>

        {{-- 6. Instagram --}}
        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="share-icon-btn share-icon-btn--ig js-copy-link" data-url="{{ url()->current() }}" data-feedback="Tautan disalin! Silakan bagikan di Instagram." title="Bagikan ke Instagram" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
        </a>

        {{-- 7. TikTok --}}
        <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer" class="share-icon-btn share-icon-btn--tiktok js-copy-link" data-url="{{ url()->current() }}" data-feedback="Tautan disalin! Silakan bagikan di TikTok." title="Bagikan ke TikTok" aria-label="TikTok">
            <i class="fab fa-tiktok"></i>
        </a>

        {{-- 8. Salin Tautan --}}
        <button class="share-icon-btn share-icon-btn--copy js-copy-link" data-url="{{ url()->current() }}" data-feedback="Link tautan artikel berhasil disalin ke clipboard!" type="button" title="Salin Tautan Artikel" aria-label="Salin Tautan">
            <i class="fas fa-link"></i>
        </button>
    </div>
</div>
