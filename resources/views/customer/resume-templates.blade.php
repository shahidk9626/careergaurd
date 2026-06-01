@extends('layouts.app')

@section('content')
<!-- <div class="row">
    {{-- Portal Banner Header --}}
    <div class="col-12 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-[16px] bg-clip-border overflow-hidden">
            <span class="absolute inset-0 purple-pink-gradient-bg opacity-90" style="background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%);"></span>
            <div class="relative z-10 p-6 md:p-8 text-white flex flex-wrap justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <span class="px-3 py-1 mb-2 inline-block text-[9px] font-extrabold tracking-widest text-white uppercase bg-white/20 backdrop-blur-md rounded-full border border-white/10">
                        📄 Professional Document Templates
                    </span>
                    <h3 class="text-2xl font-extrabold text-white mb-1">Resume Templates Hub</h3>
                    <p class="text-xs text-purple-100 mb-0">Download high-converting Microsoft Word (.docx) templates optimized for ATS scanning.</p>
                </div>
                <a href="{{ route('customer.profile.check') }}" class="inline-flex items-center h-[44px] px-5 text-xxs font-bold text-slate-700 bg-white border rounded-[10px] hover:scale-102 transition-all">
                    <i class="fas fa-chevron-left mr-2 text-purple-650"></i> Back to Profile
                </a>
            </div>
        </div>
    </div>
</div> -->

{{-- Top Section: Header, Search, Categories, Page Size all aligned --}}
<div class="row mb-6">
    <div class="col-12">
        <div class="relative flex flex-col min-w-0 break-words bg-white border border-slate-100 shadow-soft-xl rounded-[16px] p-6">
            <form action="{{ route('customer.resume-templates') }}" method="GET" id="toolbarForm" class="flex flex-wrap gap-4 items-center justify-between w-full">
                <div class="flex-grow md:flex-initial">
                    <h5 class="font-bold text-slate-700 mb-0">Browse Resume Templates</h5>
                </div>
                
                <div class="flex flex-wrap gap-3 items-center flex-grow md:flex-initial justify-end">
                    {{-- Search Box --}}
                    <div class="relative flex flex-wrap items-stretch w-full md:w-auto min-w-[200px]">
                        <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" 
                            class="pl-8 text-sm focus:shadow-soft-primary-outline ease-soft w-full leading-5.6 relative -ml-px block rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" 
                            placeholder="Search templates..." />
                    </div>

                    {{-- Category Filter --}}
                    <div class="mt-2 relative w-full md:w-auto min-w-[150px]">
                        <select name="category_id" id="category_id" onchange="this.form.submit()" 
                            class="text-sm focus:shadow-soft-primary-outline ease-soft block w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Page Size Selector --}}
                    <div class="mt-2 relative w-full md:w-auto min-w-[120px]">
                        <select name="page_size" id="page_size" onchange="this.form.submit()" 
                            class="text-sm focus:shadow-soft-primary-outline ease-soft block w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow cursor-pointer">
                            <option value="9" {{ request('page_size', 9) == 9 ? 'selected' : '' }}>9 Per Page</option>
                            <option value="18" {{ request('page_size') == 18 ? 'selected' : '' }}>18 Per Page</option>
                            <option value="36" {{ request('page_size') == 36 ? 'selected' : '' }}>36 Per Page</option>
                        </select>
                    </div>

                    <button type="submit" class="mt-4 px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Templates Grid --}}
<div class="flex flex-wrap -mx-3 mt-4">
    @forelse($templates as $template)
        <div class="w-full max-w-full px-3 mb-6 md:w-6/12 lg:w-4/12 flex flex-col">
            <div class="bg-white border border-slate-100 hover:border-purple-300 shadow-soft-xl rounded-[16px] p-6 flex flex-col justify-between h-full transition-all duration-300 group hover:-translate-y-1">
                {{-- Preview Image --}}
                <div class="relative w-full aspect-[4/5] bg-slate-50 border border-slate-100 rounded-[12px] mb-4 overflow-hidden flex items-center justify-center">
                    @if($template->thumbnail)
                        <img src="{{ asset('storage/' . $template->thumbnail) }}" alt="{{ $template->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        {{-- Highly Styled Resume Mockup Graphic --}}
                        <div class="w-full h-full p-5 flex flex-col justify-between bg-gradient-to-br from-purple-50/40 via-white to-pink-50/20 text-slate-400 font-sans relative">
                            {{-- Header --}}
                            <div class="border-b border-slate-200 pb-3">
                                <div class="h-3 w-28 bg-slate-300 rounded mb-1.5"></div>
                                <div class="h-1.5 w-16 bg-slate-200 rounded"></div>
                            </div>
                            {{-- Body --}}
                            <div class="flex-grow py-4 space-y-3">
                                <div class="space-y-1.5">
                                    <div class="h-2 w-12 bg-purple-100 rounded"></div>
                                    <div class="h-1.5 w-full bg-slate-200 rounded"></div>
                                    <div class="h-1.5 w-5/6 bg-slate-200 rounded"></div>
                                </div>
                                <div class="space-y-1.5 pt-1">
                                    <div class="h-2 w-16 bg-pink-100 rounded"></div>
                                    <div class="h-1.5 w-full bg-slate-200 rounded"></div>
                                    <div class="h-1.5 w-11/12 bg-slate-200 rounded"></div>
                                </div>
                            </div>
                            {{-- Footer --}}
                            <div class="border-t border-slate-150 pt-2 flex justify-between items-center">
                                <div class="h-1.5 w-14 bg-slate-200 rounded"></div>
                                <div class="h-1.5 w-8 bg-slate-200 rounded"></div>
                            </div>
                            
                            {{-- Hover Glow Overlay --}}
                            <div class="absolute inset-0 bg-purple-700/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-lg text-purple-700 text-base transform scale-75 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fas fa-eye"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Template Information --}}
                <div class="flex-grow">
                    {{-- Category Badges --}}
                    <div class="flex flex-wrap gap-1.5 mb-2">
                        @foreach($template->categories as $c)
                            <span class="text-[9px] font-extrabold px-2 py-0.5 bg-purple-50 text-purple-750 rounded-[6px] border border-purple-100 uppercase tracking-wide">
                                {{ $c->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    {{-- Template Name --}}
                    <h6 class="font-bold text-slate-805 tracking-tight mb-2 text-sm leading-snug">{{ $template->title }}</h6>

                    {{-- Short Description --}}
                    @if($template->description)
                        <p class="text-[11px] text-slate-400 leading-relaxed line-clamp-2 mb-0">
                            {{ strip_tags($template->description) }}
                        </p>
                    @endif
                </div>

                {{-- Download Button --}}
                <div class="mt-4 pt-4 border-t border-slate-100 w-full">
                    <a href="{{ route('customer.resume-templates.download', $template->id) }}"
                       class="w-full px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold rounded-[10px] flex items-center justify-center gap-2">
                        <i class="fas fa-file-word text-sm"></i> Download (.DOCX)
                    </a>
                </div>
            </div>
        </div>
    @empty
        {{-- Empty State: Centered icon, short message, compact card, NOT a giant empty container --}}
        <div class="w-full px-4 py-6">
            <div class="max-w-md mx-auto text-center py-10 px-6 bg-white rounded-[16px] border border-slate-100 shadow-soft-xl">
                <div class="mb-4 text-purple-200 mt-2">
                    <i class="fas fa-file-invoice fa-3x animate-pulse"></i>
                </div>
                <h5 class="text-slate-705 font-bold text-sm">No templates found</h5>
                <p class="text-xs text-slate-400 max-w-xs mx-auto mt-1 mb-6">There are no resume templates currently mapped to your active plan categories.</p>
                <a href="{{ route('customer.resume-templates') }}" class="mt-4 px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold">
                    <i class="fas fa-undo"></i> Reset Filters
                </a>
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($templates->hasPages())
    <div class="row mt-8 mb-6">
        <div class="col-12 flex justify-center">
            <nav aria-label="Page navigation">
                <ul class="flex pl-0 list-none rounded-[10px] bg-white p-1.5 border border-slate-100 shadow-soft-lg">
                    @if ($templates->onFirstPage())
                        <li class="mx-0.5"><span class="flex items-center justify-center w-8 h-8 rounded-[8px] text-slate-300 cursor-not-allowed"><i class="fas fa-angle-left text-xs"></i></span></li>
                    @else
                        <li class="mx-0.5"><a href="{{ $templates->previousPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-[8px] text-slate-600 hover:bg-slate-50 transition-all"><i class="fas fa-angle-left text-xs"></i></a></li>
                    @endif

                    @foreach ($templates->getUrlRange(1, $templates->lastPage()) as $page => $url)
                        @if ($page == $templates->currentPage())
                            <li class="mx-0.5"><span class="flex items-center justify-center w-8 h-8 rounded-[8px] bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-extrabold shadow-soft-md text-[10px]">{{ $page }}</span></li>
                        @else
                            <li class="mx-0.5"><a href="{{ $url }}" class="flex items-center justify-center w-8 h-8 rounded-[8px] text-slate-505 hover:bg-slate-50 transition-all font-bold text-[10px]">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    @if ($templates->hasMorePages())
                        <li class="mx-0.5"><a href="{{ $templates->nextPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-[8px] text-slate-605 hover:bg-slate-50 transition-all"><i class="fas fa-angle-right text-xs"></i></a></li>
                    @else
                        <li class="mx-0.5"><span class="flex items-center justify-center w-8 h-8 rounded-[8px] text-slate-300 cursor-not-allowed"><i class="fas fa-angle-right text-xs"></i></span></li>
                    @endif
                </ul>
            </nav>
        </div>
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
