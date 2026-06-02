@extends('layouts.app')

@section('content')

<style>
    /* ============================================
       INTERVIEW Q&A PAGE STYLES
       Self-contained — guaranteed to render
    ============================================= */
    .iq-page { font-family: inherit; }

    /* ===== HEADER ===== */
    .iq-header { margin-bottom: 28px; }
    .iq-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #7e22ce;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 10px;
        transition: color 0.2s;
    }
    .iq-back:hover { color: #581c87; }
    .iq-back i { font-size: 10px; }

    .iq-title {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 6px 0;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .iq-subtitle {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    /* ===== FILTER TOOLBAR ===== */
    .iq-toolbar {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }
    .iq-toolbar-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }
    .iq-search {
        flex: 1 1 280px;
        position: relative;
    }
    .iq-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }
    .iq-input, .iq-select {
        width: 100%;
        height: 42px;
        padding: 0 14px;
        font-size: 14px;
        color: #334155;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .iq-input { padding-left: 38px; }
    .iq-input:focus, .iq-select:focus {
        border-color: #c084fc;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(192, 132, 252, 0.15);
    }
    .iq-select-wrap {
        flex: 0 1 180px;
        min-width: 160px;
    }
    .iq-clear {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 42px;
        padding: 0 16px;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .iq-clear:hover {
        color: #be185d;
        border-color: #fbcfe8;
        background: #fdf2f8;
    }

    /* ===== ACTIVE FILTERS ===== */
    .iq-active-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .iq-active-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
    }
    .iq-active-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 26px;
        padding: 0 10px;
        background: #faf5ff;
        color: #7e22ce;
        border: 1px solid #e9d5ff;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    /* ===== RESULTS COUNT ===== */
    .iq-results-count {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 16px;
    }
    .iq-results-count strong { color: #334155; font-weight: 700; }

    /* ===== QUESTION LIST ===== */
    .iq-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 24px;
    }

    /* ===== ACCORDION CARD ===== */
    .iq-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.25s ease;
    }
    .iq-card:hover {
        border-color: #e9d5ff;
        box-shadow: 0 8px 20px -4px rgba(126, 34, 206, 0.08);
    }
    .iq-card[open] {
        border-color: #d8b4fe;
        box-shadow: 0 12px 28px -6px rgba(126, 34, 206, 0.12);
    }

    .iq-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 20px 24px;
        cursor: pointer;
        user-select: none;
        list-style: none;
    }
    .iq-summary::-webkit-details-marker { display: none; }
    .iq-summary::marker { display: none; }

    .iq-summary-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        flex: 1;
        min-width: 0;
    }

    /* Difficulty badges */
    .iq-badge {
        display: inline-flex;
        align-items: center;
        height: 24px;
        padding: 0 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: 1px solid;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .iq-badge-easy { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
    .iq-badge-medium { background: #fffbeb; color: #b45309; border-color: #fde68a; }
    .iq-badge-hard { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }

    /* Tech badge */
    .iq-tech-badge {
        display: inline-flex;
        align-items: center;
        height: 24px;
        padding: 0 10px;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .iq-question-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        line-height: 1.4;
        flex: 1;
        min-width: 200px;
    }
    .iq-card:hover .iq-question-title,
    .iq-card[open] .iq-question-title {
        color: #7e22ce;
    }

    /* Chevron */
    .iq-chevron {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f8fafc;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 11px;
        transition: all 0.3s ease;
    }
    .iq-card[open] .iq-chevron {
        background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%);
        color: #fff;
        transform: rotate(180deg);
    }

    /* ===== ACCORDION BODY ===== */
    .iq-body {
        padding: 0 24px 24px 24px;
        border-top: 1px solid #f1f5f9;
    }
    .iq-section {
        margin-top: 20px;
    }
    .iq-section:first-child { margin-top: 24px; }

    .iq-section-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 8px;
    }
    .iq-label-q { color: #7e22ce; }
    .iq-label-a { color: #475569; }
    .iq-label-tip { color: #7e22ce; }

    .iq-question-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 16px 18px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.6;
    }
    .iq-answer-text {
        font-size: 14px;
        color: #475569;
        line-height: 1.7;
    }
    .iq-tip-box {
        background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%);
        border: 1px solid #f3e8ff;
        border-radius: 12px;
        padding: 18px;
    }
    .iq-tip-box p {
        font-size: 14px;
        color: #475569;
        line-height: 1.7;
        margin: 0;
    }

    /* ===== EMPTY STATE ===== */
    .iq-empty {
        background: #fff;
        border: 1px dashed #e2e8f0;
        border-radius: 16px;
        padding: 56px 32px;
        text-align: center;
    }
    .iq-empty-icon {
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
    .iq-empty h6 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    .iq-empty p {
        font-size: 13px;
        color: #64748b;
        max-width: 360px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ===== PAGINATION ===== */
    .iq-pagination-wrap {
        padding: 14px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        display: flex;
        justify-content: center;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
    }
    .iq-pagination-wrap .pagination {
        margin: 0;
        gap: 4px;
        display: flex;
        align-items: center;
    }
    .iq-pagination-wrap .page-link {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px !important;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border: none;
        background: transparent;
    }
    .iq-pagination-wrap .page-link:hover {
        background: #f8fafc;
        color: #7e22ce;
    }
    .iq-pagination-wrap .page-item.active .page-link {
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        color: #fff;
        box-shadow: 0 4px 7px -1px rgba(126, 34, 206, 0.25);
    }
    .iq-pagination-wrap .page-item.disabled .page-link {
        color: #cbd5e1;
        background: transparent;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 640px) {
        .iq-summary { padding: 16px 18px; }
        .iq-body { padding: 0 18px 20px 18px; }
        .iq-question-title { font-size: 14px; min-width: 100%; }
        .iq-toolbar-row { gap: 10px; }
    }
</style>

<div class="iq-page">

    {{-- ===== HEADER ===== --}}
    <div class="iq-header">
        <a href="{{ route('customer.interview-questions') }}" class="iq-back">
            <i class="fas fa-arrow-left"></i> Back to Prep Hub
        </a>
        <h2 class="iq-title">{{ $category->name }} Q&amp;As</h2>
        <p class="iq-subtitle">Browse curated interview questions, professional tips, and step-by-step explanations.</p>
    </div>

    {{-- ===== FILTER TOOLBAR ===== --}}
    <div class="iq-toolbar">
        <form action="{{ route('customer.interview-questions.category', $category->id) }}" method="GET" id="categoryFilterForm">
            <div class="iq-toolbar-row">

                {{-- Search --}}
                <div class="iq-search">
                    <span class="iq-search-icon"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" id="search"
                           value="{{ request('search') }}"
                           placeholder="Search questions..."
                           class="iq-input">
                </div>

                {{-- Technology --}}
                <div class="iq-select-wrap">
                    <select name="technology" id="technology" onchange="this.form.submit()" class="iq-select">
                        <option value="">All Technologies</option>
                        @foreach($technologies as $tech)
                            <option value="{{ $tech }}" {{ request('technology') === $tech ? 'selected' : '' }}>{{ $tech }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Difficulty --}}
                <div class="iq-select-wrap" style="flex: 0 1 160px;">
                    <select name="difficulty" id="difficulty" onchange="this.form.submit()" class="iq-select">
                        <option value="">All Difficulties</option>
                        <option value="Easy" {{ request('difficulty') === 'Easy' ? 'selected' : '' }}>Easy</option>
                        <option value="Medium" {{ request('difficulty') === 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="Hard" {{ request('difficulty') === 'Hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                </div>

                {{-- Clear button --}}
                @if(request()->anyFilled(['search', 'technology', 'difficulty']))
                    <a href="{{ route('customer.interview-questions.category', $category->id) }}" class="iq-clear">
                        <i class="fas fa-times" style="font-size: 10px;"></i> Clear
                    </a>
                @endif
            </div>

            {{-- Active filters chips --}}
            @if(request()->anyFilled(['search', 'technology', 'difficulty']))
                <div class="iq-active-bar">
                    <span class="iq-active-label">Active:</span>
                    @if(request('search'))
                        <span class="iq-active-chip">
                            <i class="fas fa-search" style="font-size: 9px;"></i> "{{ request('search') }}"
                        </span>
                    @endif
                    @if(request('technology'))
                        <span class="iq-active-chip">
                            <i class="fas fa-code" style="font-size: 9px;"></i> {{ request('technology') }}
                        </span>
                    @endif
                    @if(request('difficulty'))
                        <span class="iq-active-chip">
                            <i class="fas fa-signal" style="font-size: 9px;"></i> {{ request('difficulty') }}
                        </span>
                    @endif
                </div>
            @endif
        </form>
    </div>

    {{-- ===== RESULTS COUNT ===== --}}
    @if($questions->total() > 0)
        <p class="iq-results-count">
            Showing <strong>{{ $questions->firstItem() }}–{{ $questions->lastItem() }}</strong> of
            <strong>{{ $questions->total() }}</strong> questions
        </p>
    @endif

    {{-- ===== QUESTIONS LIST ===== --}}
    <div class="iq-list">
        @forelse($questions as $question)
            @php
                $diff = $question->difficulty;
                $diffClass = 'iq-badge-easy';
                if ($diff === 'Medium') $diffClass = 'iq-badge-medium';
                elseif ($diff === 'Hard') $diffClass = 'iq-badge-hard';
            @endphp

            <details class="iq-card">
                <summary class="iq-summary">
                    <div class="iq-summary-left">
                        <span class="iq-badge {{ $diffClass }}">{{ $diff }}</span>
                        @if($question->technology)
                            <span class="iq-tech-badge">{{ $question->technology }}</span>
                        @endif
                        <h6 class="iq-question-title">{{ $question->title }}</h6>
                    </div>
                    <div class="iq-chevron">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </summary>

                <div class="iq-body">
                    {{-- Question --}}
                    <div class="iq-section">
                        <div class="iq-section-label iq-label-q">
                            <i class="fas fa-question-circle"></i> Question
                        </div>
                        <div class="iq-question-box">
                            {!! nl2br(e($question->question_text)) !!}
                        </div>
                    </div>

                    {{-- Answer --}}
                    @if($question->answer_text)
                        <div class="iq-section">
                            <div class="iq-section-label iq-label-a">
                                <i class="fas fa-check-circle"></i> Short Answer
                            </div>
                            <div class="iq-answer-text">
                                {!! nl2br(e($question->answer_text)) !!}
                            </div>
                        </div>
                    @endif

                    {{-- Explanation / Tip --}}
                    @if($question->explanation)
                        <div class="iq-section">
                            <div class="iq-section-label iq-label-tip">
                                <i class="fas fa-lightbulb"></i> Expert Explanation &amp; Interview Tips
                            </div>
                            <div class="iq-tip-box">
                                <p>{{ $question->explanation }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </details>
        @empty
            <div class="iq-empty">
                <div class="iq-empty-icon"><i class="fas fa-graduation-cap"></i></div>
                <h6>No questions found</h6>
                <p>
                    @if(request()->anyFilled(['search', 'technology', 'difficulty']))
                        No questions match your current filters. Try clearing them or adjusting your search.
                    @else
                        There are no interview questions in this category yet. Check back soon for new content.
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    {{-- ===== PAGINATION ===== --}}
    @if($questions->hasPages())
        <div class="iq-pagination-wrap">
            {{ $questions->appends(request()->query())->links() }}
        </div>
    @endif

</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#categoryFilterForm").validate({
                rules: { search: { maxlength: 100 } },
                errorClass: "iq-error",
                errorElement: "span",
                submitHandler: function(form) { form.submit(); }
            });

            // Optional: auto-close other accordions when one opens (uncomment if desired)
            // document.querySelectorAll('.iq-card').forEach(card => {
            //     card.addEventListener('toggle', function() {
            //         if (this.open) {
            //             document.querySelectorAll('.iq-card[open]').forEach(other => {
            //                 if (other !== this) other.open = false;
            //             });
            //         }
            //     });
            // });
        });
    </script>
@endpush