@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3 mb-8">
        <div class="w-full max-w-full px-3">
            <h2 class="text-[32px] font-bold text-slate-800 leading-tight mb-2">Resume Templates</h2>
            <p class="text-[14px] text-slate-500 mb-0">Download ATS-optimized premium resume templates designed to impress recruiters.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-[10px] text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Top Toolbar Card -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-[16px] bg-clip-border p-6 mb-8 border border-slate-100">
        <form action="{{ route('customer.resume-templates') }}" method="GET" id="toolbarForm" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4 grow">
                <!-- Search Input -->
                <div class="relative min-w-[240px]">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="keyword" id="keyword" 
                        value="{{ request('keyword') }}"
                        class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all placeholder-slate-400"
                        placeholder="Search templates...">
                </div>

                <!-- Category Select -->
                <div class="min-w-[180px]">
                    <select name="category_id" id="category_id" onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-slate-600 bg-white">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Page Size Selector -->
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Show:</span>
                <select name="page_size" id="page_size" onchange="this.form.submit()"
                    class="px-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-slate-600 bg-white">
                    <option value="9" {{ request('page_size', 9) == 9 ? 'selected' : '' }}>9</option>
                    <option value="18" {{ request('page_size') == 18 ? 'selected' : '' }}>18</option>
                    <option value="36" {{ request('page_size') == 36 ? 'selected' : '' }}>36</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($templates as $template)
            <div class="bg-white border border-slate-100 hover:border-purple-300 shadow-soft-sm hover:shadow-soft-lg rounded-[16px] overflow-hidden flex flex-col justify-between transition-all duration-300 group">
                
                <!-- Mockup Preview Image Container -->
                <div class="relative aspect-[3/4] bg-slate-50 border-b border-slate-100 flex items-center justify-center overflow-hidden">
                    @if($template->thumbnail)
                        <img src="{{ asset('storage/' . $template->thumbnail) }}" alt="{{ $template->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <!-- Premium Mock Thumbnail Fallback -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-pink-500/10 flex flex-col items-center justify-center p-6 text-center select-none">
                            <i class="fas fa-file-alt text-slate-300 text-5xl mb-4 group-hover:scale-110 group-hover:text-purple-400 transition-all"></i>
                            <span class="text-[14px] font-bold text-slate-700 leading-tight">{{ $template->title }}</span>
                            <span class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">Premium ATS Template</span>
                        </div>
                    @endif
                    <!-- Hover Overlay decoration -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-350">
                        <a href="{{ route('customer.resume-templates.download', $template->id) }}" 
                           class="h-[44px] px-[22px] font-semibold text-center text-white bg-gradient-to-tl from-purple-700 to-pink-500 rounded-[10px] hover:scale-105 transition-all border-0 text-[14px] flex items-center justify-center shadow-lg">
                            <i class="fas fa-download mr-2"></i> Download DOCX
                        </a>
                    </div>
                </div>

                <!-- Template Details -->
                <div class="p-6 flex flex-col grow justify-between">
                    <div>
                        <!-- Category Badges -->
                        <div class="flex flex-wrap gap-1.5 mb-2.5">
                            @foreach($template->categories as $category)
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-purple-50 text-purple-700 rounded-full border border-purple-100">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <h6 class="text-[18px] font-bold text-slate-805 mb-1.5 leading-snug group-hover:text-purple-700 transition-all">{{ $template->title }}</h6>
                        <p class="text-[14px] text-slate-450 mb-0 line-clamp-2 leading-relaxed">{{ $template->description ?? 'Professional resume layout designed to pass ATS screening algorithms and showcase skills.' }}</p>
                    </div>

                    <!-- Compact Download Button -->
                    <div class="mt-6 pt-4 border-t border-slate-50 flex justify-end">
                        <a href="{{ route('customer.resume-templates.download', $template->id) }}" 
                           class="h-[44px] px-[22px] font-semibold text-center text-white bg-gradient-to-tl from-purple-700 to-pink-500 rounded-[10px] hover:scale-102 transition-all border-0 text-[14px] flex items-center justify-center shadow-soft-sm cursor-pointer whitespace-nowrap">
                            <i class="fas fa-file-word mr-1.5"></i> Download
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <!-- Empty state element inside grid span -->
            <div class="col-span-full bg-white border border-slate-100 shadow-soft-xl rounded-[16px] p-12 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-4">
                    <i class="fas fa-file-invoice text-2xl"></i>
                </div>
                <h6 class="text-[18px] font-bold text-slate-805 mb-1">No templates found</h6>
                <p class="text-[14px] text-slate-450 mb-0">We couldn't find any templates matching your criteria. Try resetting filters or search query.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination block -->
    @if($templates->hasPages())
        <div class="p-4 bg-white border border-slate-100 shadow-soft-sm rounded-[16px] flex justify-center">
            {{ $templates->appends(request()->query())->links() }}
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Client side validation on search keyword
            $("#toolbarForm").validate({
                rules: {
                    keyword: {
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
