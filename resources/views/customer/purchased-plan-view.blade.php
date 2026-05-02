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
                    <div class="flex items-center justify-center w-full h-full bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-sm rounded-xl">
                        <i class="fas fa-file-invoice text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1">{{ $purchasedPlan->plan_name }}</h5>
                    <p class="mb-0 font-semibold leading-normal text-sm">
                        {{ $purchasedPlan->plan_unique_id }}
                    </p>
                </div>
            </div>
            <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mr-0 md:w-1/2 md:flex-none lg:w-4/12">
                <div class="relative right-0">
                    <ul class="relative flex flex-wrap p-1 list-none bg-transparent rounded-xl" nav-pills role="tablist">
                        <li class="z-30 flex-auto text-center">
                            <a class="z-30 block w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700 cursor-pointer active"
                                nav-link active data-tab="basic-details" role="tab" aria-selected="true">
                                <i class="fas fa-info-circle text-slate-700 text-sm"></i>
                                <span class="ml-1">Basic Details</span>
                            </a>
                        </li>
                        <li class="z-30 flex-auto text-center">
                            <a class="z-30 block w-full px-0 py-1 mb-0 transition-all border-0 rounded-lg ease-soft-in-out bg-inherit text-slate-700 cursor-pointer"
                                nav-link data-tab="repayment-history" role="tab" aria-selected="false">
                                <i class="fas fa-history text-slate-700 text-sm"></i>
                                <span class="ml-1">Repayment History</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full mt-6 mx-auto">
    <!-- Basic Details Tab -->
    <div id="basic-details" class="tab-content block">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 xl:w-4/12">
                <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                        <h6 class="mb-0">Plan Information</h6>
                    </div>
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            <li class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white border-0 rounded-t-lg text-sm text-inherit">
                                <strong class="text-slate-700">Plan Name:</strong> &nbsp; {{ $purchasedPlan->plan_name }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Unique ID:</strong> &nbsp; {{ $purchasedPlan->plan_unique_id }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Amount:</strong> &nbsp; ₹{{ number_format($purchasedPlan->amount, 2) }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Status:</strong> &nbsp; 
                                <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl {{ $purchasedPlan->status === 'active' ? 'from-green-600 to-lime-400' : 'from-slate-600 to-slate-300' }}">
                                    {{ $purchasedPlan->status }}
                                </span>
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Tenure:</strong> &nbsp; {{ $purchasedPlan->tenure_value }} {{ ucfirst($purchasedPlan->tenure_type) }}(s)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
                <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                        <h6 class="mb-0">Customer & Dates</h6>
                    </div>
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            <li class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white border-0 rounded-t-lg text-sm text-inherit">
                                <strong class="text-slate-700">Customer Name:</strong> &nbsp; {{ $purchasedPlan->user->name }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Customer Email:</strong> &nbsp; {{ $purchasedPlan->user->email }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Purchase Date:</strong> &nbsp; {{ $purchasedPlan->created_at->format('d M, Y') }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Start Date:</strong> &nbsp; {{ $purchasedPlan->start_date->format('d M, Y') }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">End Date:</strong> &nbsp; {{ $purchasedPlan->end_date ? $purchasedPlan->end_date->format('d M, Y') : 'N/A' }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 lg-max:mt-6 xl:w-4/12">
                <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                        <h6 class="mb-0">Benefit Details</h6>
                    </div>
                    <div class="flex-auto p-4">
                        <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                            <li class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white border-0 rounded-t-lg text-sm text-inherit">
                                <strong class="text-slate-700">Claim Duration:</strong> &nbsp; {{ $purchasedPlan->plan->claim_duration_days ?? 0 }} Days
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Compensation:</strong> &nbsp; ₹{{ number_format($purchasedPlan->plan->compensation_amount ?? 0, 2) }}
                            </li>
                            <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Included Services:</strong>
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach($purchasedPlan->plan->planServices as $ps)
                                        <span class="bg-gray-100 text-slate-700 text-xxs px-2 py-1 rounded-md border border-gray-200">
                                            {{ $ps->category->name }} ({{ $ps->quantity }})
                                        </span>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Repayment History Tab -->
    <div id="repayment-history" class="tab-content hidden">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                        <h6 class="mb-0">Transaction Records</h6>
                        <p class="text-sm">List of all payments made for this plan.</p>
                    </div>
                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-6 overflow-x-auto">
                            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                            Transaction ID</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                            Amount</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                            Status</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                            Method</th>
                                        <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                            Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $tx)
                                    <tr>
                                        <td class="px-6 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                            <span class="text-sm font-semibold leading-normal text-slate-700">{{ $tx->transaction_reference }}</span>
                                        </td>
                                        <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                            <span class="text-sm font-semibold leading-normal">₹{{ number_format($tx->amount, 2) }}</span>
                                        </td>
                                        <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl {{ $tx->payment_status === 'success' ? 'from-green-600 to-lime-400' : 'from-slate-600 to-slate-300' }}">
                                                {{ $tx->payment_status }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none text-sm">
                                            {{ strtoupper($tx->payment_method) }}
                                        </td>
                                        <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none text-sm">
                                            {{ $tx->created_at->format('d M, Y H:i') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-sm">No transaction records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-tab]').forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active classes
            document.querySelectorAll('[data-tab]').forEach(t => {
                t.classList.remove('active', 'bg-white', 'shadow-soft-xl', 'font-semibold');
                t.ariaSelected = 'false';
            });
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('block'));

            // Add active classes
            this.classList.add('active', 'bg-white', 'shadow-soft-xl', 'font-semibold');
            this.ariaSelected = 'true';
            const contentId = this.getAttribute('data-tab');
            document.getElementById(contentId).classList.remove('hidden');
            document.getElementById(contentId).classList.add('block');
        });
    });

    // Initial active state for first tab if needed (already set in HTML but for consistency)
    const activeTab = document.querySelector('[data-tab].active');
    if (activeTab) {
        activeTab.classList.add('bg-white', 'shadow-soft-xl', 'font-semibold');
    }
</script>
<style>
    .tab-content {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush
