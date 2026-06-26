@extends('layouts.app')

@section('content')

<style>
    /* ============================================
       INTERVIEW Q&A PREP HUB — LANDING PAGE
       Self-contained styles, guaranteed to render
    ============================================= */
    .ih-page { font-family: inherit; }

    /* ===== HEADER ===== */
    .ih-header { margin-bottom: 28px; }
    .ih-eyebrow {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.15em;
        color: #7e22ce;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .ih-title {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 6px 0;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .ih-subtitle {
        font-size: 14px;
        color: #64748b;
        margin: 0;
        max-width: 640px;
    }

    /* ===== SEARCH BAR ===== */
    .ih-search-wrap {
        position: relative;
        max-width: 520px;
        margin-bottom: 32px;
    }
    .ih-search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }
    .ih-search-input {
        width: 100%;
        height: 48px;
        padding: 0 44px 0 44px;
        font-size: 14px;
        color: #334155;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .ih-search-input::placeholder { color: #94a3b8; }
    .ih-search-input:focus {
        border-color: #c084fc;
        box-shadow: 0 0 0 3px rgba(192, 132, 252, 0.15);
    }
    .ih-search-clear {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 26px;
        height: 26px;
        border: none;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        transition: all 0.2s;
    }
    .ih-search-clear:hover { background: #e2e8f0; color: #334155; }
    .ih-search-clear.is-visible { display: flex; }

    /* ===== SECTION BLOCK (shared) ===== */
    .ih-section {
        margin-bottom: 32px;
    }
    .ih-section.is-hidden { display: none; }
    .ih-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }
    .ih-section-title-wrap { display: flex; flex-direction: column; gap: 2px; }
    .ih-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.01em;
    }
    .ih-section-sub {
        font-size: 12px;
        color: #94a3b8;
        margin: 0;
    }
    .ih-section-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 28px;
        padding: 0 12px;
        background: #faf5ff;
        color: #7e22ce;
        border: 1px solid #e9d5ff;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* ===== TECHNOLOGY BADGES SECTION ===== */
    .ih-tech-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 12px;
    }

    .ih-tech-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        transition: all 0.25s ease;
        cursor: default;
    }
    .ih-tech-card.is-hidden { display: none; }
    .ih-tech-card:hover {
        border-color: #e9d5ff;
        background: linear-gradient(135deg, #fff 0%, #faf5ff 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px -4px rgba(126, 34, 206, 0.1);
    }
    .ih-tech-icon {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%);
        color: #7e22ce;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        border: 1px solid #f3e8ff;
        transition: transform 0.25s;
    }
    .ih-tech-card:hover .ih-tech-icon {
        transform: scale(1.08) rotate(-3deg);
    }
    .ih-tech-info { display: flex; flex-direction: column; min-width: 0; }
    .ih-tech-name {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ih-tech-count {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        margin-top: 2px;
    }
    .ih-tech-count strong { color: #7e22ce; font-weight: 700; }

    .ih-tech-empty {
        grid-column: 1 / -1;
        padding: 24px;
        text-align: center;
        font-size: 12px;
        font-style: italic;
        color: #94a3b8;
    }

    /* ===== TRACKS GRID ===== */
    .ih-tracks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    .ih-track-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .ih-track-card.is-hidden { display: none; }
    .ih-track-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #7e22ce 0%, #db2777 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }
    .ih-track-card:hover {
        border-color: #d8b4fe;
        transform: translateY(-4px);
        box-shadow: 0 20px 28px -6px rgba(126, 34, 206, 0.12);
    }
    .ih-track-card:hover::before { transform: scaleX(1); }

    .ih-track-head {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 14px;
    }
    .ih-track-icon {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%);
        color: #7e22ce;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        border: 1px solid #f3e8ff;
        transition: all 0.3s;
    }
    .ih-track-card:hover .ih-track-icon {
        background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%);
        color: #fff;
        border-color: transparent;
    }
    .ih-track-head-text { display: flex; flex-direction: column; gap: 4px; min-width: 0; }
    .ih-track-label {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.12em;
        color: #7e22ce;
        text-transform: uppercase;
    }
    .ih-track-name {
        font-size: 17px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
        margin: 0;
        transition: color 0.2s;
    }
    .ih-track-card:hover .ih-track-name { color: #7e22ce; }

    .ih-track-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
        margin: 0 0 20px 0;
        flex-grow: 1;
    }

    .ih-track-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .ih-track-meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
    }
    .ih-track-meta-label {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
    }
    .ih-track-meta-value {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }
    .ih-track-meta-value strong { color: #7e22ce; }

    .ih-track-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 40px;
        padding: 0 18px;
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 7px -1px rgba(126, 34, 206, 0.25);
        transition: all 0.2s;
        white-space: nowrap;
    }
    .ih-track-cta:hover {
        opacity: 0.92;
        color: #fff;
        transform: translateY(-1px);
    }
    .ih-track-cta i { font-size: 10px; }

    /* ===== EMPTY STATE ===== */
    .ih-empty {
        grid-column: 1 / -1;
        background: #fff;
        border: 1px dashed #e2e8f0;
        border-radius: 16px;
        padding: 56px 32px;
        text-align: center;
    }
    .ih-empty-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 16px;
        background: #faf5ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d8b4fe;
        font-size: 28px;
    }
    .ih-empty h6 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    .ih-empty p {
        font-size: 13px;
        color: #64748b;
        max-width: 380px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ===== NO RESULTS (search) ===== */
    .ih-no-results {
        display: none;
        background: #fff;
        border: 1px dashed #e2e8f0;
        border-radius: 16px;
        padding: 48px 32px;
        text-align: center;
    }
    .ih-no-results.is-visible { display: block; }
    .ih-no-results-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 14px;
        background: #faf5ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d8b4fe;
        font-size: 24px;
    }
    .ih-no-results h6 {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px 0;
    }
    .ih-no-results p {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    .ih-no-results strong { color: #7e22ce; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 640px) {
        .ih-title { font-size: 24px; }
        .ih-tech-grid { grid-template-columns: 1fr 1fr; }
        .ih-tracks-grid { grid-template-columns: 1fr; }
        .ih-track-footer { flex-direction: column; align-items: stretch; gap: 14px; }
        .ih-track-cta { width: 100%; }
    }
</style>

<div class="ih-page">

    {{-- ===== HEADER ===== --}}
    <div class="ih-header">
        <span class="ih-eyebrow">Interview Preparation</span>
        <h2 class="ih-title">Interview Q&amp;A Prep Hub</h2>
        <p class="ih-subtitle">Master your technical interviews with curated questions, detailed explanations, and model answers built by industry experts.</p>
    </div>

    @if(session('error'))
        <div class="ih-alert">
            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ session('error') }}
        </div>
    @endif

    {{-- ===== SEARCH BAR ===== --}}
    <div class="ih-search-wrap">
        <span class="ih-search-icon"><i class="fas fa-search"></i></span>
        <input type="text" id="ihSearchInput" class="ih-search-input" placeholder="Search technologies or tracks..." autocomplete="off">
        <button type="button" id="ihSearchClear" class="ih-search-clear" aria-label="Clear search">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- ===== TECHNOLOGIES SECTION ===== --}}
    <section class="ih-section" id="ihTechSection">
        <div class="ih-section-head">
            <div class="ih-section-title-wrap">
                <h5 class="ih-section-title">Technologies Available</h5>
                <p class="ih-section-sub">Topic coverage across your active prep tracks</p>
            </div>
            @if(count($techCounts) > 0)
                <span class="ih-section-count">
                    <i class="fas fa-layer-group" style="font-size: 10px;"></i>
                    {{ count($techCounts) }} {{ Str::plural('Technology', count($techCounts)) }}
                </span>
            @endif
        </div>

        <div class="ih-tech-grid">
            @forelse($techCounts as $tech => $count)
                <div class="ih-tech-card" data-search="{{ Str::lower($tech) }}">
                    <div class="ih-tech-icon"><i class="fas fa-code"></i></div>
                    <div class="ih-tech-info">
                        <span class="ih-tech-name">{{ $tech }}</span>
                        <span class="ih-tech-count"><strong>{{ $count }}</strong> {{ Str::plural('Question', $count) }}</span>
                    </div>
                </div>
            @empty
                <div class="ih-tech-empty">No technologies defined yet.</div>
            @endforelse
        </div>
    </section>

    {{-- ===== PREPARATION TRACKS SECTION ===== --}}
    <section class="ih-section" id="ihTracksSection">
        <div class="ih-section-head">
            <div class="ih-section-title-wrap">
                <h5 class="ih-section-title">Preparation Tracks</h5>
                <p class="ih-section-sub">Choose a track to start practicing</p>
            </div>
            @if(count($categories) > 0)
                <span class="ih-section-count">
                    <i class="fas fa-bookmark" style="font-size: 10px;"></i>
                    {{ count($categories) }} {{ Str::plural('Track', count($categories)) }}
                </span>
            @endif
        </div>

        <div class="ih-tracks-grid">
            @forelse($categories as $category)
                <div class="ih-track-card" data-search="{{ Str::lower($category->name) }}">
                    <div>
                        <div class="ih-track-head">
                            <div class="ih-track-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="ih-track-head-text">
                                <span class="ih-track-label">Active Track</span>
                                <h6 class="ih-track-name">{{ $category->name }}</h6>
                            </div>
                        </div>

                        <p class="ih-track-desc">
                            Practice interview Q&amp;As for {{ $category->name }}. Review complete explanations, structural tips, and best practices.
                        </p>
                    </div>

                    <div class="ih-track-footer">
                        <div class="ih-track-meta">
                            <span class="ih-track-meta-label">Questions</span>
                            <span class="ih-track-meta-value"><strong>{{ $category->interview_questions_count }}</strong> curated</span>
                        </div>
                        <a href="{{ route('customer.interview-questions.category', $category->id) }}" class="ih-track-cta">
                            Practice Track <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="ih-empty">
                    <div class="ih-empty-icon"><i class="fas fa-question-circle"></i></div>
                    <h6>No tracks available</h6>
                    <p>You don't have access to any interview prep tracks under your active memberships. Contact support to upgrade your plan and unlock prep tracks.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ===== NO SEARCH RESULTS ===== --}}
    <div class="ih-no-results" id="ihNoResults">
        <div class="ih-no-results-icon"><i class="fas fa-search"></i></div>
        <h6>No matches found</h6>
        <p>Nothing matches "<strong id="ihNoResultsTerm"></strong>". Try a different keyword.</p>
    </div>

</div>

@endsection

@push('scripts')
<script>
    (function () {
        var input      = document.getElementById('ihSearchInput');
        var clearBtn   = document.getElementById('ihSearchClear');
        var techCards  = Array.prototype.slice.call(document.querySelectorAll('.ih-tech-card'));
        var trackCards = Array.prototype.slice.call(document.querySelectorAll('.ih-track-card'));
        var techSection   = document.getElementById('ihTechSection');
        var tracksSection = document.getElementById('ihTracksSection');
        var noResults     = document.getElementById('ihNoResults');
        var noResultsTerm = document.getElementById('ihNoResultsTerm');

        function applyFilter() {
            var term = input.value.trim().toLowerCase();

            clearBtn.classList.toggle('is-visible', term.length > 0);

            var techVisible = 0;
            techCards.forEach(function (card) {
                var match = card.getAttribute('data-search').indexOf(term) !== -1;
                card.classList.toggle('is-hidden', !match);
                if (match) techVisible++;
            });

            var trackVisible = 0;
            trackCards.forEach(function (card) {
                var match = card.getAttribute('data-search').indexOf(term) !== -1;
                card.classList.toggle('is-hidden', !match);
                if (match) trackVisible++;
            });

            // Hide a whole section when it has cards but none match
            if (techSection) {
                techSection.classList.toggle('is-hidden', techCards.length > 0 && techVisible === 0);
            }
            if (tracksSection) {
                tracksSection.classList.toggle('is-hidden', trackCards.length > 0 && trackVisible === 0);
            }

            // Global "no results" message
            var totalCards = techCards.length + trackCards.length;
            var totalVisible = techVisible + trackVisible;
            if (totalCards > 0 && totalVisible === 0 && term.length > 0) {
                noResultsTerm.textContent = input.value.trim();
                noResults.classList.add('is-visible');
            } else {
                noResults.classList.remove('is-visible');
            }
        }

        input.addEventListener('input', applyFilter);
        clearBtn.addEventListener('click', function () {
            input.value = '';
            input.focus();
            applyFilter();
        });
    })();
</script>
@endpush