@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3 mb-8">
        <div class="w-full max-w-full px-3">
            <h2 class="text-[32px] font-bold text-slate-800 leading-tight mb-2">Job Opportunities</h2>
            <p class="text-[14px] text-slate-500 mb-0">Discover and apply directly to premium jobs selected for your membership track.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-[10px] text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-wrap -mx-3">
        <!-- Left Filter Panel (30% width on large screens) -->
        <div class="w-full lg:w-3/10 max-w-full px-3 mb-6 lg:mb-0">
            <div class="lg:sticky lg:top-6 bg-white border border-slate-100 shadow-soft-xl rounded-[16px] p-6">
                <div class="flex justify-between items-center mb-6">
                    <h5 class="text-[18px] font-bold text-slate-800 mb-0">Filter Jobs</h5>
                    <a href="{{ route('customer.job-links') }}" class="text-[14px] text-purple-600 hover:text-purple-800 font-semibold transition-all">Reset All</a>
                </div>

                <form action="{{ route('customer.job-links') }}" method="GET" class="space-y-4" id="filterForm">
                    <!-- Keyword Search -->
                    <div>
                        <label for="keyword" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Keyword</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <i class="fas fa-search text-xs"></i>
                            </span>
                            <input type="text" name="keyword" id="keyword" 
                                value="{{ request('keyword') }}"
                                class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all placeholder-slate-400"
                                placeholder="Job title, company...">
                        </div>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label for="location" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Location</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </span>
                            <input type="text" name="location" id="location" 
                                value="{{ request('location') }}"
                                class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all placeholder-slate-400"
                                placeholder="City or Remote...">
                        </div>
                    </div>

                    <!-- Experience Filter -->
                    <div>
                        <label for="experience" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Experience</label>
                        <select name="experience" id="experience" 
                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-slate-600 bg-white">
                            <option value="">Any Experience</option>
                            <option value="0-1 Years" {{ request('experience') === '0-1 Years' ? 'selected' : '' }}>0-1 Years (Entry Level)</option>
                            <option value="1-3 Years" {{ request('experience') === '1-3 Years' ? 'selected' : '' }}>1-3 Years</option>
                            <option value="2-5 Years" {{ request('experience') === '2-5 Years' ? 'selected' : '' }}>2-5 Years</option>
                            <option value="3-7 Years" {{ request('experience') === '3-7 Years' ? 'selected' : '' }}>3-7 Years</option>
                            <option value="4-8 Years" {{ request('experience') === '4-8 Years' ? 'selected' : '' }}>4-8 Years</option>
                            <option value="5-10 Years" {{ request('experience') === '5-10 Years' ? 'selected' : '' }}>5-10 Years (Senior)</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Category</label>
                        <select name="category_id" id="category_id" 
                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-slate-600 bg-white">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Sort By</label>
                        <select name="sort" id="sort" 
                            class="w-full px-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-slate-600 bg-white">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Date: Newest First</option>
                            <option value="salary" {{ request('sort') === 'salary' ? 'selected' : '' }}>Salary: High to Low</option>
                            <option value="relevant" {{ request('sort') === 'relevant' ? 'selected' : '' }}>Relevance</option>
                        </select>
                    </div>

                    <!-- Apply Button -->
                    <button type="submit" 
                        class="w-1/2 mt-4 px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold rounded-[10px] mx-2">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Job Listings Column (70% width on large screens) -->
        <div class="w-full lg:w-7/10 max-w-full px-3">
            <div class="flex flex-col gap-6">
                @forelse($jobs as $job)
                    <div class="bg-white border border-slate-100 hover:border-purple-300 shadow-soft-sm hover:shadow-soft-lg rounded-[16px] p-6 transition-all duration-300">
                        <div class="flex flex-col md:flex-row justify-between gap-4">
                            <!-- Job Header info -->
                            <div class="flex items-start gap-4">
                                <!-- Company Logo Initial circle -->
                                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center shrink-0 font-bold text-lg shadow-inner uppercase">
                                    {{ substr($job->company_name ?? $job->title, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <h6 class="text-[18px] font-bold text-slate-800 mb-0.5 leading-tight">{{ $job->title }}</h6>
                                    <span class="text-[14px] text-slate-600 font-semibold mb-2">{{ $job->company_name ?? 'Confidential Recruiter' }}</span>
                                    
                                    <!-- Job Attributes Grid Row -->
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-xs text-slate-600">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $job->location }}
                                        </span>

                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-xs text-slate-600">
                                            <i class="fas fa-briefcase"></i>
                                            {{ $job->experience }}
                                        </span>

                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-xs text-slate-600">
                                            <i class="fas fa-wallet"></i>
                                            {{ $job->salary }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right CTA & Meta Block -->
                            <div class="flex md:flex-col justify-between items-end shrink-0 gap-2">
                                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider">{{ $job->posted_date }}</span>
                                <a href="{{ $job->job_url }}" target="_blank" rel="noopener noreferrer"
                                   class="w-1/2 px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold rounded-[10px] mx-2">
                                    Apply Now &nbsp;<i class="fas fa-external-link-alt text-xxs"></i>
                                </a>
                            </div>
                            
                        </div>

                        <!-- Job Description Summary -->
                        @if($job->description)
                            <div class="mt-4 pt-4 border-t border-slate-50">
                                <p class="text-[14px] text-slate-500 mb-4 line-clamp-2 leading-relaxed">
                                    {{ strip_tags($job->description) }}
                                </p>
                            </div>
                        @endif

                        <!-- Skill Chips Badges -->
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach($job->skills as $skill)
                                <span class="px-2.5 py-1 text-xxs font-bold bg-slate-50 text-slate-600 rounded-full border border-slate-100">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <!-- Empty State card -->
                    <div class="bg-white border border-slate-100 shadow-soft-xl rounded-[16px] p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-4">
                            <i class="fas fa-briefcase text-2xl"></i>
                        </div>
                        <h6 class="text-[18px] font-bold text-slate-800 mb-1">No jobs found</h6>
                        <p class="text-[14px] text-slate-450 mb-0">No jobs found matching your criteria. Try adjusting your filter tags or search keyword.</p>
                    </div>
                @endforelse

                <!-- Pagination block -->
                @if($jobs->hasPages())
                    <div class="mt-4 p-4 bg-white border border-slate-100 shadow-soft-sm rounded-[16px] flex justify-center">
                        {{ $jobs->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Client side validation on search inputs
            $("#filterForm").validate({
                rules: {
                    keyword: {
                        maxlength: 100
                    },
                    location: {
                        maxlength: 100
                    }
                },
                errorClass: "text-red-500 text-xs mt-1 block",
                errorElement: "span",
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
