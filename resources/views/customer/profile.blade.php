@extends('layouts.app')

@section('content')
@php
    $activePlans = auth()->user()->getActivePurchasedPlans();
    $expiryDate = $activePlans->max('end_date');
    $formattedExpiry = $expiryDate ? $expiryDate->format('d M, Y') : 'N/A';

    $allowedResumeCategories = auth()->user()->getActivePurchasedPlanCategories('resume');
    $resumeCount = \App\Models\ResumeTemplate::where('status', 'active')
        ->whereHas('categories', function ($q) use ($allowedResumeCategories) {
            $q->whereIn('service_categories.id', $allowedResumeCategories);
        })->count();

    $allowedJobCategories = auth()->user()->getActivePurchasedPlanCategories('job-link');
    $jobCount = \App\Models\JobLink::where('status', 'active')
        ->whereHas('categories', function ($q) use ($allowedJobCategories) {
            $q->whereIn('service_categories.id', $allowedJobCategories);
        })->count();

    $allowedQuestionCategories = auth()->user()->getActivePurchasedPlanCategories('question');
    $questionCount = \App\Models\InterviewQuestion::where('status', 'active')
        ->whereHas('categories', function ($q) use ($allowedQuestionCategories) {
            $q->whereIn('service_categories.id', $allowedQuestionCategories);
        })->count();

    $pendingProfileRequest = \App\Models\CustomerUpdateRequest::where('customer_id', $user->id)
        ->where('status', 'pending')
        ->first();

    $initials = collect(explode(' ', trim($user->name)))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
    $hasResume    = auth()->user()->hasBenefitAccess('resume');
    $hasJobs      = auth()->user()->hasBenefitAccess('job-link');
    $hasQuestions = auth()->user()->hasBenefitAccess('question');
    $anyBenefit   = $hasResume || $hasJobs || $hasQuestions;
    $isActive     = strtolower($user->status) === 'active';
@endphp

<style>
@media (max-width: 640px) {
    .cta-wrap {
        flex: 1 1 100% !important;
        width: 100%;
        margin-top: 12px;
    }
    .cta-btn {
        display: block;
        width: 100%;
    }
}
</style>

<div class="w-full mx-auto">

    {{-- HERO BANNER --}}
    <div class="relative flex items-center p-0 mt-6 overflow-hidden bg-center bg-cover min-h-75 rounded-2xl"
         style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
        <span class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-pink-500 opacity-60"></span>
    </div>

    {{-- PROFILE CARD --}}
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">

    {{-- Avatar --}}
    <div style="width:72px; height:72px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:700; color:#fff; flex-shrink:0;"
         class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md">
        @if($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="profile"
                 style="width:100%; height:100%; object-fit:cover; border-radius:14px;" />
        @else
            {{ strtoupper($initials) ?: 'U' }}
        @endif
    </div>

    {{-- Name & role --}}
    <div style="flex:1 1 160px; min-width:0;">
        <h5 class="mb-1" style="word-break:normal; overflow-wrap:anywhere;">{{ $user->name }}</h5>
        <p class="mb-0 font-semibold leading-normal text-sm text-slate-500" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            {{ ucfirst($user->role->name ?? 'Customer') }}
            <span class="inline-block px-2 py-1 text-xs font-bold text-center text-white align-middle rounded-lg
                {{ $isActive ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300' }}">
                {{ ucfirst($user->status) }}
            </span>
        </p>
    </div>

   {{-- CTA button --}}
<div class="cta-wrap" style="flex-shrink:0;">
    <button type="button" onclick="openCallbackModal('direct')"
        class="cta-btn inline-block px-4 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all border-0 rounded-lg shadow-soft-md cursor-pointer leading-pro ease-soft-in bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85"
        style="white-space:nowrap;">
        Request Callback
    </button>
</div>

</div>
    </div>

</div>

<div class="w-full mx-auto mt-6">

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-gradient-to-tl from-red-600 to-orange-400">
            {{ session('error') }}
        </div>
    @endif
    @if($pendingProfileRequest)
        <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
            <i class="fas fa-info-circle mr-2"></i>
            Your profile update request is pending admin approval (submitted {{ $pendingProfileRequest->created_at->format('d M, Y H:i') }}).
        </div>
    @endif

    {{-- TWO-COLUMN ROW --}}
    <div class="flex flex-wrap -mx-3">

        {{-- LEFT: Membership --}}
        <div class="w-full max-w-full px-3 mb-6 xl:w-5/12 xl:flex-none">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-1">Membership</h6>
                    <p class="mb-0 text-sm leading-normal text-slate-400">Your plans and renewal date at a glance.</p>
                </div>
                <div class="flex-auto p-4">
                    <h6 class="mb-2 font-bold leading-tight uppercase text-xs text-slate-500">Active Memberships</h6>
                    <div class="flex flex-wrap mb-5">
                        @forelse($activePlans as $plan)
                            <span class="inline-block px-3 py-1 mb-2 mr-2 text-xs font-semibold border border-purple-200 rounded-full text-purple-700" style="background:rgba(124,58,237,0.07);">
                                <i class="fas fa-receipt mr-1"></i>{{ $plan->plan_name }}
                            </span>
                        @empty
                            <span class="text-sm italic text-slate-400">No active memberships yet.</span>
                        @endforelse
                    </div>
                    <div class="flex items-center p-3 border border-gray-100 rounded-xl" style="background:#f8f9fa;">
                        <div class="inline-flex items-center justify-center mr-3 text-purple-700 rounded-lg"
                             style="width:40px; height:40px; background:rgba(124,58,237,0.08); flex-shrink:0;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <p class="mb-0 font-bold leading-tight uppercase text-xs text-slate-400">Expires</p>
                            <h6 class="mb-0 text-sm">{{ $formattedExpiry }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Profile Info --}}
        <div class="w-full max-w-full px-3 mb-6 xl:w-7/12 xl:flex-none">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px;">
                        <div>
                            <h6 class="mb-1">Profile Information</h6>
                            <p class="mb-0 text-sm leading-normal text-slate-400">Member since {{ $user->created_at->format('d M Y') }}.</p>
                        </div>
                        <a href="{{ route('customer.profile.edit') }}"
                           class="inline-block px-3 py-2 text-xs font-semibold text-purple-700 border border-purple-200 rounded-lg cursor-pointer hover:scale-102"
                           style="background:rgba(124,58,237,0.07); white-space:nowrap; flex-shrink:0;">
                            <i class="fas fa-user-edit mr-1"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap -mx-3">
                        @php
                            $rows = [
                                ['Full Name',  $user->name,                                    'fas fa-user'],
                                ['Email',      $user->email,                                   'fas fa-envelope'],
                                ['Mobile',     $user->phone ?? 'N/A',                          'fas fa-phone'],
                                ['WhatsApp',   $user->whatsapp_number ?? 'N/A',                'fab fa-whatsapp'],
                                ['Address',    $user->customerDetail->address ?? 'N/A',        'fas fa-map-marker-alt'],
                                ['Location',   trim(($user->customerDetail->city ?? 'N/A').', '.($user->customerDetail->state ?? '').', '.($user->customerDetail->country ?? ''), ', '), 'fas fa-globe'],
                                ['Pincode',    $user->customerDetail->pincode ?? 'N/A',        'fas fa-hashtag'],
                            ];
                        @endphp
                        @foreach($rows as [$label, $value, $icon])
                            <div class="w-full max-w-full px-3 mb-4 md:w-6/12 md:flex-none">
                                <p class="mb-1 font-bold leading-tight uppercase text-xs text-slate-400">
                                    <i class="{{ $icon }} mr-1 text-purple-400"></i>{{ $label }}
                                </p>
                                <p class="mb-0 text-sm font-medium text-slate-700" style="word-break:break-word;">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                    <hr class="h-px my-3 bg-transparent bg-gradient-to-r from-transparent via-black/10 to-transparent" />
                    <div style="display:flex; align-items:center; gap:4px;">
                        <span class="font-bold leading-tight uppercase text-xs text-slate-400 mr-2">Social</span>
                        <a href="javascript:;" class="text-blue-800" style="padding:4px 8px;"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="javascript:;" class="text-sky-600" style="padding:4px 8px;"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="javascript:;" class="text-pink-600" style="padding:4px 8px;"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BENEFITS --}}
    <div class="flex-none w-full max-w-full mb-8">
        <div class="relative flex flex-col min-w-0 p-4 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="pb-3 mb-4 border-b border-gray-100">
                <h5 class="mb-1">Your Benefits</h5>
                <p class="mb-0 text-sm leading-normal text-slate-400">Everything unlocked by your active memberships.</p>
            </div>

            @if($anyBenefit)
                @php
                    $benefits = [];
                    if ($hasResume)    $benefits[] = ['fas fa-file-invoice', 'Resume Templates',   'ATS-friendly DOCX templates to build a professional CV.',                        $resumeCount,   route('customer.resume-templates')];
                    if ($hasJobs)      $benefits[] = ['fas fa-briefcase',    'Job Opportunities',   'Apply directly to verified job listings matched to your profile.',               $jobCount,      route('customer.job-links')];
                    if ($hasQuestions) $benefits[] = ['fas fa-graduation-cap','Interview Q&As',     'Practice technical questions with expert answers in your categories.',           $questionCount, route('customer.interview-questions')];
                @endphp
                <div class="flex flex-wrap -mx-3">
                    @foreach($benefits as [$icon, $title, $desc, $count, $href])
                        <div class="w-full max-w-full px-3 mb-4 md:w-6/12 lg:w-4/12 md:flex-none">
                            <div class="flex flex-col justify-between h-full border border-gray-100 rounded-xl shadow-soft-sm"
     style="padding:24px; transition: box-shadow .2s, border-color .2s;">
                                <div class="mb-4">
                                    <div class="inline-flex items-center justify-center mb-3 text-purple-700 rounded-xl"
                                         style="width:48px; height:48px; background:rgba(124,58,237,0.08);">
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                    <h6 class="mb-1">{{ $title }}</h6>
                                    <p class="mb-0 text-sm leading-normal text-slate-400">{{ $desc }}</p>
                                </div>
                                <div class="pt-3 mt-3 border-t border-gray-100" style="display:flex; align-items:center; justify-content:space-between;">
                                    <span class="inline-block px-3 py-1 text-xs font-bold text-purple-700 border border-purple-200 rounded-full"
                                          style="background:rgba(124,58,237,0.07);">
                                        {{ $count }} Available
                                    </span>
                                    <a href="{{ $href }}"
                                       class="inline-block px-4 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all border-0 rounded-lg shadow-soft-md cursor-pointer leading-pro ease-soft-in bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                                        Access
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <div class="inline-flex items-center justify-center mb-4 text-purple-400 rounded-2xl"
                         style="width:60px; height:60px; background:rgba(124,58,237,0.08);">
                        <i class="fas fa-layer-group fa-lg"></i>
                    </div>
                    <h6 class="mb-1">No benefits unlocked yet</h6>
                    <p class="max-w-sm mx-auto mb-4 text-sm leading-normal text-slate-400">Activate a membership to access resume templates, job listings, and interview prep.</p>
                    <button type="button" onclick="openCallbackModal('direct')"
                        class="inline-block px-5 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all border-0 rounded-lg shadow-soft-md cursor-pointer leading-pro ease-soft-in bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                        Talk to Us
                    </button>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection