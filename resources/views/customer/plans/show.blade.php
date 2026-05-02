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
                    <div class="w-full h-full bg-gradient-to-tl from-purple-700 to-pink-500 rounded-xl flex items-center justify-center shadow-soft-sm">
                        <i class="fas fa-gem text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1">{{ $plan->name }}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm uppercase">
                        {{ $plan->tenure_value }} {{ $plan->tenure_type }} Plan
                    </p>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12 text-right">
                <button type="button" onclick="confirmPurchase('{{ $plan->id }}', '{{ $plan->name }}')"
                    class="inline-block px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                    Purchase Now
                </button>
            </div>
        </div>
    </div>
</div>

<div class="w-full mt-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        {{-- Plan Overview --}}
        <div class="w-full max-w-full px-3 lg:w-4/12">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Plan Information</h6>
                </div>
                <div class="flex-auto p-4">
                    <p class="leading-normal text-sm">
                        {{ $plan->short_description ?? 'Premium career services bundle tailored for professional growth and job security.' }}
                    </p>
                    <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/10 to-transparent" />
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white border-0 rounded-t-lg text-sm text-inherit">
                            <strong class="text-slate-700">Premium Amount:</strong> &nbsp; ₹{{ number_format($plan->premium_amount, 2) }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Tenure:</strong> &nbsp; {{ $plan->tenure_value }} {{ ucfirst($plan->tenure_type) }}(s)
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Compensation:</strong> &nbsp; ₹{{ number_format($plan->compensation_amount, 2) }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Claim Duration:</strong> &nbsp; {{ $plan->claim_duration_days }} Days
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Status:</strong> &nbsp; 
                            <span class="px-2 py-1 text-xs font-bold text-white bg-green-500 rounded-lg">{{ strtoupper($plan->status) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Included Services --}}
        <div class="w-full max-w-full px-3 mt-6 lg:mt-0 lg:w-8/12">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Included Services & Categories</h6>
                </div>
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap -mx-3">
                        @php
                            $groupedServices = $plan->planServices->groupBy('service_type');
                            $serviceMeta = [
                                'resume' => ['icon' => 'fa-file-invoice', 'color' => 'bg-purple-100', 'textColor' => 'text-purple-700', 'label' => 'Resume Templates'],
                                'job-link' => ['icon' => 'fa-link', 'color' => 'bg-blue-100', 'textColor' => 'text-blue-700', 'label' => 'Job Links'],
                                'question' => ['icon' => 'fa-question-circle', 'color' => 'bg-red-100', 'textColor' => 'text-red-700', 'label' => 'Interview Q&A'],
                            ];
                        @endphp

                        @foreach($groupedServices as $type => $services)
                            @php $meta = $serviceMeta[$type] ?? ['icon' => 'fa-check', 'color' => 'bg-green-100', 'textColor' => 'text-green-700', 'label' => ucfirst($type)]; @endphp
                            <div class="w-full max-w-full px-3 mb-6 md:w-6/12 xl:w-4/12">
                                <div class="relative flex flex-col min-w-0 break-words bg-gray-50 border-0 shadow-none rounded-2xl bg-clip-border p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 {{ $meta['color'] }} rounded-lg text-center">
                                            <i class="fas {{ $meta['icon'] }} {{ $meta['textColor'] }} text-xs"></i>
                                        </div>
                                        <h6 class="mb-0 text-sm">{{ $meta['label'] }}</h6>
                                    </div>
                                    <ul class="flex flex-col pl-0 mb-0 list-none">
                                        @foreach($services as $s)
                                            @if($s->category)
                                                <li class="relative flex items-center py-1 text-inherit">
                                                    <i class="fas fa-check text-xs text-green-500 mr-2"></i>
                                                    <span class="text-xs text-slate-600">{{ $s->category->name }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/10 to-transparent" />
                    
                    <h6 class="mb-4">Plan Features</h6>
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full px-3">
                            <div class="flex flex-wrap gap-4">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-6 h-6 mr-2 bg-green-100 rounded-full text-center">
                                        <i class="fas fa-shield-alt text-green-600 text-xxs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">Career Protection</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-6 h-6 mr-2 bg-blue-100 rounded-full text-center">
                                        <i class="fas fa-headset text-blue-600 text-xxs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">Priority Support</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-6 h-6 mr-2 bg-purple-100 rounded-full text-center">
                                        <i class="fas fa-bolt text-purple-600 text-xxs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">Instant Access</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->role_id == 0)
<script>
    function confirmPurchase(planId, planName) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to purchase this plan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#cb0c9f',
            cancelButtonColor: '#8392ab',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                purchasePlan(planId);
            }
        })
    }

    function purchasePlan(planId) {
        fetch("{{ route('customer.plan.purchase') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ plan_id: planId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.success,
                    icon: 'success',
                    confirmButtonColor: '#cb0c9f',
                }).then(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.error || 'Something went wrong',
                    icon: 'error',
                    confirmButtonColor: '#cb0c9f',
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to process purchase.',
                icon: 'error',
                confirmButtonColor: '#cb0c9f',
            });
        });
    }
</script>
@endif

@endsection
