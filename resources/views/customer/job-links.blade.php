@extends('layouts.app')

@section('content')

<style>
    /* ============================================
       JOB OPPORTUNITIES PAGE STYLES
       Self-contained — works regardless of CSS framework
    ============================================= */
    .jb-page { font-family: inherit; }

    /* HEADER */
    .jb-header {
        margin-bottom: 24px;
    }
    .jb-eyebrow {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.15em;
        color: #7e22ce;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .jb-title {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 6px 0;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .jb-subtitle {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    /* ALERT */
    .jb-alert {
        margin-bottom: 24px;
        padding: 14px 18px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        color: #b91c1c;
        font-size: 13px;
    }

    /* LAYOUT — sidebar + main */
    .jb-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 1023px) {
        .jb-layout { grid-template-columns: 1fr; }
    }

    /* SIDEBAR */
    .jb-sidebar {
        position: sticky;
        top: 24px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05);
    }
    @media (max-width: 1023px) {
        .jb-sidebar { position: static; }
    }
    .jb-sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .jb-sidebar-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .jb-sidebar-title i {
        color: #7e22ce;
        font-size: 14px;
    }
    .jb-reset {
        font-size: 12px;
        font-weight: 700;
        color: #7e22ce;
        text-decoration: none;
        transition: color 0.2s;
    }
    .jb-reset:hover { color: #581c87; }

    .jb-field { margin-bottom: 18px; }
    .jb-field:last-of-type { margin-bottom: 24px; }
    .jb-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 8px;
    }
    .jb-input, .jb-select {
        width: 100%;
        height: 42px;
        padding: 0 12px;
        font-size: 13px;
        color: #334155;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .jb-input:focus, .jb-select:focus {
        border-color: #c084fc;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(192, 132, 252, 0.15);
    }
    .jb-input-wrap { position: relative; }
    .jb-input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 12px;
        pointer-events: none;
    }
    .jb-input-icon-pad { padding-left: 36px; }

    .jb-apply-btn {
        width: 100%;
        height: 44px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #fff;
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        border: none;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 7px -1px rgba(126, 34, 206, 0.25);
        transition: all 0.2s;
    }
    .jb-apply-btn:hover { opacity: 0.92; transform: translateY(-1px); }

    /* JOB LIST */
    .jb-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .jb-results-count {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }
    .jb-results-count strong { color: #334155; font-weight: 700; }

    /* JOB CARD */
    .jb-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
        transition: all 0.3s;
    }
    .jb-card:hover {
        border-color: #d8b4fe;
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(126, 34, 206, 0.1);
    }
    .jb-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }
    .jb-card-main {
        display: flex;
        gap: 16px;
        flex: 1;
        min-width: 0;
    }
    .jb-logo {
        flex-shrink: 0;
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%);
        color: #7e22ce;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        text-transform: uppercase;
        border: 1px solid #f3e8ff;
    }
    .jb-info { flex: 1; min-width: 0; }
    .jb-job-title {
        font-size: 17px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
        line-height: 1.3;
    }
    .jb-company {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 12px;
        display: block;
    }
    .jb-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    .jb-meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 26px;
        padding: 0 10px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 999px;
        font-size: 11px;
        color: #475569;
        font-weight: 500;
    }
    .jb-meta-chip i { font-size: 10px; color: #94a3b8; }

    /* RIGHT SIDE — date + CTA */
    .jb-card-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 12px;
        flex-shrink: 0;
    }
    @media (max-width: 640px) {
        .jb-card-right {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
    }
    .jb-date {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        white-space: nowrap;
    }
    .jb-cta-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 40px;
        padding: 0 20px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #fff;
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 7px -1px rgba(126, 34, 206, 0.25);
        transition: all 0.2s;
        white-space: nowrap;
    }
    .jb-cta-btn:hover { opacity: 0.92; color: #fff; transform: translateY(-1px); }
    .jb-cta-btn i { font-size: 10px; }

    /* DESCRIPTION */
    .jb-description {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* SKILL CHIPS */
    .jb-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 12px;
    }
    .jb-skill {
        padding: 4px 10px;
        font-size: 10px;
        font-weight: 700;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 999px;
    }

    /* EMPTY STATE */
    .jb-empty {
        background: #fff;
        border: 1px dashed #e2e8f0;
        border-radius: 16px;
        padding: 48px 32px;
        text-align: center;
    }
    .jb-empty-icon {
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
    .jb-empty h6 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
    }
    .jb-empty p {
        font-size: 13px;
        color: #64748b;
        max-width: 380px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* PAGINATION WRAPPER */
    .jb-pagination-wrap {
        margin-top: 8px;
        padding: 16px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        display: flex;
        justify-content: center;
    }
    /* Override Laravel default pagination */
    .jb-pagination-wrap .pagination {
        margin: 0;
        gap: 4px;
    }
    .jb-pagination-wrap .page-link {
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
    .jb-pagination-wrap .page-link:hover {
        background: #f8fafc;
        color: #7e22ce;
    }
    .jb-pagination-wrap .page-item.active .page-link {
        background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%);
        color: #fff;
        box-shadow: 0 4px 7px -1px rgba(126, 34, 206, 0.25);
    }
    .jb-pagination-wrap .page-item.disabled .page-link {
        color: #cbd5e1;
        background: transparent;
    }
</style>

<div class="jb-page">

    {{-- HEADER --}}
    <div class="jb-header">
        <span class="jb-eyebrow">Career Opportunities</span>
        <h2 class="jb-title">Job Opportunities</h2>
        <p class="jb-subtitle">Discover and apply directly to premium jobs selected for your membership track.</p>
    </div>

    @if(session('error'))
        <div class="jb-alert">
            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ session('error') }}
        </div>
    @endif

    <div class="jb-layout">

        {{-- ============================================
             LEFT SIDEBAR — FILTERS
        ============================================= --}}
        <aside class="jb-sidebar">
            <div class="jb-sidebar-header">
                <h5 class="jb-sidebar-title"><i class="fas fa-sliders-h"></i> Filter Jobs</h5>
                <a href="{{ route('customer.job-links') }}" class="jb-reset">Reset All</a>
            </div>

            <form action="{{ route('customer.job-links') }}" method="GET" id="filterForm">

                {{-- Keyword --}}
                <div class="jb-field">
                    <label for="keyword" class="jb-label">Keyword</label>
                    <div class="jb-input-wrap">
                        <span class="jb-input-icon"><i class="fas fa-search"></i></span>
                        <input type="text" name="keyword" id="keyword"
                               value="{{ request('keyword') }}"
                               class="jb-input jb-input-icon-pad"
                               placeholder="Job title, company...">
                    </div>
                </div>

                {{-- Location --}}
                <div class="jb-field">
                    <label for="location" class="jb-label">Location</label>
                    <div class="jb-input-wrap">
                        <span class="jb-input-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" name="location" id="location"
                               value="{{ request('location') }}"
                               class="jb-input jb-input-icon-pad"
                               placeholder="City or Remote...">
                    </div>
                </div>

                {{-- Experience --}}
                <div class="jb-field">
                    <label for="experience" class="jb-label">Experience</label>
                    <select name="experience" id="experience" class="jb-select">
                        <option value="">Any Experience</option>
                        <option value="0-1 Years" {{ request('experience') === '0-1 Years' ? 'selected' : '' }}>0-1 Years (Entry Level)</option>
                        <option value="1-3 Years" {{ request('experience') === '1-3 Years' ? 'selected' : '' }}>1-3 Years</option>
                        <option value="2-5 Years" {{ request('experience') === '2-5 Years' ? 'selected' : '' }}>2-5 Years</option>
                        <option value="3-7 Years" {{ request('experience') === '3-7 Years' ? 'selected' : '' }}>3-7 Years</option>
                        <option value="4-8 Years" {{ request('experience') === '4-8 Years' ? 'selected' : '' }}>4-8 Years</option>
                        <option value="5-10 Years" {{ request('experience') === '5-10 Years' ? 'selected' : '' }}>5-10 Years (Senior)</option>
                    </select>
                </div>

                {{-- Category --}}
                <div class="jb-field">
                    <label for="category_id" class="jb-label">Category</label>
                    <select name="category_id" id="category_id" class="jb-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sort --}}
                <div class="jb-field">
                    <label for="sort" class="jb-label">Sort By</label>
                    <select name="sort" id="sort" class="jb-select">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Date: Newest First</option>
                        <option value="salary" {{ request('sort') === 'salary' ? 'selected' : '' }}>Salary: High to Low</option>
                        <option value="relevant" {{ request('sort') === 'relevant' ? 'selected' : '' }}>Relevance</option>
                    </select>
                </div>

                <button type="submit" class="jb-apply-btn">Apply Filters</button>
            </form>
        </aside>

        {{-- ============================================
             RIGHT — JOB LISTINGS
        ============================================= --}}
        <main>
            <div class="jb-list">

                @if($jobs->total() > 0)
                    <p class="jb-results-count">
                        Showing <strong>{{ $jobs->firstItem() }}–{{ $jobs->lastItem() }}</strong> of
                        <strong>{{ $jobs->total() }}</strong> opportunities
                    </p>
                @endif

                @forelse($jobs as $job)
                    <div class="jb-card">

                        <div class="jb-card-top">

                            {{-- Left: logo + info --}}
                            <div class="jb-card-main">
                                <div class="jb-logo">
                                    {{ substr($job->company_name ?? $job->title, 0, 1) }}
                                </div>
                                <div class="jb-info">
                                    <h6 class="jb-job-title">{{ $job->title }}</h6>
                                    <span class="jb-company">{{ $job->company_name ?? 'Confidential Recruiter' }}</span>

                                    <div class="jb-meta-row">
                                        @if($job->location)
                                            <span class="jb-meta-chip">
                                                <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                            </span>
                                        @endif
                                        @if($job->experience)
                                            <span class="jb-meta-chip">
                                                <i class="fas fa-briefcase"></i> {{ $job->experience }}
                                            </span>
                                        @endif
                                        @if($job->salary)
                                            <span class="jb-meta-chip">
                                                <i class="fas fa-wallet"></i> {{ $job->salary }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Right: date + CTA --}}
                            <div class="jb-card-right">
                                <span class="jb-date">{{ $job->posted_date }}</span>
                                <a href="{{ $job->job_url }}" target="_blank" rel="noopener noreferrer" class="jb-cta-btn">
                                    Apply Now <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Description --}}
                        @if($job->description)
                            <p class="jb-description">{{ strip_tags($job->description) }}</p>
                        @endif

                        {{-- Skills --}}
                        @if($job->skills && count($job->skills) > 0)
                            <div class="jb-skills">
                                @foreach($job->skills as $skill)
                                    <span class="jb-skill">{{ $skill }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    {{-- Empty state --}}
                    <div class="jb-empty">
                        <div class="jb-empty-icon"><i class="fas fa-briefcase"></i></div>
                        <h6>No jobs found</h6>
                        <p>
                            @if(request('keyword') || request('location') || request('experience') || request('category_id'))
                                No jobs match your current filters. Try clearing some filters or using different keywords.
                            @else
                                There are no job opportunities currently mapped to your active plan categories. Check back soon for new listings.
                            @endif
                        </p>
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if($jobs->hasPages())
                    <div class="jb-pagination-wrap">
                        {{ $jobs->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </main>

    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#filterForm").validate({
                rules: {
                    keyword: { maxlength: 100 },
                    location: { maxlength: 100 }
                },
                errorClass: "jb-error",
                errorElement: "span",
                submitHandler: function(form) { form.submit(); }
            });
        });
    </script>
@endpush