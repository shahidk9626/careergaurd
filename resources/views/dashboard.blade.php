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

            <!-- Widget 2: Total Commission Earned -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-600">
                                        Total Commission Earned
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

            <!-- Widget 3: Total Commission Paid -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-600">
                                        Total Commission Paid
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-800">
                                        ₹{{ number_format($staffStats['total_paid'], 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-500 shadow-soft-md">
                                    <i class="fas fa-check-circle leading-none text-lg relative top-3 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget 4: Total Commission Due -->
            <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-600">
                                        Total Commission Due
                                    </p>
                                    <h5 class="mb-0 font-bold text-slate-800">
                                        ₹{{ number_format($staffStats['total_due'], 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-600 to-amber-400 shadow-soft-md">
                                    <i class="fas fa-hourglass-half leading-none text-lg relative top-3 text-white"></i>
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

        <!-- Payout History Log Card -->
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full px-3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl flex items-center justify-between">
                        <div>
                            <h6 class="mb-1 font-bold text-slate-700">Recent Commission Settlements</h6>
                            <p class="text-xs text-slate-400 mb-0">Your latest payout batches and transaction details.</p>
                        </div>
                    </div>
                    <div class="flex-auto p-6 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Batch Reference</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Payment Date</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Policies Settled</th>
                                    <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Paid Amount</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Description</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Proof Document</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payouts as $payout)
                                    <tr>
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-700 font-mono">{{ $payout->batch_reference }}</td>
                                        <td class="px-6 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none">{{ $payout->payment_date ? $payout->payment_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td class="px-6 py-3 text-sm text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">{{ $payout->total_policies }}</td>
                                        <td class="px-6 py-3 text-sm text-right font-bold text-green-600 align-middle bg-transparent border-b whitespace-nowrap shadow-none">₹{{ number_format($payout->total_commission_amount, 2) }}</td>
                                        <td class="px-6 py-3 text-sm align-middle bg-transparent border-b shadow-none max-w-xs truncate" title="{{ $payout->description }}">{{ $payout->description ?? 'N/A' }}</td>
                                        <td class="px-6 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">
                                            @if($payout->payment_proof)
                                                <button type="button" onclick="viewProofModal('{{ asset('storage/' . $payout->payment_proof) }}')" class="inline-block px-3 py-1 mb-0 text-white font-bold text-center uppercase align-middle transition-all bg-gradient-to-tl from-green-600 to-lime-500 rounded-lg text-xxs cursor-pointer shadow-soft-sm">
                                                    <i class="fas fa-file-invoice mr-1"></i> View Proof
                                                </button>
                                            @else
                                                <span class="text-xs italic text-slate-400">None</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-slate-400 italic py-6 text-sm">
                                            No payout batch logs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proof Document Viewer Modal for Dashboard -->
        <div id="proofViewerDashboardModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
            <div style="background-color: #ffffff; width: 100%; max-width: 700px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 85vh;">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h6 style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Payment Proof Document</h6>
                    <div style="display: flex; gap: 8px;">
                        <a id="downloadDashboardProofLink" href="#" download class="inline-block px-3 py-1 bg-purple-600 text-white rounded text-xs font-bold decoration-none"><i class="fas fa-download"></i> Download</a>
                        <button type="button" onclick="closeDashboardProofModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
                    </div>
                </div>
                <div id="proofDashboardViewerBody" style="padding: 1.5rem; overflow-y: auto; text-align: center; display: flex; align-items: center; justify-content: center; min-height: 300px;">
                    <!-- Dynamically loaded img or iframe for PDF -->
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
                            <p class="pt-2 mb-1 font-semibold">Your Career, Protected</p>
                            <h5 class="font-bold">Welcome to CareerGuard</h5>
                            <p class="mb-12">
                                Access job opportunities, resume templates, and interview prep — plus
                                financial support when you need it most. Everything your membership unlocks, in one place.
                            </p>
                            <a class="mt-auto mb-0 font-semibold leading-normal group text-sm text-slate-500"
                               href="{{ route('customer.purchased-plans') }}">
                                View My Memberships
                                <i class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 mt-0.5 transition-all duration-200"></i>
                            </a>
                        </div>
                    </div>
                    <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
                        <div class="h-full bg-gradient-to-tl from-purple-700 to-pink-500 rounded-xl">
                            <img src="{{ asset('assets/img/shapes/waves-white.svg') }}"
                                 class="absolute top-0 hidden w-1/2 h-full lg:block" alt="waves" />
                            <div class="relative flex items-center justify-center h-full">
                                <img class="relative z-20 w-full pt-6"
                                     src="{{ asset('assets/img/illustrations/rocket-white.png') }}" alt="careerguard" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
        <div class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
            <div class="relative h-full overflow-hidden bg-cover rounded-xl"
                 style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}')">
                <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-purple-700 to-pink-500 opacity-80"></span>
                <div class="relative z-10 flex flex-col flex-auto h-full p-4">
                    <h5 class="pt-2 mb-6 font-bold text-white">Need Support?</h5>
                    <p class="text-white">
                        Facing a job loss or career setback? Eligible members can request financial
                        assistance support. Our team is here to guide you through every step.
                    </p>
                    <a class="mt-auto mb-0 font-semibold leading-normal group text-sm text-white"
                       href="javascript:;" onclick="openCallbackModal('direct')">
                        Request a Callback
                        <i class="fas fa-arrow-right ease-bounce text-sm group-hover:translate-x-1.25 ml-1 mt-0.5 transition-all duration-200"></i>
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
    <script>
        function viewProofModal(url) {
            let fileExt = url.split('.').pop().toLowerCase();
            let viewerHtml = '';
            if (fileExt === 'pdf') {
                viewerHtml = `<iframe src="${url}" style="width: 100%; height: 500px; border: none;"></iframe>`;
            } else {
                viewerHtml = `<img src="${url}" class="img-fluid rounded" style="max-height: 500px; max-width: 100%; object-fit: contain;">`;
            }

            $('#proofDashboardViewerBody').html(viewerHtml);
            $('#downloadDashboardProofLink').attr('href', url);
            $('#proofViewerDashboardModal').css('display', 'flex');
        }

        function closeDashboardProofModal() {
            $('#proofViewerDashboardModal').hide();
        }
    </script>
@endpush