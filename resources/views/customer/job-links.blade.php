@extends('layouts.app')

@section('content')

<style>
    .jb-page { font-family: inherit; }

    /* HEADER */
    .jb-header { margin-bottom: 24px; }
    .jb-eyebrow { display: inline-block; font-size: 10px; font-weight: 700; letter-spacing: 0.15em; color: #7e22ce; text-transform: uppercase; margin-bottom: 6px; }
    .jb-title { font-size: 28px; font-weight: 800; color: #1e293b; margin: 0 0 6px 0; letter-spacing: -0.02em; line-height: 1.2; }
    .jb-subtitle { font-size: 14px; color: #64748b; margin: 0; }

    /* ALERT */
    .jb-alert { margin-bottom: 24px; padding: 14px 18px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; color: #b91c1c; font-size: 13px; }

    /* LAYOUT */
    .jb-layout { display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }
    @media (max-width: 1023px) { .jb-layout { grid-template-columns: 1fr; } }

    /* SIDEBAR */
    /* REPLACE YOUR EXISTING .jb-sidebar WITH THIS EXACT BLOCK */
.jb-sidebar { 
    position: sticky; 
    top: 24px; 
    
    /* THE DESKTOP SCROLL FIX */
    height: calc(100vh - 48px); /* Forces exact height instead of max-height */
    min-height: 0; /* Critical: overrides CSS Grid intrinsic sizing */
    overflow-y: auto; /* Triggers the scrollbar */
    overscroll-behavior: contain; /* Stops background scrolling when you hit the bottom */
    
    /* ORIGINAL STYLES */
    background: #fff; 
    border: 1px solid #f1f5f9; 
    border-radius: 16px; 
    padding: 24px; 
    box-shadow: 0 20px 27px 0 rgba(0,0,0,0.05); 
}

/* SIDEBAR SCROLLBAR STYLING */
.jb-sidebar::-webkit-scrollbar {
    width: 5px;
}
.jb-sidebar::-webkit-scrollbar-track {
    background: transparent;
}
.jb-sidebar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.jb-sidebar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
    @media (max-width: 1023px) { .jb-sidebar { position: static; } }
    .jb-sidebar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; }
    .jb-sidebar-title { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; }
    .jb-sidebar-title i { color: #7e22ce; font-size: 13px; }
    .jb-reset { font-size: 12px; font-weight: 700; color: #7e22ce; text-decoration: none; transition: color 0.2s; }
    .jb-reset:hover { color: #581c87; }

    .jb-field { margin-bottom: 14px; }
    .jb-label { display: block; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin-bottom: 6px; }
    .jb-input, .jb-select { width: 100%; height: 40px; padding: 0 12px; font-size: 13px; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; transition: all 0.2s; box-sizing: border-box; }
    .jb-input:focus, .jb-select:focus { border-color: #c084fc; background: #fff; box-shadow: 0 0 0 3px rgba(192,132,252,0.15); }
    .jb-input-wrap { position: relative; }
    .jb-input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; pointer-events: none; }
    .jb-input-icon-pad { padding-left: 36px; }

    /* Section divider inside sidebar */
    .jb-section-label { font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #c084fc; margin: 16px 0 10px 0; padding-top: 14px; border-top: 1px solid #f1f5f9; }

    .jb-apply-btn { width: 100%; height: 42px; font-size: 12px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #fff; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 10px; cursor: pointer; box-shadow: 0 4px 7px -1px rgba(126,34,206,0.25); transition: all 0.2s; margin-top: 6px; }
    .jb-apply-btn:hover { opacity: 0.92; transform: translateY(-1px); }

    /* Active filter chips */
    .jb-active-filters { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
    .jb-filter-chip { display: inline-flex; align-items: center; gap: 5px; height: 24px; padding: 0 10px; background: #faf5ff; color: #7e22ce; border: 1px solid #e9d5ff; border-radius: 999px; font-size: 11px; font-weight: 600; }
    .jb-filter-chip a { color: #7e22ce; text-decoration: none; margin-left: 2px; font-size: 10px; }

    /* JOB LIST */
    .jb-list { display: flex; flex-direction: column; gap: 16px; }
    .jb-results-count { font-size: 12px; color: #64748b; margin-bottom: 4px; }
    .jb-results-count strong { color: #334155; font-weight: 700; }

    /* JOB CARD */
    .jb-card { background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04); transition: all 0.3s; }
    .jb-card:hover { border-color: #d8b4fe; transform: translateY(-2px); box-shadow: 0 20px 25px -5px rgba(126,34,206,0.1); }
    .jb-card-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap; }
    .jb-card-main { display: flex; gap: 16px; flex: 1; min-width: 0; }
    .jb-logo { flex-shrink: 0; width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%); color: #7e22ce; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px; text-transform: uppercase; border: 1px solid #f3e8ff; }
    .jb-info { flex: 1; min-width: 0; }
    .jb-job-title { font-size: 17px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0; line-height: 1.3; }
    .jb-company { font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 12px; display: block; }
    .jb-meta-row { display: flex; flex-wrap: wrap; gap: 6px; }
    .jb-meta-chip { 
    display: inline-flex; 
    align-items: center; 
    gap: 6px; 
    min-height: 26px; /* Changed from fixed height so it CAN grow if absolutely necessary */
    padding: 4px 10px; /* Added vertical padding for breathing room */
    background: #f8fafc; 
    border: 1px solid #f1f5f9; 
    border-radius: 999px; 
    font-size: 11px; 
    color: #475569; 
    font-weight: 500; 
    white-space: nowrap; /* CRITICAL: Forces text to stay on one line so the whole chip wraps instead of the text */
}
    .jb-meta-chip i { font-size: 10px; color: #94a3b8; }

    /* RIGHT SIDE */
    .jb-card-right { display: flex; flex-direction: column; align-items: flex-end; gap: 12px; flex-shrink: 0; }
    @media (max-width: 640px) { .jb-card-right { flex-direction: row; align-items: center; justify-content: space-between; width: 100%; } }
    .jb-date { font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap; }
    .jb-cta-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 40px; padding: 0 20px; font-size: 12px; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: #fff; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border-radius: 10px; text-decoration: none; box-shadow: 0 4px 7px -1px rgba(126,34,206,0.25); transition: all 0.2s; white-space: nowrap; }
    .jb-cta-btn:hover { opacity: 0.92; color: #fff; transform: translateY(-1px); }
    .jb-cta-btn i { font-size: 10px; }

    /* DESCRIPTION */
    .jb-description { margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 13px; color: #64748b; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* EMPTY STATE */
    .jb-empty { background: #fff; border: 1px dashed #e2e8f0; border-radius: 16px; padding: 48px 32px; text-align: center; }
    .jb-empty-icon { width: 72px; height: 72px; margin: 0 auto 16px; background: #faf5ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #d8b4fe; font-size: 28px; }
    .jb-empty h6 { font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; }
    .jb-empty p { font-size: 13px; color: #64748b; max-width: 380px; margin: 0 auto; line-height: 1.6; }

    /* PAGINATION */
    .jb-pagination-wrap { margin-top: 8px; padding: 16px; background: #fff; border: 1px solid #f1f5f9; border-radius: 16px; display: flex; justify-content: center; }
    .jb-pagination-wrap .pagination { margin: 0; gap: 4px; }
    .jb-pagination-wrap .page-link { min-width: 36px; height: 36px; padding: 0 10px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px !important; font-size: 12px; font-weight: 600; color: #475569; border: none; background: transparent; }
    .jb-pagination-wrap .page-link:hover { background: #f8fafc; color: #7e22ce; }
    .jb-pagination-wrap .page-item.active .page-link { background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); color: #fff; box-shadow: 0 4px 7px -1px rgba(126,34,206,0.25); }
    .jb-pagination-wrap .page-item.disabled .page-link { color: #cbd5e1; background: transparent; }
    .jb-btn-group {
    display: flex;
    gap: 10px; /* Space between the two buttons */
    flex-wrap: wrap; /* Prevents overflow on extremely small screens */
    align-items: center;
}

/* Optional: Ensures the wrapper aligns correctly on mobile view if you have a mobile media query for jb-card-right */
@media (max-width: 640px) { 
    .jb-btn-group {
        justify-content: flex-end;
    }
}
/* ===== JOB CARD — MOBILE ===== */
@media (max-width: 640px) {
    .jb-card {
        padding: 18px;
    }
    .jb-card-top {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
    }
    .jb-card-right {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        gap: 12px;
    }
    .jb-date {
        order: -1;            /* date sits above buttons */
        align-self: flex-start;
    }
    .jb-btn-group {
        flex-direction: column;
        width: 100%;
        gap: 10px;
    }
    .jb-btn-group .jb-cta-btn {
        width: 100%;
    }
}
@media (max-width: 640px) {
    .jb-card-main { flex-wrap: wrap; }
    .jb-meta-row { flex-basis: 100%; width: 100%; }
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
        <div class="jb-alert"><i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>{{ session('error') }}</div>
    @endif

    {{-- Active filter chips --}}
    @if(request()->anyFilled(['keyword','location','city','state','experience','category_id']))
        <div class="jb-active-filters">
            @if(request('keyword'))
                <span class="jb-filter-chip"><i class="fas fa-search" style="font-size:9px;"></i> "{{ request('keyword') }}" <a href="{{ request()->fullUrlWithoutQuery(['keyword','page']) }}">×</a></span>
            @endif
            @if(request('location'))
                <span class="jb-filter-chip"><i class="fas fa-map-marker-alt" style="font-size:9px;"></i> {{ request('location') }} <a href="{{ request()->fullUrlWithoutQuery(['location','page']) }}">×</a></span>
            @endif
            @if(request('city'))
                <span class="jb-filter-chip"><i class="fas fa-city" style="font-size:9px;"></i> {{ request('city') }} <a href="{{ request()->fullUrlWithoutQuery(['city','page']) }}">×</a></span>
            @endif
            @if(request('state'))
                <span class="jb-filter-chip"><i class="fas fa-map" style="font-size:9px;"></i> {{ request('state') }} <a href="{{ request()->fullUrlWithoutQuery(['state','page']) }}">×</a></span>
            @endif
            @if(request('experience'))
                <span class="jb-filter-chip"><i class="fas fa-briefcase" style="font-size:9px;"></i> {{ request('experience') }} <a href="{{ request()->fullUrlWithoutQuery(['experience','page']) }}">×</a></span>
            @endif
            @if(request('category_id'))
                @php $activeCat = $categories->firstWhere('id', request('category_id')); @endphp
                @if($activeCat)
                    <span class="jb-filter-chip"><i class="fas fa-tag" style="font-size:9px;"></i> {{ $activeCat->name }} <a href="{{ request()->fullUrlWithoutQuery(['category_id','page']) }}">×</a></span>
                @endif
            @endif
            <a href="{{ route('customer.job-links') }}" style="font-size:11px;font-weight:700;color:#94a3b8;text-decoration:none;margin-left:4px;">Clear all</a>
        </div>
    @endif

    <div class="jb-layout">

        {{-- SIDEBAR — FILTERS --}}
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
                        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" class="jb-input jb-input-icon-pad" placeholder="Job title, company...">
                    </div>
                </div>

                <p class="jb-section-label">Location</p>

                {{-- Location --}}
                <div class="jb-field">
                    <label for="location" class="jb-label">Location (General)</label>
                    <div class="jb-input-wrap">
                        <span class="jb-input-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" name="location" id="location" value="{{ request('location') }}" class="jb-input jb-input-icon-pad" placeholder="e.g. Remote, Delhi NCR...">
                    </div>
                </div>

                {{-- City --}}
                <div class="jb-field">
                    <label for="city" class="jb-label">City</label>
                    <div class="jb-input-wrap">
                        <span class="jb-input-icon"><i class="fas fa-city"></i></span>
                        <input type="text" name="city" id="city" value="{{ request('city') }}" class="jb-input jb-input-icon-pad" placeholder="e.g. Bengaluru">
                    </div>
                </div>

                {{-- State --}}
                <div class="jb-field">
                    <label for="state" class="jb-label">State</label>
                    <div class="jb-input-wrap">
                        <span class="jb-input-icon"><i class="fas fa-map"></i></span>
                        <input type="text" name="state" id="state" value="{{ request('state') }}" class="jb-input jb-input-icon-pad" placeholder="e.g. Karnataka">
                    </div>
                </div>

                <p class="jb-section-label">Job Details</p>

                {{-- Experience --}}
                <div class="jb-field">
                    <label for="experience" class="jb-label">Experience</label>
                    <select name="experience" id="experience" class="jb-select">
                        <option value="">Any Experience</option>
                        <option value="0-1 Years"  {{ request('experience') === '0-1 Years'  ? 'selected' : '' }}>0-1 Years (Entry Level)</option>
                        <option value="1-3 Years"  {{ request('experience') === '1-3 Years'  ? 'selected' : '' }}>1-3 Years</option>
                        <option value="2-5 Years"  {{ request('experience') === '2-5 Years'  ? 'selected' : '' }}>2-5 Years</option>
                        <option value="3-7 Years"  {{ request('experience') === '3-7 Years'  ? 'selected' : '' }}>3-7 Years</option>
                        <option value="4-8 Years"  {{ request('experience') === '4-8 Years'  ? 'selected' : '' }}>4-8 Years</option>
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
                        <option value="latest"   {{ request('sort', 'latest') === 'latest'   ? 'selected' : '' }}>Date: Newest First</option>
                        <option value="salary"   {{ request('sort') === 'salary'   ? 'selected' : '' }}>Salary: High to Low</option>
                        <option value="relevant" {{ request('sort') === 'relevant' ? 'selected' : '' }}>Relevance</option>
                    </select>
                </div>

                <button type="submit" class="jb-apply-btn">Apply Filters</button>
            </form>
        </aside>

        {{-- JOB LISTINGS --}}
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
                            <div class="jb-card-main">
                                <div class="jb-logo">
                                    {{ substr($job->company_name ?? $job->job_title ?? $job->title, 0, 1) }}
                                </div>
                                <div class="jb-info">
                                    <h6 class="jb-job-title">{{ $job->job_title ?? $job->title }}</h6>
                                    <span class="jb-company">{{ $job->company_name ?? 'Confidential Recruiter' }}</span>
                                    <div class="jb-meta-row">
                                        @if($job->location)
                                            <span class="jb-meta-chip"><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</span>
                                        @endif
                                        @if($job->city)
                                            <span class="jb-meta-chip"><i class="fas fa-city"></i> {{ $job->city }}{{ $job->state ? ', ' . $job->state : '' }}</span>
                                        @elseif($job->state)
                                            <span class="jb-meta-chip"><i class="fas fa-map"></i> {{ $job->state }}</span>
                                        @endif
                                        @if($job->experience)
                                            <span class="jb-meta-chip"><i class="fas fa-briefcase"></i> {{ $job->experience }}</span>
                                        @endif
                                        @if($job->salary)
                                            <span class="jb-meta-chip"><i class="fas fa-wallet"></i> {{ $job->salary }}</span>
                                        @endif
                                        @if($job->vacancies)
                                            <span class="jb-meta-chip"><i class="fas fa-users"></i> {{ $job->vacancies }} Vacancies</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="jb-card-right">
    <span class="jb-date">{{ $job->posted_date }}</span>
    
    {{-- NEW WRAPPER TO FORCE BUTTONS INTO ONE LINE --}}
    <div class="jb-btn-group">
        @if($job->mobile_number)
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $job->mobile_number);
                if (strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;
                $waMessage = 'Hello, I am interested in the ' . ($job->job_title ?? $job->title) . ' job position.';
                if ($job->company_name) $waMessage .= ' at ' . $job->company_name;
                $waUrl = 'https://wa.me/' . $cleanPhone . '?text=' . rawurlencode($waMessage);
            @endphp
            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="jb-cta-btn" style="background:linear-gradient(310deg,#128c7e 0%,#25d366 100%);box-shadow:0 4px 7px -1px rgba(37,211,102,0.25);">
                Apply via WhatsApp <i class="fab fa-whatsapp" style="font-size:12px;margin-left:4px;"></i>
            </a>
        @endif

        @if($job->job_url)
            <a href="{{ $job->job_url }}" target="_blank" rel="noopener noreferrer" class="jb-cta-btn">
                Apply Now <i class="fas fa-external-link-alt" style="margin-left:4px;"></i>
            </a>
        @endif
    </div>
</div>
                        </div>

                        {{-- Contact Details --}}
                        @if($job->contact_person_name || $job->mobile_number || $job->apply_whatsapp_or_email)
                            <div style="margin-top:16px;padding:12px 16px;background:#f8fafc;border-radius:12px;border:1px dashed #e2e8f0;font-size:13px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:8px;">
                                @if($job->contact_person_name)
                                    <div><strong style="color:#475569;"><i class="fas fa-user-tie" style="margin-right:6px;color:#94a3b8;"></i> Contact Person:</strong> <span style="color:#334155;font-weight:500;">{{ $job->contact_person_name }}</span></div>
                                @endif
                                @if($job->mobile_number)
                                    <div><strong style="color:#475569;"><i class="fab fa-whatsapp" style="margin-right:6px;color:#25d366;"></i> Mobile / WhatsApp:</strong> <span style="color:#334155;font-weight:500;">{{ $job->mobile_number }}</span></div>
                                @endif
                                @if($job->apply_whatsapp_or_email)
                                    <div><strong style="color:#475569;"><i class="fas fa-envelope-open-text" style="margin-right:6px;color:#94a3b8;"></i> Apply Info:</strong> <span style="color:#334155;font-weight:500;">{{ $job->apply_whatsapp_or_email }}</span></div>
                                @endif
                            </div>
                        @endif

                        @if($job->description)
                            <p class="jb-description">{{ strip_tags($job->description) }}</p>
                        @endif
                    </div>
                @empty
                    <div class="jb-empty">
                        <div class="jb-empty-icon"><i class="fas fa-briefcase"></i></div>
                        <h6>No jobs found</h6>
                        <p>
                            @if(request()->anyFilled(['keyword','location','city','state','experience','category_id']))
                                No jobs match your current filters. Try clearing some filters or using different keywords.
                            @else
                                There are no job opportunities currently mapped to your active plan categories. Check back soon for new listings.
                            @endif
                        </p>
                    </div>
                @endforelse

                @if($jobs->hasPages())
    <div class="jb-pagination-wrap">
        <nav aria-label="Page navigation">
            <ul class="flex pl-0 list-none rounded-lg" style="gap:4px; margin:0;">
                {{-- Previous --}}
                @if ($jobs->onFirstPage())
                    <li>
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-300 cursor-not-allowed">
                            <i class="fas fa-angle-left"></i>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $jobs->appends(request()->query())->previousPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Numbers --}}
                @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                    @if ($page == $jobs->currentPage())
                        <li>
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-bold shadow-soft-md">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}&{{ http_build_query(request()->except('page')) }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($jobs->hasMorePages())
                    <li>
                        <a href="{{ $jobs->appends(request()->query())->nextPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-300 cursor-not-allowed">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
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
                keyword:  { maxlength: 100 },
                location: { maxlength: 100 },
                city:     { maxlength: 100 },
                state:    { maxlength: 100 },
            },
            errorClass: "jb-error",
            errorElement: "span",
            submitHandler: function(form) { form.submit(); }
        });
    });
</script>
@endpush