<div class="share-bar {{ $class ?? '' }}">
    <span class="share-bar__label">
        <i class="fas fa-share-alt"></i> Bagikan:
    </span>
    <div class="share-bar__buttons">
        {{-- 1. WhatsApp --}}
        <a href="https://api.whatsapp.com/send?text={{ rawurlencode(($title ?? '') . "\n\n" . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--whatsapp" aria-label="Bagikan ke WhatsApp" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>

        {{-- 2. Telegram --}}
        <a href="https://t.me/share/url?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--telegram" aria-label="Bagikan ke Telegram" title="Telegram">
            <i class="fab fa-telegram-plane"></i>
            <span>Telegram</span>
        </a>

        {{-- 3. Facebook --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--facebook" aria-label="Bagikan ke Facebook" title="Facebook">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </a>

        {{-- 4. Threads --}}
        <a href="https://www.threads.net/intent/post?text={{ rawurlencode(($title ?? '') . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--threads" aria-label="Bagikan ke Threads" title="Threads">
            <i class="fab fa-threads"></i>
            <span>Threads</span>
        </a>

        {{-- 5. Twitter / X --}}
        <a href="https://twitter.com/intent/tweet?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--twitter" aria-label="Bagikan ke Twitter / X" title="Twitter / X">
            <i class="fab fa-x-twitter"></i>
            <span>X / Twitter</span>
        </a>

        {{-- 6. Instagram (Salin link + Buka IG) --}}
        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--instagram js-copy-link" data-url="{{ url()->current() }}" data-feedback="Tautan disalin! Buka Instagram untuk membagikan berita." aria-label="Bagikan ke Instagram" title="Instagram">
            <i class="fab fa-instagram"></i>
            <span>Instagram</span>
        </a>

        {{-- 7. TikTok (Salin link + Buka TikTok) --}}
        <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--tiktok js-copy-link" data-url="{{ url()->current() }}" data-feedback="Tautan disalin! Buka TikTok untuk membagikan berita." aria-label="Bagikan ke TikTok" title="TikTok">
            <i class="fab fa-tiktok"></i>
            <span>TikTok</span>
        </a>

        {{-- 8. Salin Tautan --}}
        <button class="share-btn share-btn--copy js-copy-link" data-url="{{ url()->current() }}" data-feedback="Link tautan artikel berhasil disalin ke clipboard!" type="button" aria-label="Salin Tautan Berita" title="Salin Tautan">
            <i class="fas fa-link"></i>
            <span>Salin Tautan</span>
        </button>
    </div>
</div>
