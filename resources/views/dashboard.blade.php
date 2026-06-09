@extends('layouts.app')

@section('content')
    <!-- row 1 -->
    @if(isset($staffStats))
        <!-- Staff Dashboard Widgets -->
        <div class="flex flex-wrap -mx-3">
            <!-- Widget 1: Total Active Policies -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-600">
                                        Total Active Policies
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-800">
                                        {{ number_format($staffStats['total_active_policies']) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md">
                                    <i class="fas fa-file-signature leading-none text-lg relative top-3 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget 2: Current Month Commission -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-600">
                                        Current Month Commission
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-800">
                                        ₹{{ number_format($staffStats['current_month_commission'], 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md">
                                    <i class="fas fa-calendar-check leading-none text-lg relative top-3 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget 3: Overall Commission Earned -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-600">
                                        Overall Commission Earned
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-800">
                                        ₹{{ number_format($staffStats['overall_commission_earned'], 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md">
                                    <i class="fas fa-wallet leading-none text-lg relative top-3 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget 4: Total Premium Generated -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-600">
                                        Total Premium Generated
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-800">
                                        ₹{{ number_format($staffStats['total_premium_generated'], 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md">
                                    <i class="fas fa-gem leading-none text-lg relative top-3 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Full Commission Report Button Row -->
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full px-3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4 flex-row items-center justify-between">
                    <div>
                        <h6 class="mb-1 font-bold text-slate-700">My Commission Reports</h6>
                        <p class="text-xs text-slate-400 mb-0">View statements, calculate payouts, and export PDF summaries.</p>
                    </div>
                    <a href="{{ route('admin.commission.index') }}" class="inline-block px-6 py-2.5 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85 text-xs mb-0">
                        <i class="fas fa-chart-pie mr-1"></i> View Full Commission Report
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Admin Dashboard Widgets -->
        <div class="flex flex-wrap -mx-3">
            <!-- card1 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">
                                        Total Active Customers
                                    </p>
                                    <h5 class="mb-0 font-bold">
                                        {{ number_format($totalActiveCustomers) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card2 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">
                                        Total Memberships Purchased
                                    </p>
                                    <h5 class="mb-0 font-bold">
                                        {{ number_format($totalPlansPurchased) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card3 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">
                                        Total Purchased Amount
                                    </p>
                                    <h5 class="mb-0 font-bold">
                                        ₹ {{ number_format($totalPurchasedAmount, 0, '.', ',') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- card4 -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">
                                        Total Active Staff
                                    </p>
                                    <h5 class="mb-0 font-bold">
                                        {{ number_format($totalActiveStaff) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div
                                    class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="ni leading-none ni-cart text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- row 2 -->
    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap -mx-3">
                        <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                            <div class="flex flex-col h-full">
                                <p class="pt-2 mb-1 font-semibold">Built by developers</p>
                                <h5 class="font-bold">Soft UI Dashboard</h5>
                                <p class="mb-12">
                                    From colors, cards, typography to complex elements, you will find
                                    the full documentation.
                                </p>
                                <a class="mt-auto mb-0 font-semibold leading-normal group text-sm text-slate-500"
                                    href="javascript:;">
                                    Read More
                                    <i
                                        class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 mt-0.5 transition-all duration-200"></i>
                                </a>
                            </div>
                        </div>
                        <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
                            <div class="h-full bg-gradient-to-tl from-purple-700 to-pink-500 rounded-xl">
                                <img src="{{ asset('assets/img/shapes/waves-white.svg') }}"
                                    class="absolute top-0 hidden w-1/2 h-full lg:block" alt="waves" />
                                <div class="relative flex items-center justify-center h-full">
                                    <img class="relative z-20 w-full pt-6"
                                        src="{{ asset('assets/img/illustrations/rocket-white.png') }}" alt="rocket" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="relative h-full overflow-hidden bg-cover rounded-xl"
                    style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}')">
                    <span
                        class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-80"></span>
                    <div class="relative z-10 flex flex-col flex-auto h-full p-4">
                        <h5 class="pt-2 mb-6 font-bold text-white">Work with the rockets</h5>
                        <p class="text-white">
                            Wealth creation is an evolutionarily recent positive-sum game. It is
                            all about who takes the opportunity first.
                        </p>
                        <a class="mt-auto mb-0 font-semibold leading-normal group text-sm text-white" href="javascript:;">
                            Read More
                            <i
                                class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 mt-0.5 transition-all duration-200"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- row 3 -->


    <!-- row 4 -->

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/chart-1.js') }}" async></script>
    <script src="{{ asset('assets/js/chart-2.js') }}" async></script>
@endpush