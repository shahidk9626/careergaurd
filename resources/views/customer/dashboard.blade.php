@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            @if (auth()->user()->verification_status !== 'verified')
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-4">
                    <div class="flex-auto p-6 text-center">
                        <div class="mb-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-tl from-gray-900 to-slate-800 rounded-circle text-white">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                        </div>
                        <h5 class="font-bold mb-2">Application Submitted</h5>
                        <p class="mb-4">Your profile has been submitted successfully and is currently under verification.</p>
                        <p class="text-slate-500 font-semibold">Please wait for admin approval.</p>
                        
                        @if(auth()->user()->verification_status === 'rejected')
                            <div class="mt-4 p-4 bg-red-100 border border-red-200 rounded-xl">
                                <p class="text-red-600 font-bold mb-0">Verification Rejected</p>
                                <p class="text-red-500 text-sm mb-0">Please contact support or update your profile details.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
                    <div class="flex-auto p-6">
                        <div class="flex flex-wrap -mx-3">
                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                                <div class="flex flex-col h-full">
                                    <p class="pt-2 mb-1 font-semibold">Welcome Back,</p>
                                    <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                    <p class="mb-12">We are glad to have you here. Your profile is complete and you can now
                                        access all our services.</p>
                                    <div class="flex flex-wrap items-center gap-4 mt-auto mb-0">
                                        <a class="font-semibold leading-normal cursor-pointer group text-sm"
                                            href="{{ route('customer.purchased-plans') }}">
                                            View Purchased Memberships
                                            <i
                                                class="fas fa-arrow-right ease-bounce ml-1 text-sm transition-all group-hover:translate-x-1.25"></i>
                                        </a>
                                        <button type="button" onclick="openCallbackModal('direct')" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-soft-md cursor-pointer leading-pro ease-soft-in bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                                            Request Callback
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
                                <div class="h-full bg-gradient-to-tl from-gray-900 to-slate-800 rounded-xl">
                                    <img src="https://demos.creative-tim.com/soft-ui-dashboard-tailwind/assets/img/shapes/waves-white.svg"
                                        class="absolute top-0 hidden w-1/2 h-full lg:block" alt="waves" />
                                    <div class="relative flex items-center justify-center h-full">
                                        <img class="relative z-20 w-full pt-6"
                                            src="https://demos.creative-tim.com/soft-ui-dashboard-tailwind/assets/img/illustrations/rocket-white.png"
                                            alt="rocket" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $activePlans = auth()->user()->getActivePurchasedPlans();
                    $expiryDate = $activePlans->max('end_date');
                    $formattedExpiry = $expiryDate ? $expiryDate->format('d M, Y') : 'N/A';
                    
                    // Count available templates
                    $allowedResumeCategories = auth()->user()->getActivePurchasedPlanCategories('resume');
                    $resumeCount = \App\Models\ResumeTemplate::where('status', 'active')
                        ->whereHas('categories', function($q) use ($allowedResumeCategories) {
                            $q->whereIn('service_categories.id', $allowedResumeCategories);
                        })->count();
                        
                    // Count available job links
                    $allowedJobCategories = auth()->user()->getActivePurchasedPlanCategories('job-link');
                    $jobCount = \App\Models\JobLink::where('status', 'active')
                        ->whereHas('categories', function($q) use ($allowedJobCategories) {
                            $q->whereIn('service_categories.id', $allowedJobCategories);
                        })->count();
                        
                    // Count available interview questions
                    $allowedQuestionCategories = auth()->user()->getActivePurchasedPlanCategories('question');
                    $questionCount = \App\Models\InterviewQuestion::where('status', 'active')
                        ->whereHas('categories', function($q) use ($allowedQuestionCategories) {
                            $q->whereIn('service_categories.id', $allowedQuestionCategories);
                        })->count();
                @endphp

                <div class="relative flex flex-col min-w-0 break-words bg-white border border-slate-100 shadow-soft-xl rounded-[16px] bg-clip-border p-6 mt-6">
                    <div class="pb-3 mb-6 border-b border-slate-100">
                        <h5 class="text-[22px] font-bold text-slate-805 mb-1">Membership Overview & Benefits</h5>
                        <p class="text-[14px] text-slate-400 mb-0">Track your active memberships and access your verified benefits.</p>
                    </div>
                    
                    {{-- Stats Header Info Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="p-5 bg-slate-50/50 rounded-xl border border-slate-100 flex flex-col justify-center">
                            <span class="text-[10px] font-bold text-slate-405 uppercase tracking-wider mb-1.5">Active Memberships</span>
                            <div class="flex flex-wrap gap-2">
                                @forelse($activePlans as $plan)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-700 rounded-full text-xxs font-semibold border border-purple-100">
                                        <i class="fas fa-receipt text-[10px]"></i> {{ $plan->plan_name }}
                                    </span>
                                @empty
                                    <span class="text-[14px] text-slate-550 italic font-semibold">No active memberships.</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="p-5 bg-slate-50/50 rounded-xl border border-slate-100 flex flex-col justify-center">
                            <span class="text-[10px] font-bold text-slate-405 uppercase tracking-wider mb-1.5">Expiry Date</span>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-purple-650 text-xs"></i>
                                <span class="text-[14px] font-semibold text-slate-750">{{ $formattedExpiry }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Benefits Cards Row (3-column layout) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Resume Templates Widget --}}
                        @if(auth()->user()->hasBenefitAccess('resume'))
                            <div class="bg-white border border-slate-100 hover:border-purple-300 shadow-soft-sm hover:shadow-soft-lg rounded-[16px] p-6 flex flex-col justify-between transition-all duration-300">
                                <div class="mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-750 flex items-center justify-center shrink-0 mb-3 text-sm">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <h6 class="text-[18px] font-bold text-slate-805 mb-1.5">Resume Templates</h6>
                                    <p class="text-[14px] text-slate-405 mb-0">Get ATS-friendly DOCX templates to build a professional CV.</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                                    <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full border border-purple-100">
                                        {{ $resumeCount }} Available
                                    </span>
                                    <a href="{{ route('customer.resume-templates') }}" 
                                       class="h-[44px] px-[22px] font-semibold text-center text-white bg-gradient-to-tl from-purple-700 to-pink-500 rounded-[10px] hover:scale-102 transition-all border-0 text-[14px] flex items-center justify-center">
                                        Access
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Job Opportunities Widget --}}
                        @if(auth()->user()->hasBenefitAccess('job-link'))
                            <div class="bg-white border border-slate-100 hover:border-purple-300 shadow-soft-sm hover:shadow-soft-lg rounded-[16px] p-6 flex flex-col justify-between transition-all duration-300">
                                <div class="mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-750 flex items-center justify-center shrink-0 mb-3 text-sm">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <h6 class="text-[18px] font-bold text-slate-805 mb-1.5">Job Opportunities</h6>
                                    <p class="text-[14px] text-slate-405 mb-0">Apply directly to high-paying verified job listings mapped to your profile.</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                                    <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full border border-purple-100">
                                        {{ $jobCount }} Available
                                    </span>
                                    <a href="{{ route('customer.job-links') }}" 
                                       class="h-[44px] px-[22px] font-semibold text-center text-white bg-gradient-to-tl from-purple-700 to-pink-500 rounded-[10px] hover:scale-102 transition-all border-0 text-[14px] flex items-center justify-center">
                                        Access
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Interview Q&As Widget --}}
                        @if(auth()->user()->hasBenefitAccess('question'))
                            <div class="bg-white border border-slate-100 hover:border-purple-300 shadow-soft-sm hover:shadow-soft-lg rounded-[16px] p-6 flex flex-col justify-between transition-all duration-300">
                                <div class="mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-755 flex items-center justify-center shrink-0 mb-3 text-sm">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <h6 class="text-[18px] font-bold text-slate-805 mb-1.5">Interview Q&As</h6>
                                    <p class="text-[14px] text-slate-405 mb-0">Practice technical interview questions and expert answers in your categories.</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                                    <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full border border-purple-100">
                                        {{ $questionCount }} Available
                                    </span>
                                    <a href="{{ route('customer.interview-questions') }}" 
                                       class="h-[44px] px-[22px] font-semibold text-center text-white bg-gradient-to-tl from-purple-700 to-pink-500 rounded-[10px] hover:scale-102 transition-all border-0 text-[14px] flex items-center justify-center">
                                        Access
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection