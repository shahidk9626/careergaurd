@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Claim Management</h6>
                    <p class="text-sm">Manage and process compensation claims for matured plans.</p>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="claimsTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Unique ID</th>
                                    @if(auth()->user()->role_id !== 0)
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Customer</th>
                                    @endif
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Plan Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Maturity Date</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Compensation</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Status</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                @php
                                    $maturityDate = $plan->created_at->copy()->addDays($plan->plan->claim_duration_days ?? 0);
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-semibold leading-normal text-slate-700">{{ $plan->plan_unique_id }}</span>
                                    </td>
                                    @if(auth()->user()->role_id !== 0)
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <div class="flex flex-col">
                                            <h6 class="mb-0 text-sm font-semibold leading-normal">{{ $plan->user->name }}</h6>
                                            <p class="mb-0 text-xxs leading-tight text-slate-400">{{ $plan->user->email }}</p>
                                        </div>
                                    </td>
                                    @endif
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-semibold leading-normal">{{ $plan->plan_name }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-xs font-semibold leading-normal text-slate-400">{{ $maturityDate->format('d M, Y') }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-bold leading-normal text-slate-700">₹{{ number_format($plan->plan->compensation_amount ?? 0, 2) }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl {{ $plan->status === 'claimed' ? 'from-purple-700 to-pink-500' : ($plan->status === 'active' ? 'from-green-600 to-lime-400' : 'from-slate-600 to-slate-300') }}">
                                            {{ $plan->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        @if($plan->status !== 'claimed')
                                            <a href="{{ route('customer.claim.form', $plan->plan_unique_id) }}"
                                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                                                Claim
                                            </a>
                                        @else
                                            <button disabled
                                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg opacity-50 cursor-not-allowed leading-pro text-xs ease-soft-in shadow-none bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300">
                                                Already Claimed
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#claimsTable').DataTable({
                order: [[3, 'asc']],
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        });

    </script>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #8392ab;
            font-size: 0.75rem;
            margin-bottom: 1rem;
            padding: 0 1.5rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.25rem 0.75rem;
            outline: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
            color: white !important;
            border: none;
            border-radius: 0.5rem;
        }

        table.dataTable tbody td {
            vertical-align: middle !important;
            border-bottom: 1px solid #f8f9fa;
        }
    </style>
@endpush
