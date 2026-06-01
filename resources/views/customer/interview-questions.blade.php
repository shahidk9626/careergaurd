@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3 mb-8">
        <div class="w-full max-w-full px-3">
            <h2 class="text-[32px] font-bold text-slate-800 leading-tight mb-2">Interview Q&A Prep Hub</h2>
            <p class="text-[14px] text-slate-500 mb-0">Master your technical interviews with curated questions, explanations, and model answers.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-[10px] text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Technology Quick Badges (4-column on desktop) -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-[16px] bg-clip-border p-6 mb-8 border border-slate-100">
        <h5 class="text-[18px] font-bold text-slate-800 mb-4">Technologies Available</h5>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($techCounts as $tech => $count)
                <div class="flex items-center gap-3 p-4 bg-slate-50 hover:bg-purple-50/50 rounded-xl border border-slate-100 hover:border-purple-200 transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-lg bg-white shadow-soft-sm flex items-center justify-center text-purple-600 font-bold group-hover:scale-110 transition-transform">
                        <i class="fas fa-code text-xs"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-slate-700 leading-tight">{{ $tech }}</span>
                        <span class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ $count }} {{ Str::plural('Question', $count) }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-4 text-center text-xs text-slate-400 italic">No technologies defined.</div>
            @endforelse
        </div>
    </div>

    <!-- Category Topics Grid (3-column on desktop) -->
    <div class="mb-4">
        <h4 class="text-[22px] font-bold text-slate-800 mb-4">Preparation Tracks</h4>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($categories as $category)
            <div class="bg-white border border-slate-100 hover:border-purple-300 shadow-soft-sm hover:shadow-soft-lg rounded-[16px] p-6 flex flex-col justify-between transition-all duration-300 group">
                <div>
                    <!-- Track Header -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center shrink-0 text-sm font-semibold shadow-inner">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xxs font-bold text-purple-700 uppercase tracking-widest">Active Track</span>
                            <h6 class="text-[18px] font-bold text-slate-805 leading-snug group-hover:text-purple-700 transition-all mb-0">{{ $category->name }}</h6>
                        </div>
                    </div>
                    
                    <p class="text-[14px] text-slate-450 leading-relaxed mb-6">
                        Practice interview Q&As for {{ $category->name }}. Review complete explanations, structural tips, and best practices.
                    </p>
                </div>

                <!-- Footer & CTA Actions -->
                <div class="pt-4 border-t border-slate-50 flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Questions</span>
                        <span class="text-xs font-bold text-slate-700">{{ $category->interview_questions_count }} Curated</span>
                    </div>

                    <a href="{{ route('customer.interview-questions.category', $category->id) }}"
                       class="h-[44px] px-[22px] font-semibold text-center text-white bg-gradient-to-tl from-purple-700 to-pink-500 rounded-[10px] hover:scale-102 transition-all border-0 text-[14px] flex items-center justify-center shadow-soft-sm cursor-pointer whitespace-nowrap">
                        Practice Track
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-100 shadow-soft-xl rounded-[16px] p-12 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-4">
                    <i class="fas fa-question-circle text-2xl"></i>
                </div>
                <h6 class="text-[18px] font-bold text-slate-805 mb-1">No tracks available</h6>
                <p class="text-[14px] text-slate-450 mb-0">You don't have access to any interview prep tracks under your active memberships.</p>
            </div>
        @endforelse
    </div>
@endsection
