@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h3 class="font-bold text-slate-700">Choose Membership for {{ $customer->name }}</h3>
            <p class="text-slate-500">Email: <b>{{ $customer->email }}</b> | WhatsApp: <b>{{ $customer->whatsapp_number }}</b></p>
            <a href="{{ route('admin.customers.index') }}" class="inline-block px-4 py-2 mt-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                <i class="fas fa-arrow-left mr-1"></i> Back to Customers
            </a>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-8">
        <div class="col-12 flex justify-center">
            <form action="{{ url()->current() }}" method="GET" class="w-full max-w-lg">
                <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                    <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" 
                        placeholder="Search Memberships..." />
                </div>
            </form>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mt-4 justify-center">
        @forelse($plans as $plan)
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
                            {{ $plan->short_description ?? 'Premium career services' }}
                        </p>

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
                                <span class="text-sm text-slate-600">Upto
                                    <b>₹{{ number_format($plan->compensation_amount, 0) }}</b> support after
                                    {{ $plan->claim_duration_days }} days</span>
                            </li>

                            @if($plan->prematurity_available)
                                <li class="relative flex items-center py-2 border-0 text-inherit">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-purple-100 text-center flex-none">
                                        <i class="fas fa-history text-purple-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">Prematurity Available: <b>Yes</b></span>
                                </li>
                            @endif

                            @if($plan->one_time_payment_applicable)
                                <li class="relative flex items-center py-2 border-0 text-inherit">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-blue-100 text-center flex-none">
                                        <i class="fas fa-coins text-blue-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">One-Time Payment: <b>Available</b></span>
                                </li>
                                <li class="relative flex items-center py-2 border-0 text-inherit">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-cyan-100 text-center flex-none">
                                        <i class="fas fa-wallet text-cyan-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">Discount if One-Time Payment: <b>₹{{ number_format($plan->one_time_payment_amount, 0) }}</b></span>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="p-6 pt-0 mt-auto bg-transparent border-t-0 rounded-b-2xl">
                        @if($plan->one_time_payment_applicable)
                            <div class="mb-3">
                                <label class="block text-xxs font-bold text-slate-500 mb-1">Payment Option</label>
                                <select id="payment_type_{{ $plan->id }}" class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="regular">Standard (₹{{ number_format($plan->premium_amount, 0) }})</option>
                                    <option value="one_time">One-Time (₹{{ number_format($plan->one_time_payment_amount, 0) }})</option>
                                </select>
                            </div>
                        @endif
                        <button type="button" onclick="confirmSendLink('{{ $plan->id }}', '{{ $plan->name }}')"
                            class="w-full px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                            Send Payment Link
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="w-full text-center py-12">
                <div class="mb-4 text-slate-300">
                    <i class="fas fa-search fa-4x"></i>
                </div>
                <h5 class="text-slate-500">No memberships found.</h5>
                <p class="text-slate-400">Try adjusting your search criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Section -->
    @if($plans->hasPages())
    <div class="row mt-8">
        <div class="col-12 flex justify-center">
            <nav aria-label="Page navigation">
                <ul class="flex pl-0 list-none rounded-lg">
                    {{-- Previous Page Link --}}
                    @if ($plans->onFirstPage())
                        <li class="mx-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-300 cursor-not-allowed">
                                <i class="fas fa-angle-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="mx-1">
                            <a href="{{ $plans->previousPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($plans->getUrlRange(1, $plans->lastPage()) as $page => $url)
                        @if ($page == $plans->currentPage())
                            <li class="mx-1">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-bold shadow-soft-md">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="mx-1">
                                <a href="{{ $url }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($plans->hasMorePages())
                        <li class="mx-1">
                            <a href="{{ $plans->nextPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="mx-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-300 cursor-not-allowed">
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    @endif

    @push('scripts')
        <script>
            function confirmSendLink(planId, planName) {
                Swal.fire({
                    title: 'Send Payment Link?',
                    text: `Are you sure you want to generate and send the Cashfree payment link for the "${planName}" membership to {{ $customer->name }}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#cb0c9f',
                    cancelButtonColor: '#8392ab',
                    confirmButtonText: 'Yes, Send Link',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        sendPaymentLink(planId);
                    }
                });
            }

            function sendPaymentLink(planId) {
                const paymentTypeSelect = document.getElementById('payment_type_' + planId);
                const paymentType = paymentTypeSelect ? paymentTypeSelect.value : 'regular';

                Swal.fire({
                    title: 'Generating Link...',
                    text: 'Calling payment gateway and dispatching email. Please wait.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.customers.generate-link', ['id' => $customer->id]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ plan_id: planId, payment_type: paymentType })
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
                            window.location.href = "{{ route('admin.customers.index') }}";
                        });
                    } else if (data.error) {
                        Swal.fire({
                            title: 'Failed!',
                            text: data.error,
                            icon: 'error',
                            confirmButtonColor: '#cb0c9f',
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to process request.',
                            icon: 'error',
                            confirmButtonColor: '#cb0c9f',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'A connection error occurred.',
                        icon: 'error',
                        confirmButtonColor: '#cb0c9f',
                    });
                });
            }
        </script>
    @endpush
@endsection
