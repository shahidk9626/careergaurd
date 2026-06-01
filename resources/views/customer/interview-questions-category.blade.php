@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3 mb-8">
        <div class="w-full max-w-full px-3">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('customer.interview-questions') }}" class="text-xs font-bold text-purple-700 hover:text-purple-900 uppercase tracking-widest flex items-center gap-1.5 transition-colors">
                    <i class="fas fa-arrow-left"></i> Back to Prep Hub
                </a>
            </div>
            <h2 class="text-[32px] font-bold text-slate-800 leading-tight mb-2">{{ $category->name }} Q&As</h2>
            <p class="text-[14px] text-slate-500 mb-0">Browse curated interview questions, professional tips, and step-by-step explanations.</p>
        </div>
    </div>

    <!-- Filters Toolbar -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-[16px] bg-clip-border p-6 mb-8 border border-slate-100">
        <form action="{{ route('customer.interview-questions.category', $category->id) }}" method="GET" id="categoryFilterForm" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4 grow">
                <!-- Search Question -->
                <div class="relative min-w-[240px] grow md:grow-0">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" id="search" 
                        value="{{ request('search') }}"
                        class="w-full pl-9 pr-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all placeholder-slate-400"
                        placeholder="Search questions...">
                </div>

                <!-- Technology Filter -->
                <div class="min-w-[160px]">
                    <select name="technology" id="technology" onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-slate-600 bg-white">
                        <option value="">All Technologies</option>
                        @foreach($technologies as $tech)
                            <option value="{{ $tech }}" {{ request('technology') === $tech ? 'selected' : '' }}>{{ $tech }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Difficulty Filter -->
                <div class="min-w-[140px]">
                    <select name="difficulty" id="difficulty" onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-sm border border-slate-200 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all text-slate-600 bg-white">
                        <option value="">All Difficulties</option>
                        <option value="Easy" {{ request('difficulty') === 'Easy' ? 'selected' : '' }}>Easy</option>
                        <option value="Medium" {{ request('difficulty') === 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="Hard" {{ request('difficulty') === 'Hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                </div>
            </div>

            <!-- Clear button -->
            @if(request()->anyFilled(['search', 'technology', 'difficulty']))
                <a href="{{ route('customer.interview-questions.category', $category->id) }}"
                   class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest flex items-center gap-1 transition-colors">
                    <i class="fas fa-times-circle"></i> Clear Filters
                </a>
            @endif
        </form>
    </div>

    <!-- Accordion Questions List -->
    <div class="flex flex-col gap-4 mb-8">
        @forelse($questions as $question)
            @php
                $diff = $question->difficulty;
                $diffBadgeClass = 'bg-green-50 text-green-700 border-green-100';
                if ($diff === 'Medium') {
                    $diffBadgeClass = 'bg-amber-50 text-amber-700 border-amber-100';
                } elseif ($diff === 'Hard') {
                    $diffBadgeClass = 'bg-rose-50 text-rose-700 border-rose-100';
                }
            @endphp
            
            <details class="group bg-white border border-slate-100 rounded-[16px] shadow-soft-sm hover:shadow-soft-md transition-all duration-300 [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex items-center justify-between p-6 cursor-pointer select-none">
                    <div class="flex items-center gap-4 flex-wrap sm:flex-nowrap">
                        <!-- Difficulty Badge -->
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xxs font-bold uppercase tracking-wider border {{ $diffBadgeClass }} shrink-0">
                            {{ $diff }}
                        </span>
                        
                        <!-- Technology Badge -->
                        <span class="px-2 py-0.5 text-xxs font-bold bg-slate-50 text-slate-600 rounded-lg border border-slate-100 shrink-0">
                            {{ $question->technology }}
                        </span>

                        <!-- Question Title -->
                        <h6 class="text-[16px] font-bold text-slate-800 leading-tight mb-0 pr-6 group-hover:text-purple-700 transition-colors">
                            {{ $question->title }}
                        </h6>
                    </div>

                    <!-- Accordion Indicator arrow -->
                    <div class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center shrink-0 group-open:rotate-180 transition-transform duration-350">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </summary>

                <!-- Accordion Inner content -->
                <div class="px-6 pb-6 border-t border-slate-50/80">
                    <div class="pt-6 space-y-6">
                        <!-- Question Text -->
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-purple-700 uppercase tracking-widest">Question</span>
                            <div class="text-[15px] font-semibold text-slate-800 leading-relaxed bg-slate-50/50 p-4 rounded-xl border border-slate-100/50">
                                {!! nl2br(e($question->question_text)) !!}
                            </div>
                        </div>

                        <!-- Answer Summary -->
                        @if($question->answer_text)
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Short Answer</span>
                                <div class="text-[14px] text-slate-650 leading-relaxed">
                                    {!! nl2br(e($question->answer_text)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Explanation and Tips -->
                        @if($question->explanation)
                            <div class="space-y-2 bg-purple-50/30 p-5 rounded-xl border border-purple-100/50">
                                <span class="text-xs font-bold text-purple-700 uppercase tracking-widest flex items-center gap-1.5">
                                    <i class="fas fa-lightbulb"></i> Expert Explanation & Interview Tips
                                </span>
                                <p class="text-[14px] text-slate-600 leading-relaxed mb-0">
                                    {{ $question->explanation }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </details>
        @empty
            <!-- Empty state illustration card -->
            <div class="bg-white border border-slate-100 shadow-soft-xl rounded-[16px] p-12 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 mb-4">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </div>
                <h6 class="text-[18px] font-bold text-slate-805 mb-1">No questions found</h6>
                <p class="text-[14px] text-slate-450 mb-0">No questions match your current search queries or filters. Try adjusting them.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination block -->
    @if($questions->hasPages())
        <div class="p-4 bg-white border border-slate-100 shadow-soft-sm rounded-[16px] flex justify-center">
            {{ $questions->appends(request()->query())->links() }}
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Client side validation on search filters
            $("#categoryFilterForm").validate({
                rules: {
                    search: {
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
