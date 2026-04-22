@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-8">
            <h3 class="font-bold text-slate-700">Choose Your Professional Plan</h3>
            <p class="text-slate-500">Premium bundles tailored for your career growth.</p>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 justify-center">
        @foreach($plans as $plan)
            <div class="w-full max-w-full px-3 mb-6 md:w-6/12 lg:w-4/12 flex-none">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl text-center">
                        <span
                            class="px-4 py-1 mb-4 inline-block text-xxs font-bold text-center text-purple-700 uppercase align-middle transition-all bg-purple-100 rounded-lg">
                            {{ $plan->tenure_value }} {{ ucfirst($plan->tenure_type) }}
                        </span>
                        <h5 class="mb-0 font-bold text-slate-700">{{ $plan->name }}</h5>
                        <p class="mb-0 text-sm leading-normal text-slate-400">
                            {{ $plan->description ?? 'Premium career services' }}</p>

                        <div class="my-6">
                            <h2 class="font-bold text-slate-700">
                                <span class="text-sm align-top mr-1">₹</span>{{ number_format($plan->premium_amount, 0) }}
                            </h2>
                        </div>
                    </div>

                    <div class="flex-auto p-6">
                        <ul class="flex flex-col pl-0 mb-0 list-none">
                            @php
                                $groupedServices = $plan->planServices->groupBy('service_type');
                                $serviceIcons = [
                                    'resume' => ['icon' => 'fa-file-invoice', 'color' => 'text-purple-500', 'label' => 'Resume Templates'],
                                    'job-link' => ['icon' => 'fa-link', 'color' => 'text-blue-500', 'label' => 'Job Links'],
                                    'question' => ['icon' => 'fa-question-circle', 'color' => 'text-red-500', 'label' => 'Interview Q&A'],
                                ];
                            @endphp

                            @foreach($groupedServices as $type => $services)
                                @php $meta = $serviceIcons[$type] ?? ['icon' => 'fa-check', 'color' => 'text-green-500', 'label' => $type]; @endphp
                                <li class="relative flex items-start py-2 border-0 rounded-t-lg text-inherit">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 mr-3 mt-1 rounded-lg bg-gray-100 text-center flex-none">
                                        <i class="fas {{ $meta['icon'] }} {{ $meta['color'] }} text-xs"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700">{{ $meta['label'] }}</span>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($services as $s)
                                                @if($s->category)
                                                    <span
                                                        class="text-xxs font-medium px-2 py-0.5 bg-gray-50 border border-gray-200 text-slate-500 rounded-md">
                                                        {{ $s->category->name }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            <hr class="h-px my-4 bg-transparent bg-gradient-to-r from-transparent via-black/10 to-transparent">

                            <li class="relative flex items-center py-2 border-0 text-inherit">
                                <div
                                    class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-green-100 text-center flex-none">
                                    <i class="fas fa-hand-holding-usd text-green-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-slate-600">Claim
                                    <b>₹{{ number_format($plan->compensation_amount, 0) }}</b> after
                                    {{ $plan->claim_duration_days }} days</span>
                            </li>
                        </ul>
                    </div>

                    <div class="p-6 pt-0 mt-auto bg-transparent border-t-0 rounded-b-2xl">
                        <button
                            class="w-full px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                            Get Started
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection