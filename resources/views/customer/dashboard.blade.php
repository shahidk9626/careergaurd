@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-6">
                    <div class="flex flex-wrap -mx-3">
                        <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                            <div class="flex flex-col h-full">
                                <p class="pt-2 mb-1 font-semibold">Welcome Back,</p>
                                <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                <p class="mb-12">We are glad to have you here. Your profile is complete and you can now
                                    access all our services.</p>
                                <a class="mt-auto mb-0 font-semibold leading-normal cursor-pointer group text-sm"
                                    href="javascript:;">
                                    View Transactions
                                    <i
                                        class="fas fa-arrow-right ease-bounce ml-1 text-sm transition-all group-hover:translate-x-1.25"></i>
                                </a>
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
        </div>
    </div>
@endsection