<!-- AI SUMMARY / RINGKASAN ARTIKEL (AI OVERVIEW) -->
@if(isset($article) && count($article->ai_summary_points) > 0)
<div class="ai-summary-card" id="aiSummaryCard">
    <div class="ai-summary-card__header" id="aiSummaryToggle" role="button" tabindex="0" aria-expanded="true" aria-controls="aiSummaryBody">
        <div class="ai-summary-card__title-wrap">
            <span class="ai-summary-card__icon" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z" />
                </svg>
            </span>
            <span class="ai-summary-card__heading">Tampilkan Ringkasan Artikel</span>
        </div>
        <div class="ai-toggle-wrap">
            <label class="ai-toggle-switch" for="aiSummarySwitch" aria-label="Saklar Ringkasan Artikel">
                <input type="checkbox" id="aiSummarySwitch" checked>
                <span class="ai-toggle-switch__slider"></span>
            </label>
        </div>
    </div>

    <div class="ai-summary-card__body" id="aiSummaryBody">
        <h3 class="ai-summary-card__subheading">Ringkasan Artikel</h3>
        <ul class="ai-summary-card__list">
            @foreach($article->ai_summary_points as $point)
            <li class="ai-summary-card__item">
                <span class="ai-summary-card__bullet" aria-hidden="true"></span>
                <span class="ai-summary-card__text">{{ $point }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
