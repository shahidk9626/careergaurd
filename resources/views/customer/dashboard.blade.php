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
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
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
            @endif
        </div>
    </div>
@endsection