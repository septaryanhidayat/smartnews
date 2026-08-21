<div class="share-bar {{ $class ?? '' }}">
    <span class="share-bar__label">
        <i class="fas fa-share-alt"></i> Bagikan:
    </span>
    <div class="share-bar__buttons">
        <a href="https://api.whatsapp.com/send?text={{ rawurlencode(($title ?? '') . "\n" . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--whatsapp" aria-label="Share ke WhatsApp" title="Bagikan ke WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--facebook" aria-label="Share ke Facebook" title="Bagikan ke Facebook">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </a>
        <a href="https://twitter.com/intent/tweet?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--twitter" aria-label="Share ke Twitter" title="Bagikan ke Twitter / X">
            <i class="fab fa-x-twitter"></i>
            <span>Twitter</span>
        </a>
        <a href="https://t.me/share/url?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($title ?? '') }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--telegram" aria-label="Share ke Telegram" title="Bagikan ke Telegram">
            <i class="fab fa-telegram-plane"></i>
            <span>Telegram</span>
        </a>
        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="share-btn share-btn--linkedin" aria-label="Share ke LinkedIn" title="Bagikan ke LinkedIn" style="background-color: #0a66c2;">
            <i class="fab fa-linkedin-in"></i>
            <span>LinkedIn</span>
        </a>
        <button class="share-btn share-btn--copy js-copy-link" data-url="{{ url()->current() }}" type="button" aria-label="Salin Link Berita" title="Salin Tautan">
            <i class="fas fa-link"></i>
            <span>Salin Link</span>
        </button>
    </div>
</div>
