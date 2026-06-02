@extends('layouts.app')

@section('content')

{{-- Inline styles — scoped to this page only, guaranteed to render --}}
<style>
    .rt-page { font-family: inherit; }

    /* HEADER */
    .rt-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        padding: 4px 0;
    }
    .rt-eyebrow {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.15em;
        color: #7e22ce;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .rt-title {
        font-size: 20px;
        font-weight: 700;
        color: #334155;
        margin: 0 0 4px 0;
    }
    .rt-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    .rt-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        padding: 0 16px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .rt-back-btn:hover { border-color: #c084fc; color: #7e22ce; }

    /* TOOLBAR CARD */
    .rt-toolbar {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }
    .rt-toolbar-row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 16px;
    }
    .rt-field { display: flex; flex-direction: column; }
    .rt-field-search { flex: 1 1 280px; }
    .rt-field-category { flex: 0 1 200px; }
    .rt-field-show { flex: 0 1 160px; }
    .rt-field-button { flex: 0 0 auto; }

    .rt-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 8px;
    }
    .rt-input, .rt-select {
        width: 100%;
        height: 44px;
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
    .rt-input:focus, .rt-select:focus {
        border-color: #c084fc;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(192, 132, 252, 0.15);
    }
    .rt-input-wrapper { position: relative; }
    .rt-input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }
    .rt-input-with-icon { padding-left: 38px; }

    .rt-apply-btn {
        height: 44px;
        padding: 0 28px;
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
    }
    .rt-apply-btn:hover { opacity: 0.9; transform: translateY(-1px); }

    /* ACTIVE FILTERS BAR */
    .rt-active-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .rt-active-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
    }
    .rt-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 26px;
        padding: 0 10px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 999px;
        white-space: nowrap;
    }
    .rt-chip-purple { background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; }
    .rt-chip-pink { background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; }
    .rt-clear { margin-left: auto; font-size: 11px; font-weight: 700; color: #64748b; text-decoration: none; }
    .rt-clear:hover { color: #7e22ce; }

    /* RESULTS COUNT */
    .rt-count {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 16px;
    }
    .rt-count strong { color: #334155; font-weight: 700; }

    /* GRID */
    .rt-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }
    @media (max-width: 640px) {
        .rt-grid { grid-template-columns: 1fr; }
    }

    /* CARD */
    .rt-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .rt-card:hover {
        transform: translateY(-4px);
        border-color: #d8b4fe;
        box-shadow: 0 25px 50px -12px rgba(126, 34, 206, 0.15);
    }
    .rt-preview {
        position: relative;
        width: 100%;
        padding-top: 125%;
        background: #f8fafc;
        overflow: hidden;
    }
    .rt-preview-inner {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .rt-preview-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .rt-card:hover .rt-preview-img { transform: scale(1.05); }

    .rt-mockup {
        position: absolute;
        inset: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: linear-gradient(135deg, #faf5ff 0%, #fff 50%, #fdf2f8 100%);
    }
    .rt-mockup-bar { background: #e2e8f0; border-radius: 3px; }
    .rt-mockup-accent-p { background: #e9d5ff; border-radius: 3px; }
    .rt-mockup-accent-pk { background: #fbcfe8; border-radius: 3px; }

    .rt-chip-doc {
        position: absolute;
        top: 12px;
        right: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #334155;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .rt-chip-doc i { color: #2563eb; }

    .rt-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .rt-cat-row { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
    .rt-cat-badge {
        display: inline-block;
        padding: 2px 8px;
        background: #faf5ff;
        color: #7e22ce;
        border: 1px solid #f3e8ff;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .rt-card-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
        line-height: 1.4;
    }
    .rt-card-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.6;
        margin: 0 0 16px 0;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .rt-download-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 44px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #fff;
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 7px -1px rgba(0,0,0,0.11);
        transition: all 0.2s;
        margin-top: auto;
    }
    .rt-download-btn:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

    /* EMPTY STATE */
    .rt-empty {
        max-width: 460px;
        margin: 0 auto;
        text-align: center;
        padding: 48px 32px;
        background: #fff;
        border: 1px dashed #e2e8f0;
        border-radius: 16px;
    }
    .rt-empty-icon {
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
    .rt-empty h5 { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; }
    .rt-empty p { font-size: 13px; color: #64748b; max-width: 320px; margin: 0 auto 24px; line-height: 1.6; }

    /* PAGINATION */
    .rt-pagination-wrap { display: flex; justify-content: center; margin-top: 32px; margin-bottom: 16px; }
    .rt-pagination {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        list-style: none;
        margin: 0;
    }
    .rt-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 8px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s;
    }
    .rt-page-btn:hover { background: #f8fafc; color: #7e22ce; }
    .rt-page-active {
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        color: #fff !important;
        font-weight: 700;
        box-shadow: 0 4px 7px -1px rgba(0,0,0,0.11);
    }
    .rt-page-disabled { color: #cbd5e1; cursor: not-allowed; }
    .rt-page-ellipsis { color: #94a3b8; font-size: 12px; padding: 0 4px; }
</style>

<div class="rt-page">

    {{-- HEADER --}}
    <div class="rt-header">
        <div>
            <span class="rt-eyebrow">Resume Templates</span>
            <h4 class="rt-title">Browse Resume Templates</h4>
            <p class="rt-subtitle">Download professional, ATS-friendly Microsoft Word templates ready to customize.</p>
        </div>
        <a href="{{ route('customer.profile.check') }}" class="rt-back-btn">
            <i class="fas fa-chevron-left" style="font-size: 10px;"></i> Back to Profile
        </a>
    </div>

    {{-- TOOLBAR --}}
    <div class="rt-toolbar">
        <form action="{{ route('customer.resume-templates') }}" method="GET" id="toolbarForm">
            <div class="rt-toolbar-row">

                {{-- Search --}}
                <div class="rt-field rt-field-search">
                    <label class="rt-label">Search</label>
                    <div class="rt-input-wrapper">
                        <span class="rt-input-icon"><i class="fas fa-search"></i></span>
                        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}"
                               placeholder="Search templates by name..."
                               class="rt-input rt-input-with-icon" />
                    </div>
                </div>

                {{-- Category --}}
                <div class="rt-field rt-field-category">
                    <label class="rt-label">Category</label>
                    <select name="category_id" id="category_id" onchange="this.form.submit()" class="rt-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Show --}}
                <div class="rt-field rt-field-show">
                    <label class="rt-label">Show</label>
                    <select name="page_size" id="page_size" onchange="this.form.submit()" class="rt-select">
                        <option value="9" {{ request('page_size', 9) == 9 ? 'selected' : '' }}>9 per page</option>
                        <option value="18" {{ request('page_size') == 18 ? 'selected' : '' }}>18 per page</option>
                        <option value="36" {{ request('page_size') == 36 ? 'selected' : '' }}>36 per page</option>
                    </select>
                </div>

                {{-- Apply --}}
                <div class="rt-field rt-field-button">
                    <button type="submit" class="rt-apply-btn">Apply</button>
                </div>

            </div>

            {{-- Active filters --}}
            @if(request('keyword') || request('category_id'))
                <div class="rt-active-filters">
                    <span class="rt-active-label">Active:</span>
                    @if(request('keyword'))
                        <span class="rt-chip rt-chip-purple">
                            <i class="fas fa-search" style="font-size: 9px;"></i> "{{ request('keyword') }}"
                        </span>
                    @endif
                    @if(request('category_id'))
                        @php $activeCat = $categories->firstWhere('id', request('category_id')); @endphp
                        @if($activeCat)
                            <span class="rt-chip rt-chip-pink">
                                <i class="fas fa-tag" style="font-size: 9px;"></i> {{ $activeCat->name }}
                            </span>
                        @endif
                    @endif
                    <a href="{{ route('customer.resume-templates') }}" class="rt-clear">
                        Clear all <i class="fas fa-times" style="font-size: 9px; margin-left: 4px;"></i>
                    </a>
                </div>
            @endif
        </form>
    </div>

    {{-- RESULTS COUNT --}}
    @if($templates->total() > 0)
        <p class="rt-count">
            Showing <strong>{{ $templates->firstItem() }}–{{ $templates->lastItem() }}</strong> of
            <strong>{{ $templates->total() }}</strong> templates
        </p>
    @endif

    {{-- GRID --}}
    <div class="rt-grid">
        @forelse($templates as $template)
            <div class="rt-card">

                {{-- Preview --}}
                <div class="rt-preview">
                    <div class="rt-preview-inner">
                        @if($template->thumbnail)
                            <img src="{{ asset('storage/' . $template->thumbnail) }}"
                                 alt="{{ $template->title }}" class="rt-preview-img">
                        @else
                            <div class="rt-mockup">
                                <div style="border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
                                    <div class="rt-mockup-bar" style="height: 12px; width: 112px; background: #cbd5e1; margin-bottom: 6px;"></div>
                                    <div class="rt-mockup-bar" style="height: 6px; width: 64px;"></div>
                                </div>
                                <div style="flex-grow: 1; padding: 16px 0; display: flex; flex-direction: column; gap: 12px;">
                                    <div style="display: flex; flex-direction: column; gap: 6px;">
                                        <div class="rt-mockup-accent-p" style="height: 8px; width: 48px;"></div>
                                        <div class="rt-mockup-bar" style="height: 6px; width: 100%;"></div>
                                        <div class="rt-mockup-bar" style="height: 6px; width: 83%;"></div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 6px;">
                                        <div class="rt-mockup-accent-pk" style="height: 8px; width: 64px;"></div>
                                        <div class="rt-mockup-bar" style="height: 6px; width: 100%;"></div>
                                        <div class="rt-mockup-bar" style="height: 6px; width: 92%;"></div>
                                    </div>
                                </div>
                                <div style="border-top: 1px solid #e2e8f0; padding-top: 8px; display: flex; justify-content: space-between;">
                                    <div class="rt-mockup-bar" style="height: 6px; width: 56px;"></div>
                                    <div class="rt-mockup-bar" style="height: 6px; width: 32px;"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="rt-chip-doc">
                        <i class="fas fa-file-word"></i> .docx
                    </div>
                </div>

                {{-- Body --}}
                <div class="rt-card-body">
                    @if($template->categories->count())
                        <div class="rt-cat-row">
                            @foreach($template->categories as $c)
                                <span class="rt-cat-badge">{{ $c->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <h6 class="rt-card-title">{{ $template->title }}</h6>

                    @if($template->description)
                        <p class="rt-card-desc">{{ strip_tags($template->description) }}</p>
                    @else
                        <div style="flex-grow: 1;"></div>
                    @endif

                    <a href="{{ route('customer.resume-templates.download', $template->id) }}" class="rt-download-btn">
                        <i class="fas fa-download" style="font-size: 12px;"></i> Download Template
                    </a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1;">
                <div class="rt-empty">
                    <div class="rt-empty-icon"><i class="fas fa-file-invoice"></i></div>
                    <h5>No templates found</h5>
                    <p>
                        @if(request('keyword') || request('category_id'))
                            Try clearing your filters or searching with different keywords.
                        @else
                            There are no resume templates currently mapped to your active plan categories. Contact support if you believe this is an error.
                        @endif
                    </p>
                    <a href="{{ route('customer.resume-templates') }}" class="rt-download-btn" style="width: auto; height: 40px; padding: 0 20px;">
                        <i class="fas fa-undo" style="font-size: 10px;"></i> Reset Filters
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($templates->hasPages())
        <div class="rt-pagination-wrap">
            <ul class="rt-pagination">
                @if ($templates->onFirstPage())
                    <li><span class="rt-page-btn rt-page-disabled"><i class="fas fa-angle-left"></i></span></li>
                @else
                    <li><a href="{{ $templates->previousPageUrl() }}" class="rt-page-btn"><i class="fas fa-angle-left"></i></a></li>
                @endif

                @php
                    $current = $templates->currentPage();
                    $last = $templates->lastPage();
                    $window = 1;
                    $pages = collect(range(1, $last))->filter(function($p) use ($current, $last, $window) {
                        return $p == 1 || $p == $last || abs($p - $current) <= $window;
                    })->values();
                @endphp

                @foreach($pages as $i => $page)
                    @if($i > 0 && $page - $pages[$i-1] > 1)
                        <li><span class="rt-page-ellipsis">…</span></li>
                    @endif
                    @if ($page == $current)
                        <li><span class="rt-page-btn rt-page-active">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $templates->url($page) }}" class="rt-page-btn">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($templates->hasMorePages())
                    <li><a href="{{ $templates->nextPageUrl() }}" class="rt-page-btn"><i class="fas fa-angle-right"></i></a></li>
                @else
                    <li><span class="rt-page-btn rt-page-disabled"><i class="fas fa-angle-right"></i></span></li>
                @endif
            </ul>
        </div>
    @endif

</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#toolbarForm").validate({
                rules: { keyword: { maxlength: 100 } },
                errorClass: "rt-error",
                errorElement: "span",
                submitHandler: function(form) { form.submit(); }
            });
        });
    </script>
@endpush