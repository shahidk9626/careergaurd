@extends('layouts.app')

@section('content')

<style>
    .iq-page { font-family: inherit; }

    /* ===== TABS ===== */
    .iq-tab-bar {
        display: flex;
        gap: 4px;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 4px;
        margin-bottom: 24px;
        width: fit-content;
    }
    .iq-tab {
        padding: 9px 22px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
        border-radius: 9px;
        cursor: pointer;
        background: transparent;
        color: #64748b;
        transition: all 0.2s;
    }
    .iq-tab.active {
        background: #fff;
        color: #7e22ce;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .iq-tab-panel { display: none; }
    .iq-tab-panel.active { display: block; }

    /* ===== HEADER ===== */
    .iq-header {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }
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
    .iq-title { font-size: 28px; font-weight: 800; color: #1e293b; margin: 0 0 6px 0; letter-spacing: -0.02em; line-height: 1.2; }
    .iq-subtitle { font-size: 14px; color: #64748b; margin: 0; }

    /* Print PDF button */
    .iq-pdf-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        padding: 0 20px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #fff;
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        border: none;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 7px -1px rgba(0,0,0,0.11);
        transition: all 0.2s;
        white-space: nowrap;
        text-decoration: none;
        flex-shrink: 0;
        margin-top: 4px;
    }
    .iq-pdf-btn:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

    /* ===== FILTER TOOLBAR ===== */
    .iq-toolbar {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }
    .iq-toolbar-row { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; }
    .iq-search { flex: 1 1 280px; position: relative; }
    .iq-search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none; }
    .iq-input, .iq-select {
        width: 100%; height: 42px; padding: 0 14px; font-size: 14px; color: #334155;
        background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
        outline: none; transition: all 0.2s; box-sizing: border-box;
    }
    .iq-input { padding-left: 38px; }
    .iq-input:focus, .iq-select:focus { border-color: #c084fc; background: #fff; box-shadow: 0 0 0 3px rgba(192,132,252,0.15); }
    .iq-select-wrap { flex: 0 1 180px; min-width: 160px; }
    .iq-clear {
        display: inline-flex; align-items: center; gap: 6px; height: 42px; padding: 0 16px;
        font-size: 11px; font-weight: 700; color: #64748b; background: transparent;
        border: 1px solid #e2e8f0; border-radius: 10px; text-decoration: none;
        text-transform: uppercase; letter-spacing: 0.05em; transition: all 0.2s; white-space: nowrap;
    }
    .iq-clear:hover { color: #be185d; border-color: #fbcfe8; background: #fdf2f8; }

    /* ===== ACTIVE FILTERS ===== */
    .iq-active-bar { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9; }
    .iq-active-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; }
    .iq-active-chip { display: inline-flex; align-items: center; gap: 6px; height: 26px; padding: 0 10px; background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; border-radius: 999px; font-size: 11px; font-weight: 600; }

    /* ===== RESULTS COUNT ===== */
    .iq-results-count { font-size: 12px; color: #64748b; margin-bottom: 16px; }
    .iq-results-count strong { color: #334155; font-weight: 700; }

    /* ===== QUESTION LIST ===== */
    .iq-list { display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px; }

    /* ===== ACCORDION CARD ===== */
    .iq-card { background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; overflow: hidden; transition: all 0.25s ease; }
    .iq-card:hover { border-color: #e9d5ff; box-shadow: 0 8px 20px -4px rgba(126,34,206,0.08); }
    .iq-card[open] { border-color: #d8b4fe; box-shadow: 0 12px 28px -6px rgba(126,34,206,0.12); }
    .iq-summary { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 20px 24px; cursor: pointer; user-select: none; list-style: none; }
    .iq-summary::-webkit-details-marker { display: none; }
    .iq-summary::marker { display: none; }
    .iq-summary-left { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; flex: 1; min-width: 0; }
    .iq-badge { display: inline-flex; align-items: center; height: 24px; padding: 0 10px; border-radius: 999px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid; white-space: nowrap; flex-shrink: 0; }
    .iq-badge-easy   { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
    .iq-badge-medium { background: #fffbeb; color: #b45309; border-color: #fde68a; }
    .iq-badge-hard   { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .iq-tech-badge { display: inline-flex; align-items: center; height: 24px; padding: 0 10px; background: #f8fafc; color: #475569; border: 1px solid #f1f5f9; border-radius: 8px; font-size: 10px; font-weight: 700; white-space: nowrap; flex-shrink: 0; }
    .iq-question-title { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; line-height: 1.4; flex: 1; min-width: 200px; }
    .iq-card:hover .iq-question-title, .iq-card[open] .iq-question-title { color: #7e22ce; }
    .iq-chevron { width: 32px; height: 32px; border-radius: 50%; background: #f8fafc; color: #94a3b8; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 11px; transition: all 0.3s ease; }
    .iq-card[open] .iq-chevron { background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%); color: #fff; transform: rotate(180deg); }

    /* ===== ACCORDION BODY ===== */
    .iq-body { padding: 0 24px 24px 24px; border-top: 1px solid #f1f5f9; }
    .iq-section { margin-top: 20px; }
    .iq-section:first-child { margin-top: 24px; }
    .iq-section-label { display: inline-flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px; }
    .iq-label-q   { color: #7e22ce; }
    .iq-label-a   { color: #475569; }
    .iq-label-tip { color: #7e22ce; }
    .iq-question-box { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 12px; padding: 16px 18px; font-size: 14px; font-weight: 600; color: #1e293b; line-height: 1.6; }
    .iq-answer-text { font-size: 14px; color: #475569; line-height: 1.7; }
    .iq-tip-box { background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%); border: 1px solid #f3e8ff; border-radius: 12px; padding: 18px; }
    .iq-tip-box p { font-size: 14px; color: #475569; line-height: 1.7; margin: 0; }

    /* ===== PDF RESOURCES TAB ===== */
    .pdf-res-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .pdf-res-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .pdf-res-card:hover { border-color: #e9d5ff; box-shadow: 0 8px 24px rgba(126,34,206,0.10); transform: translateY(-2px); }
    .pdf-res-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; color: #db2777;
        background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%);
        border: 1px solid #f3e8ff;
        flex-shrink: 0;
    }
    .pdf-res-title { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; line-height: 1.3; }
    .pdf-res-desc  { font-size: 13px; color: #64748b; margin: 0; line-height: 1.5; }
    .pdf-res-meta  { font-size: 11px; color: #94a3b8; }
    .pdf-res-cats  { display: flex; flex-wrap: wrap; gap: 4px; }
    .pdf-res-cat {
        padding: 2px 8px;
        background: #faf5ff; color: #7e22ce;
        border: 1px solid #f3e8ff; border-radius: 6px;
        font-size: 9px; font-weight: 800; text-transform: uppercase;
    }
    .pdf-res-download {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; height: 44px;
        font-size: 12px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;
        color: #fff; text-decoration: none;
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        border-radius: 10px;
        box-shadow: 0 4px 7px -1px rgba(0,0,0,0.11);
        transition: all 0.2s;
        margin-top: auto;
    }
    .pdf-res-download:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }
    .pdf-res-empty { text-align: center; padding: 56px 24px; }
    .pdf-res-empty-icon {
        width: 72px; height: 72px; margin: 0 auto 16px;
        background: #faf5ff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: #d8b4fe; font-size: 28px;
    }
    .pdf-res-empty h6 { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; }
    .pdf-res-empty p  { font-size: 13px; color: #64748b; max-width: 320px; margin: 0 auto; line-height: 1.6; }

    /* ===== EMPTY STATE ===== */
    .iq-empty { background: #fff; border: 1px dashed #e2e8f0; border-radius: 16px; padding: 56px 32px; text-align: center; }
    .iq-empty-icon { width: 72px; height: 72px; margin: 0 auto 16px; background: #faf5ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #d8b4fe; font-size: 28px; }
    .iq-empty h6 { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; }
    .iq-empty p  { font-size: 13px; color: #64748b; max-width: 360px; margin: 0 auto; line-height: 1.6; }

    /* ===== PAGINATION ===== */
    .iq-pagination-wrap { padding: 14px; background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; display: flex; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); }
    .iq-pagination-wrap .pagination { margin: 0; gap: 4px; display: flex; align-items: center; }
    .iq-pagination-wrap .page-link { min-width: 36px; height: 36px; padding: 0 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px !important; font-size: 12px; font-weight: 600; color: #475569; border: none; background: transparent; }
    .iq-pagination-wrap .page-link:hover { background: #f8fafc; color: #7e22ce; }
    .iq-pagination-wrap .page-item.active .page-link { background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); color: #fff; box-shadow: 0 4px 7px -1px rgba(126,34,206,0.25); }
    .iq-pagination-wrap .page-item.disabled .page-link { color: #cbd5e1; background: transparent; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 640px) {
        .iq-summary { padding: 16px 18px; }
        .iq-body { padding: 0 18px 20px 18px; }
        .iq-question-title { font-size: 14px; min-width: 100%; }
        .iq-toolbar-row { gap: 10px; }
        .iq-title { font-size: 22px; }
        .iq-pdf-btn span { display: none; }
        .pdf-res-grid { grid-template-columns: 1fr; }
        .iq-tab-bar { width: 100%; }
        .iq-tab { flex: 1; text-align: center; }
    }

    /* ===== PRINT ===== */
    @media print {
        body * { visibility: hidden; }
        #pdf-content, #pdf-content * { visibility: visible; }
        #pdf-content { position: fixed; top: 0; left: 0; width: 100%; }
        .iq-pdf-btn, .iq-toolbar, .iq-results-count, .iq-pagination-wrap, .iq-back, .iq-chevron, .iq-tab-bar, #tab-pdfs { display: none !important; }
        details.iq-card { display: block !important; }
        details.iq-card summary { display: none !important; }
        details.iq-card .iq-body { display: block !important; padding: 0 0 16px 0 !important; }
        .iq-card { border: 1px solid #e2e8f0 !important; box-shadow: none !important; margin-bottom: 16px; page-break-inside: avoid; }
        .iq-question-title { color: #1e293b !important; font-size: 13px !important; padding: 12px 16px; display: block; }
        .iq-section { margin-top: 12px; }
        .pdf-print-header { display: block !important; }
        @page { margin: 20mm 15mm; }
    }
    .pdf-print-header { display: none; }
</style>

<div class="iq-page" id="pdf-content">

    {{-- HEADER --}}
    <div class="iq-header">
        <div>
            <a href="{{ route('customer.interview-questions') }}" class="iq-back">
                <i class="fas fa-arrow-left"></i> Back to Prep Hub
            </a>
            <h2 class="iq-title">{{ $category->name }} Q&amp;As</h2>
            <p class="iq-subtitle">Browse curated interview questions, professional tips, and step-by-step explanations.</p>
        </div>
        @if($questions->total() > 0)
            <button type="button" class="iq-pdf-btn" id="printPdfBtn" onclick="downloadPDF()">
                <i class="fas fa-file-pdf"></i>
                <span>Download PDF</span>
            </button>
        @endif
    </div>

    {{-- Print-only header --}}
    <div class="pdf-print-header" style="margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #7e22ce;">
        <p style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.15em; color:#7e22ce; margin:0 0 4px 0;">CareerGuard · Interview Prep</p>
        <h1 style="font-size:22px; font-weight:800; color:#1e293b; margin:0 0 4px 0;">{{ $category->name }} — Interview Q&As</h1>
        <p style="font-size:12px; color:#64748b; margin:0;">Generated on {{ now()->format('d M Y') }} · {{ $questions->total() }} questions</p>
    </div>

    {{-- TAB BAR --}}
    <div class="iq-tab-bar">
        <button class="iq-tab active" onclick="switchTab('questions', this)">
            <i class="fas fa-question-circle mr-1"></i> Questions
            @if($questions->total() > 0)
                <span style="margin-left:6px; background:#7e22ce; color:#fff; border-radius:999px; padding:1px 7px; font-size:10px;">{{ $questions->total() }}</span>
            @endif
        </button>
        <button class="iq-tab" onclick="switchTab('pdfs', this)">
            <i class="fas fa-file-pdf mr-1"></i> PDF Resources
        </button>
    </div>

    {{-- ===== TAB: QUESTIONS ===== --}}
    <div id="tab-questions" class="iq-tab-panel active">

        {{-- Filter toolbar --}}
        <div class="iq-toolbar">
            <form action="{{ route('customer.interview-questions.category', $category->id) }}" method="GET" id="categoryFilterForm">
                <div class="iq-toolbar-row">
                    <div class="iq-search">
                        <span class="iq-search-icon"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search questions..." class="iq-input">
                    </div>
                    <div class="iq-select-wrap">
                        <select name="technology" id="technology" onchange="this.form.submit()" class="iq-select">
                            <option value="">All Technologies</option>
                            @foreach($technologies as $tech)
                                <option value="{{ $tech }}" {{ request('technology') === $tech ? 'selected' : '' }}>{{ $tech }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="iq-select-wrap" style="flex:0 1 160px;">
                        <select name="difficulty" id="difficulty" onchange="this.form.submit()" class="iq-select">
                            <option value="">All Difficulties</option>
                            <option value="Easy"   {{ request('difficulty') === 'Easy'   ? 'selected' : '' }}>Easy</option>
                            <option value="Medium" {{ request('difficulty') === 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="Hard"   {{ request('difficulty') === 'Hard'   ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>
                    @if(request()->anyFilled(['search', 'technology', 'difficulty']))
                        <a href="{{ route('customer.interview-questions.category', $category->id) }}" class="iq-clear">
                            <i class="fas fa-times" style="font-size:10px;"></i> Clear
                        </a>
                    @endif
                </div>
                @if(request()->anyFilled(['search', 'technology', 'difficulty']))
                    <div class="iq-active-bar">
                        <span class="iq-active-label">Active:</span>
                        @if(request('search'))
                            <span class="iq-active-chip"><i class="fas fa-search" style="font-size:9px;"></i> "{{ request('search') }}"</span>
                        @endif
                        @if(request('technology'))
                            <span class="iq-active-chip"><i class="fas fa-code" style="font-size:9px;"></i> {{ request('technology') }}</span>
                        @endif
                        @if(request('difficulty'))
                            <span class="iq-active-chip"><i class="fas fa-signal" style="font-size:9px;"></i> {{ request('difficulty') }}</span>
                        @endif
                    </div>
                @endif
            </form>
        </div>

        @if($questions->total() > 0)
            <p class="iq-results-count">
                Showing <strong>{{ $questions->firstItem() }}–{{ $questions->lastItem() }}</strong> of
                <strong>{{ $questions->total() }}</strong> questions
                @if($questions->hasPages())
                    <span style="color:#94a3b8;"> — PDF will include this page only.</span>
                @endif
            </p>
        @endif

        <div class="iq-list">
            @forelse($questions as $question)
                @php
                    $diff = $question->difficulty;
                    $diffClass = $diff === 'Medium' ? 'iq-badge-medium' : ($diff === 'Hard' ? 'iq-badge-hard' : 'iq-badge-easy');
                @endphp
                <details class="iq-card" id="q-{{ $question->id }}">
                    <summary class="iq-summary">
                        <div class="iq-summary-left">
                            <span class="iq-badge {{ $diffClass }}">{{ $diff }}</span>
                            @if($question->technology)
                                <span class="iq-tech-badge">{{ $question->technology }}</span>
                            @endif
                            <h6 class="iq-question-title">{{ $question->title }}</h6>
                        </div>
                        <div class="iq-chevron"><i class="fas fa-chevron-down"></i></div>
                    </summary>
                    <div class="iq-body">
                        <div class="iq-section">
                            <div class="iq-section-label iq-label-q"><i class="fas fa-question-circle"></i> Question</div>
                            <div class="iq-question-box">{!! nl2br(e($question->question_text)) !!}</div>
                        </div>
                        @if($question->answer_text)
                            <div class="iq-section">
                                <div class="iq-section-label iq-label-a"><i class="fas fa-check-circle"></i> Short Answer</div>
                                <div class="iq-answer-text">{!! nl2br(e($question->answer_text)) !!}</div>
                            </div>
                        @endif
                        @if($question->explanation)
                            <div class="iq-section">
                                <div class="iq-section-label iq-label-tip"><i class="fas fa-lightbulb"></i> Expert Explanation &amp; Interview Tips</div>
                                <div class="iq-tip-box"><p>{{ $question->explanation }}</p></div>
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
                            There are no interview questions in this category yet. Check back soon.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>

        @if($questions->hasPages())
            <div class="iq-pagination-wrap">
                {{ $questions->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    {{-- ===== TAB: PDF RESOURCES ===== --}}
    <div id="tab-pdfs" class="iq-tab-panel">
        <div id="pdf-res-container">
            <div style="text-align:center; padding:48px; color:#94a3b8;">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p style="margin-top:12px; font-size:13px;">Loading PDF resources...</p>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $("#categoryFilterForm").validate({
            rules: { search: { maxlength: 100 } },
            errorClass: "iq-error",
            errorElement: "span",
            submitHandler: function (form) { form.submit(); }
        });
    });

    // ── Tab switching ──────────────────────────────────────────────────────────
    function switchTab(tab, btn) {
        document.querySelectorAll('.iq-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.iq-tab-panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + tab).classList.add('active');

        // Hide print button on PDF tab (not relevant there)
        const printBtn = document.getElementById('printPdfBtn');
        if (printBtn) printBtn.style.display = tab === 'questions' ? '' : 'none';

        if (tab === 'pdfs') loadPdfResources();
    }

    // ── Print Q&A as PDF ──────────────────────────────────────────────────────
    function downloadPDF() {
        document.querySelectorAll('details.iq-card').forEach(d => d.setAttribute('open', true));
        setTimeout(() => window.print(), 150);
    }

    // ── Load PDF resources from server ────────────────────────────────────────
    let pdfsLoaded = false;

    function loadPdfResources() {
        if (pdfsLoaded) return; // only fetch once

        $.get("{{ url('customer/interview-pdfs') }}", { category_id: {{ $category->id }} }, function (data) {
            pdfsLoaded = true;
            const wrap = document.getElementById('pdf-res-container');

            if (!data.length) {
                wrap.innerHTML = `
                    <div class="pdf-res-empty">
                        <div class="pdf-res-empty-icon"><i class="fas fa-file-pdf"></i></div>
                        <h6>No PDF resources yet</h6>
                        <p>There are no PDF downloads available for this category yet. Check back soon.</p>
                    </div>`;
                return;
            }

            const cards = data.map(pdf => `
                <div class="pdf-res-card">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="pdf-res-icon"><i class="fas fa-file-pdf"></i></div>
                        <div style="min-width:0;">
                            <p class="pdf-res-title">${pdf.title}</p>
                            <p class="pdf-res-meta">Uploaded ${pdf.uploaded}</p>
                        </div>
                    </div>
                    ${pdf.description ? `<p class="pdf-res-desc">${pdf.description}</p>` : ''}
                    ${pdf.categories && pdf.categories.length
                        ? `<div class="pdf-res-cats">${pdf.categories.map(c => `<span class="pdf-res-cat">${c.name}</span>`).join('')}</div>`
                        : ''}
                    <a href="/public/${pdf.file_url}" target="_blank" download class="pdf-res-download">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                </div>
            `).join('');

            wrap.innerHTML = `<div class="pdf-res-grid">${cards}</div>`;
        }).fail(function () {
            document.getElementById('pdf-res-container').innerHTML = `
                <div class="pdf-res-empty">
                    <div class="pdf-res-empty-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <h6>Could not load PDFs</h6>
                    <p>Something went wrong. Please refresh the page and try again.</p>
                </div>`;
        });
    }
</script>
@endpush