@extends('layouts.app')

@section('content')
<div class="w-full mx-auto">
    <div class="relative flex items-center p-0 mt-6 overflow-hidden bg-center bg-cover min-h-75 rounded-2xl"
        style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
        <span class="absolute inset-y-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-pink-500 opacity-60"></span>
    </div>
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-6 -mt-16 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white/80 bg-clip-border backdrop-blur-2xl backdrop-saturate-200">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3">
                    <div class="text-base ease-soft-in-out h-18.5 w-18.5 relative inline-flex items-center justify-center rounded-xl text-white transition-all duration-200">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl" />
                        @else
                            <img src="{{ asset('assets/img/bruce-mars.jpg') }}" alt="profile_image" class="w-full shadow-soft-sm rounded-xl" />
                        @endif
                    </div>
                </div>
                <div class="flex-none w-auto max-w-full px-3 my-auto">
                    <div class="h-full">
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <p class="mb-0 font-semibold leading-normal text-sm">
                            {{ ucfirst($user->role->name ?? 'Customer') }}
                        </p>
                    </div>
                </div>
                <div class="flex-none w-auto max-w-full px-3 my-auto sm:ml-auto">
                    <button type="button" onclick="openCallbackModal('direct')" class="inline-block px-4 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-soft-md cursor-pointer leading-pro ease-soft-in bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                        Request Callback
                    </button>
                </div>
                <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12">
                    <div class="relative right-0">
                        <ul class="relative flex flex-wrap p-1 list-none bg-transparent rounded-xl" nav-pills role="tablist">
                            <li class="z-30 flex-auto text-center">
                                <a class="z-30 block w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700"
                                    nav-link active href="javascript:;" role="tab" aria-selected="true">
                                    <i class="fas fa-cube text-slate-700 text-sm"></i>
                                    <span class="ml-1">Overview</span>
                                </a>
                            </li>
                            <li class="z-30 flex-auto text-center">
                                <a class="z-30 block w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700"
                                    nav-link href="javascript:;" role="tab" aria-selected="false">
                                    <i class="fas fa-envelope text-slate-700 text-sm"></i>
                                    <span class="ml-1">Messages</span>
                                </a>
                            </li>
                            <li class="z-30 flex-auto text-center">
                                <a class="z-30 block w-full px-0 py-1 mb-0 transition-colors border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700"
                                    nav-link href="javascript:;" role="tab" aria-selected="false">
                                    <i class="fas fa-cog text-slate-700 text-sm"></i>
                                    <span class="ml-1">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full mt-6 mx-auto">
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
    @php
        $pendingProfileRequest = \App\Models\CustomerUpdateRequest::where('customer_id', $user->id)
            ->where('status', 'pending')
            ->first();
    @endphp
    @if($pendingProfileRequest)
        <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
            <i class="fas fa-info-circle mr-2"></i>
            Your profile update request has been submitted successfully and is pending admin approval (Submitted on {{ $pendingProfileRequest->created_at->format('d M, Y H:i') }}).
        </div>
    @endif
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 xl:w-4/12">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Platform Settings</h6>
                </div>
                <div class="flex-auto p-4">
                    <h6 class="font-bold leading-tight uppercase text-xs text-slate-500">Account</h6>
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-0 py-2 bg-white border-0 rounded-t-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="follow" class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox" checked />
                                <label for="follow" class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer select-none text-sm text-ellipsis whitespace-nowrap text-slate-500">Email me when someone follows me</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="answer" class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox" />
                                <label for="answer" class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer select-none text-sm text-ellipsis whitespace-nowrap text-slate-500">Email me when someone answers on my post</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 rounded-b-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="mention" class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox" checked />
                                <label for="mention" class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer select-none text-sm text-ellipsis whitespace-nowrap text-slate-500">Email me when someone mentions me</label>
                            </div>
                        </li>
                    </ul>
                    <h6 class="mt-6 font-bold leading-tight uppercase text-xs text-slate-500">Application</h6>
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-0 py-2 bg-white border-0 rounded-t-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="launches" class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox" />
                                <label for="launches" class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer select-none text-sm text-ellipsis whitespace-nowrap text-slate-500">New launches and projects</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="updates" class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox" checked />
                                <label for="updates" class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer select-none text-sm text-ellipsis whitespace-nowrap text-slate-500">Monthly product updates</label>
                            </div>
                        </li>
                        <li class="relative block px-0 py-2 pb-0 bg-white border-0 rounded-b-lg text-inherit">
                            <div class="min-h-6 mb-0.5 block pl-0">
                                <input id="newsletter" class="mt-0.54 rounded-10 duration-250 ease-soft-in-out after:rounded-circle after:shadow-soft-2xl after:duration-250 checked:after:translate-x-5.25 h-5 relative float-left ml-auto w-10 cursor-pointer appearance-none border border-solid border-gray-200 bg-slate-800/10 bg-none bg-contain bg-left bg-no-repeat align-top transition-all after:absolute after:top-px after:h-4 after:w-4 after:translate-x-px after:bg-white after:content-[''] checked:border-slate-800/95 checked:bg-slate-800/95 checked:bg-none checked:bg-right" type="checkbox" />
                                <label for="newsletter" class="w-4/5 mb-0 ml-4 overflow-hidden font-normal cursor-pointer select-none text-sm text-ellipsis whitespace-nowrap text-slate-500">Subscribe to newsletter</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-none">
                            <h6 class="mb-0">Profile Information</h6>
                        </div>
                        <div class="w-full max-w-full px-3 text-right shrink-0 md:w-4/12 md:flex-none">
                            <a href="{{ route('customer.profile.edit') }}">
                                <i class="leading-normal fas fa-user-edit text-sm text-slate-400"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-4">
                    <p class="leading-normal text-sm">
                        Hi, I’m {{ $user->name }}, a valued member of {{ config('app.name') }}. I joined on {{ $user->created_at->format('d M Y') }}. My account is currently {{ $user->status }}.
                    </p>
                    <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/10 to-transparent" />
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white border-0 rounded-t-lg text-sm text-inherit">
                            <strong class="text-slate-700">Full Name:</strong> &nbsp; {{ $user->name }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Mobile:</strong> &nbsp; {{ $user->phone ?? 'N/A' }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">WhatsApp:</strong> &nbsp; {{ $user->whatsapp_number ?? 'N/A' }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Email:</strong> &nbsp; {{ $user->email }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Address:</strong> &nbsp; {{ $user->customerDetail->address ?? 'N/A' }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Location:</strong> &nbsp; {{ $user->customerDetail->city ?? 'N/A' }}, {{ $user->customerDetail->state ?? '' }}, {{ $user->customerDetail->country ?? '' }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Pincode:</strong> &nbsp; {{ $user->customerDetail->pincode ?? 'N/A' }}
                        </li>
                        <li class="relative block px-4 py-2 pb-0 pl-0 bg-white border-0 border-t-0 rounded-b-lg text-inherit">
                            <strong class="leading-normal text-sm text-slate-700">Social:</strong> &nbsp;
                            <a class="inline-block py-0 pl-1 pr-2 mb-0 font-bold text-center text-blue-800 align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-none" href="javascript:;">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a class="inline-block py-0 pl-1 pr-2 mb-0 font-bold text-center align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-none text-sky-600" href="javascript:;">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a class="inline-block py-0 pl-1 pr-2 mb-0 font-bold text-center align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-none text-sky-900" href="javascript:;">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Conversations</h6>
                </div>
                <div class="flex-auto p-4">
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative flex items-center px-0 py-2 mb-2 bg-white border-0 rounded-t-lg text-inherit">
                            <div class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                <img src="{{ asset('assets/img/kal-visuals-square.jpg') }}" alt="kal" class="w-full shadow-soft-2xl rounded-xl" />
                            </div>
                            <div class="flex flex-col items-start justify-center">
                                <h6 class="mb-0 leading-normal text-sm">Sophie B.</h6>
                                <p class="mb-0 leading-tight text-xs">Hi! I need more information..</p>
                            </div>
                            <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100" href="javascript:;">Reply</a>
                        </li>
                        <li class="relative flex items-center px-0 py-2 mb-2 bg-white border-0 border-t-0 text-inherit">
                            <div class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                <img src="{{ asset('assets/img/marie.jpg') }}" alt="kal" class="w-full shadow-soft-2xl rounded-xl" />
                            </div>
                            <div class="flex flex-col items-start justify-center">
                                <h6 class="mb-0 leading-normal text-sm">Anne Marie</h6>
                                <p class="mb-0 leading-tight text-xs">Awesome work, can you..</p>
                            </div>
                            <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100" href="javascript:;">Reply</a>
                        </li>
                        <li class="relative flex items-center px-0 py-2 mb-2 bg-white border-0 border-t-0 text-inherit">
                            <div class="inline-flex items-center justify-center w-12 h-12 mr-4 text-white transition-all duration-200 text-base ease-soft-in-out rounded-xl">
                                <img src="{{ asset('assets/img/ivana-square.jpg') }}" alt="kal" class="w-full shadow-soft-2xl rounded-xl" />
                            </div>
                            <div class="flex flex-col items-start justify-center">
                                <h6 class="mb-0 leading-normal text-sm">Ivanna</h6>
                                <p class="mb-0 leading-tight text-xs">About files I can..</p>
                            </div>
                            <a class="inline-block py-3 pl-0 pr-4 mb-0 ml-auto font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in hover:scale-102 hover:active:scale-102 active:opacity-85 text-fuchsia-500 hover:text-fuchsia-800 hover:shadow-none active:scale-100" href="javascript:;">Reply</a>
                        </li>
                    </ul>
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

    <div class="flex-none w-full max-w-full px-3 mt-6 mb-8">
        <div class="relative flex flex-col min-w-0 break-words bg-white border border-slate-100 shadow-soft-xl rounded-[16px] bg-clip-border p-6">
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
    </div>
</div>
@endsection
