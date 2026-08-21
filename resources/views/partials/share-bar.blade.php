<div class="share-bar {{ $class ?? '' }}">
    <span class="share-bar__label">
        <i class="fas fa-share-alt"></i> Bagikan:
    </span>
    <div class="share-bar__buttons">
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--facebook" aria-label="Share ke Facebook">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--twitter" aria-label="Share ke Twitter">
            <i class="fab fa-x-twitter"></i>
            <span>Twitter</span>
        </a>
        <a href="https://api.whatsapp.com/send?text={{ urlencode(($title ?? '') . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--whatsapp" aria-label="Share ke WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--telegram" aria-label="Share ke Telegram">
            <i class="fab fa-telegram-plane"></i>
            <span>Telegram</span>
        </a>
        <button class="share-btn share-btn--copy js-copy-link" data-url="{{ url()->current() }}" type="button" aria-label="Salin Link Berita">
            <i class="fas fa-link"></i>
            <span>Salin Link</span>
        </button>
    </div>
</div>
