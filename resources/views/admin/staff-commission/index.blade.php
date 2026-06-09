@extends('layouts.app')

@section('content')
    <!-- Search Panel Card -->
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-1 font-bold text-slate-700">Staff Commission Invoice Generator</h6>
                    <p class="text-xs text-slate-400">Generate a professional commission statement and invoice using staff code.</p>
                </div>
                <div class="p-6">
                    <form id="staffSearchForm" class="flex flex-wrap items-end gap-4">
                        <div class="w-full md:w-auto flex-grow" style="max-width: 350px; margin-bottom: 0;">
                            <label class="block mb-2 text-xs font-bold text-slate-600 uppercase">Enter Staff Code</label>
                            <input type="text" id="staff_code_input" required class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="e.g. STAFF0001">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="inline-block px-6 py-2.5 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85 text-xs mb-0">
                                <i class="fas fa-search mr-1"></i> Generate Summary
                            </button>
                            <button type="button" onclick="clearSearch()" class="inline-block px-6 py-2.5 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85 text-xs mb-0">
                                <i class="fas fa-times mr-1"></i> Clear
                            </button>
                        </div>
                    </form>
                    <div id="searchValidationError" class="mt-2 text-xs text-red-500 font-semibold" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- AJAX Commission Dashboard Section -->
    <div id="commissionDashboard" class="flex flex-wrap -mx-3 mb-6" style="display: none;">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border p-6">
                
                <!-- Section 1: Staff Profile Header -->
                <div class="flex flex-wrap items-center justify-between border-b pb-6 mb-6 gap-4">
                    <div class="flex items-center gap-4">
                        <div id="staffPhotoContainer" class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center border shadow-inner">
                            <!-- Image or avatar icon injected via JS -->
                        </div>
                        <div>
                            <h5 id="staffNameDisplay" class="mb-0 font-bold text-slate-800 text-lg"></h5>
                            <div class="flex items-center gap-2 mt-1">
                                <span id="staffCodeDisplay" class="text-xs font-semibold px-2 py-0.5 bg-purple-100 text-purple-800 rounded-md"></span>
                                <span id="staffRoleDisplay" class="text-xs font-semibold px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-x-6 gap-y-2 text-xs text-slate-500">
                        <div><i class="fas fa-envelope mr-1 text-purple-500"></i> <span id="staffEmailDisplay"></span></div>
                        <div><i class="fas fa-phone mr-1 text-purple-500"></i> <span id="staffPhoneDisplay"></span></div>
                        <div><i class="fas fa-calendar-alt mr-1 text-purple-500"></i> Joining Date: <span id="staffJoiningDisplay"></span></div>
                        <div><i class="fas fa-circle mr-1 text-green-500" id="staffStatusDot"></i> Status: <span id="staffStatusDisplay" class="font-bold"></span></div>
                    </div>
                </div>

                <!-- Section 2: Filters -->
                <div class="border-b pb-6 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h6 class="mb-1 font-bold text-slate-700">Filter Commission Data</h6>
                            <p class="text-xs text-slate-400">Select a period to update the commission summary and table below.</p>
                        </div>
                        
                        <div class="flex flex-wrap items-end gap-3">
                            <div class="flex flex-wrap gap-1 bg-slate-100 p-1 rounded-lg">
                                <button type="button" onclick="setPeriod('current_month')" id="btn_period_current_month" class="period-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Current Month</button>
                                <button type="button" onclick="setPeriod('last_month')" id="btn_period_last_month" class="period-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Last Month</button>
                                <button type="button" onclick="setPeriod('current_year')" id="btn_period_current_year" class="period-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Current Year</button>
                                <button type="button" onclick="setPeriod('overall')" id="btn_period_overall" class="period-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Overall</button>
                                <button type="button" onclick="setPeriod('custom')" id="btn_period_custom" class="period-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Custom Range</button>
                            </div>
                            
                            <!-- Custom Date Inputs -->
                            <div id="customDateInputs" class="flex items-center gap-2" style="display: none;">
                                <input type="date" id="filter_start_date" class="px-2 py-1 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="Start Date">
                                <span class="text-xs text-slate-400">to</span>
                                <input type="date" id="filter_end_date" class="px-2 py-1 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600" placeholder="End Date">
                                <button type="button" onclick="applyCustomFilter()" class="px-3 py-1.5 text-xs font-bold text-white bg-purple-600 hover:bg-purple-700 transition-all border-0 rounded-lg cursor-pointer">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: KPI Summary Cards -->
                <div class="mb-6">
                    <h6 class="mb-4 font-bold text-slate-700 uppercase tracking-wider text-xs">Commission KPI Overview</h6>
                    
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <!-- Selected Period Statistics -->
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-50 to-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-purple-600 uppercase block tracking-widest mb-1">Selected Period (<span class="selected-period-label">Overall</span>)</span>
                                <h4 id="periodPoliciesDisplay" class="font-bold text-slate-800 mb-0">0</h4>
                                <span class="text-xs text-slate-400">Policies Converted</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-50 to-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-purple-600 uppercase block tracking-widest mb-1">Premium Generated (<span class="selected-period-label">Overall</span>)</span>
                                <h4 id="periodPremiumDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                                <span class="text-xs text-slate-400">Total Premium Amount</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-600 to-indigo-600 relative overflow-hidden shadow-md text-white h-full">
                                <div class="absolute right-4 top-4 opacity-10" style="font-size: 2.5rem;">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <span class="text-xxs font-bold text-purple-200 uppercase block tracking-widest mb-1">Commission Earned (<span class="selected-period-label">Overall</span>)</span>
                                <h4 id="periodCommissionDisplay" class="font-bold mb-0 text-white">₹0</h4>
                                <span class="text-xs text-purple-200">Total Earnings (10%)</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3">
                        <!-- Overall Statistics -->
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Overall Performance</span>
                                <h4 id="overallPoliciesDisplay" class="font-bold text-slate-800 mb-0">0</h4>
                                <span class="text-xs text-slate-400">Policies Converted</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Overall Premium</span>
                                <h4 id="overallPremiumDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                                <span class="text-xs text-slate-400">Total Premium Amount</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Overall Earnings</span>
                                <h4 id="overallCommissionDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                                <span class="text-xs text-slate-400">Total Commission Earned (10%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Commission Details Table -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                        <h6 class="font-bold text-slate-700 uppercase tracking-wider text-xs mb-0">Policy Breakdown</h6>
                        
                        @if(hasPermission('staff-commission.export'))
                            <button type="button" id="downloadPdfBtn" onclick="downloadInvoicePdf()" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85 text-xs mb-0 border-0">
                                <i class="fas fa-file-pdf mr-1"></i> Download Commission Invoice
                            </button>
                        @endif
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="referralsSummaryTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Policy Number</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Customer Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Membership Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Purchase Date</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Premium</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Comm %</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Commission</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Status</th>
                                </tr>
                            </thead>
                            <tbody id="referralsSummaryBody">
                                <!-- JS will inject rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Original referred memberships list -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0 font-bold">Staff Referrals & Commissions</h6>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="commissionTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    @if(auth()->user()->id === 1 || (auth()->user()->role && auth()->user()->role->slug === 'admin'))
                                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                            Staff Name</th>
                                    @endif
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Customer Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Membership Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Amount</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Purchase Date</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Payment Status</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Referral Status</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Transaction ID</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        const isAdmin = {{ (auth()->user()->id === 1 || (auth()->user()->role && auth()->user()->role->slug === 'admin')) ? 'true' : 'false' }};
        const canChangeStatus = {{ hasPermission('staff-commission.status') ? 'true' : 'false' }};

        let currentStaffCode = '';
        let currentPeriod = 'overall';
        let startDate = '';
        let endDate = '';

        function formatCurrency(amount) {
            return '₹' + parseFloat(amount).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function fetchCommissionData(staffCode, period, start = '', end = '') {
            $('#searchValidationError').hide().text('');
            
            $.ajax({
                url: "{{ route('admin.staff-commission.search') }}",
                type: 'GET',
                data: {
                    staff_code: staffCode,
                    period: period,
                    start_date: start,
                    end_date: end
                },
                success: function(response) {
                    if (response.success) {
                        const staff = response.staff;
                        
                        // Populate Staff Profile Header
                        $('#staffNameDisplay').text(staff.name);
                        $('#staffCodeDisplay').text(staff.code);
                        $('#staffRoleDisplay').text(staff.role);
                        $('#staffEmailDisplay').text(staff.email);
                        $('#staffPhoneDisplay').text(staff.phone);
                        $('#staffJoiningDisplay').text(staff.joining_date);
                        $('#staffStatusDisplay').text(staff.status);
                        
                        if (staff.status === 'Active') {
                            $('#staffStatusDot').removeClass('text-red-500').addClass('text-green-500');
                        } else {
                            $('#staffStatusDot').removeClass('text-green-500').addClass('text-red-500');
                        }
                        
                        // Handle Staff Image
                        if (staff.profile_image) {
                            $('#staffPhotoContainer').html(`<img src="${staff.profile_image}" class="w-full h-full object-cover">`);
                        } else {
                            $('#staffPhotoContainer').html(`<i class="fas fa-user-tie text-2xl text-slate-400"></i>`);
                        }
                        
                        // Update Overall Stats
                        $('#overallPoliciesDisplay').text(response.overall.total_policies);
                        $('#overallPremiumDisplay').text(formatCurrency(response.overall.total_premium));
                        $('#overallCommissionDisplay').text(formatCurrency(response.overall.total_commission));
                        
                        // Update Selected Period Stats
                        $('#periodPoliciesDisplay').text(response.period.total_policies);
                        $('#periodPremiumDisplay').text(formatCurrency(response.period.total_premium));
                        $('#periodCommissionDisplay').text(formatCurrency(response.period.total_commission));
                        
                        // Update period labels
                        $('.selected-period-label').text(response.period.label);
                        
                        // Build referrals summary rows
                        let referralsHtml = '';
                        if (response.period.referrals && response.period.referrals.length > 0) {
                            $.each(response.period.referrals, function(idx, ref) {
                                let badgeClass = ref.status === 'active' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-red-600 to-rose-400';
                                referralsHtml += `
                                    <tr>
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-700 font-mono">${ref.policy_number}</td>
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-800">${ref.customer_name}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600">${ref.membership_name}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600">${ref.purchase_date}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-right font-semibold text-slate-800">${formatCurrency(ref.premium_amount)}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-center">${ref.commission_percent}%</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-right font-bold text-purple-700">${formatCurrency(ref.commission_amount)}</td>
                                        <td class="px-2 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">
                                            <span class="text-xxs px-2.5 py-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${ref.status}</span>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            referralsHtml = `
                                <tr>
                                    <td colspan="8" class="text-center text-slate-400 italic py-6 text-sm">
                                        No commission records found for the selected period.
                                    </td>
                                </tr>
                            `;
                        }
                        $('#referralsSummaryBody').html(referralsHtml);
                        
                        // Show Dashboard
                        $('#commissionDashboard').slideDown();
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'No staff found with the entered code.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    $('#searchValidationError').text(errorMsg).show();
                    $('#commissionDashboard').slideUp();
                }
            });
        }

        function setPeriod(period) {
            currentPeriod = period;
            
            // Update active period buttons UI
            $('.period-btn').removeClass('bg-white text-purple-700 shadow-soft-sm').addClass('text-slate-600 bg-transparent');
            $('#btn_period_' + period).addClass('bg-white text-purple-700 shadow-soft-sm').removeClass('text-slate-600 bg-transparent');
            
            if (period === 'custom') {
                $('#customDateInputs').slideDown();
            } else {
                $('#customDateInputs').slideUp();
                startDate = '';
                endDate = '';
                if (currentStaffCode) {
                    fetchCommissionData(currentStaffCode, currentPeriod);
                }
            }
        }

        function applyCustomFilter() {
            const start = $('#filter_start_date').val();
            const end = $('#filter_end_date').val();
            
            if (!start || !end) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Dates',
                    text: 'Please select both start and end dates.',
                    customClass: {
                        confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold'
                    },
                    buttonsStyling: false
                });
                return;
            }
            
            startDate = start;
            endDate = end;
            
            if (currentStaffCode) {
                fetchCommissionData(currentStaffCode, 'custom', startDate, endDate);
            }
        }

        function clearSearch() {
            $('#staff_code_input').val('');
            $('#searchValidationError').hide().text('');
            $('#commissionDashboard').slideUp();
            
            currentStaffCode = '';
            currentPeriod = 'overall';
            startDate = '';
            endDate = '';
            
            $('#filter_start_date').val('');
            $('#filter_end_date').val('');
            $('#customDateInputs').hide();
            
            // Reset period buttons to default (overall active)
            $('.period-btn').removeClass('bg-white text-purple-700 shadow-soft-sm').addClass('text-slate-600 bg-transparent');
            $('#btn_period_overall').addClass('bg-white text-purple-700 shadow-soft-sm').removeClass('text-slate-600 bg-transparent');
        }

        function downloadInvoicePdf() {
            if (!currentStaffCode) return;
            
            let url = "{{ route('admin.staff-commission.export-pdf') }}";
            let params = {
                staff_code: currentStaffCode,
                period: currentPeriod
            };
            
            if (currentPeriod === 'custom') {
                if (!startDate || !endDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Dates',
                        text: 'Please apply custom date range filters first.',
                        customClass: {
                            confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold'
                        },
                        buttonsStyling: false
                    });
                    return;
                }
                params.start_date = startDate;
                params.end_date = endDate;
            }
            
            window.location.href = url + '?' + $.param(params);
        }

        $(document).ready(function () {
            let columns = [];
            
            if (isAdmin) {
                columns.push({
                    data: 'staff_name',
                    className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                });
            }

            columns.push(
                {
                    data: 'customer_name',
                    className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'plan_name',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'amount',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        return '₹' + data;
                    }
                },
                {
                    data: 'purchase_date',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'payment_status',
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        let badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                        if (data === 'success') badgeClass = 'bg-gradient-to-tl from-green-600 to-lime-400';
                        if (data === 'failed') badgeClass = 'bg-gradient-to-tl from-red-600 to-rose-400';
                        if (data === 'expired' || data === 'cancelled') badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                        
                        let label = data ? data.toUpperCase() : 'PENDING';
                        return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${label}</span>`;
                    }
                },
                {
                    data: 'referral_status',
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        let badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                        if (data === 'paid') badgeClass = 'bg-gradient-to-tl from-green-600 to-lime-400';
                        if (data === 'expired') badgeClass = 'bg-gradient-to-tl from-yellow-600 to-amber-400';
                        if (data === 'cancelled') badgeClass = 'bg-gradient-to-tl from-red-600 to-rose-400';
                        if (data === 'pending') badgeClass = 'bg-gradient-to-tl from-purple-700 to-pink-500';
                        
                        let label = data ? data.charAt(0).toUpperCase() + data.slice(1) : 'Pending';
                        return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${label}</span>`;
                    }
                },
                {
                    data: 'transaction_id',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: null,
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (row) {
                        if (row.referral_status === 'pending' && canChangeStatus) {
                            return `
                                <button onclick="cancelReferral(${row.id})" 
                                        class="inline-block px-3 py-1.5 mb-0 text-white font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xxs ease-soft-in shadow-soft-md bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 active:opacity-85" 
                                        title="Cancel Referral">
                                    Cancel
                                </button>
                            `;
                        }
                        return '<span class="text-xxs text-slate-400">N/A</span>';
                    }
                }
            );

            table = $('#commissionTable').DataTable({
                ajax: {
                    url: "{{ route('admin.staff-commission.index') }}",
                    type: 'GET'
                },
                columns: columns,
                order: [[isAdmin ? 4 : 3, 'desc']],
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });

            // Initialize period UI
            setPeriod('overall');

            // Handle Search Form Submission
            $('#staffSearchForm').on('submit', function (e) {
                e.preventDefault();
                let code = $('#staff_code_input').val().trim();
                if (!code) return;
                currentStaffCode = code;
                setPeriod('overall');
            });
        });

        function cancelReferral(id) {
            Swal.fire({
                title: 'Cancel Payment Link?',
                text: "Are you sure you want to cancel this referral link? The customer will no longer be able to use it to pay.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Cancel It!',
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-red-600 to-rose-400 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/staff-commission') }}/" + id + "/status",
                        type: 'POST',
                        data: { 
                            _token: "{{ csrf_token() }}",
                            status: 'cancelled'
                        },
                        success: function (response) {
                            if (response.success) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cancelled!',
                                    text: 'Referral link has been cancelled successfully.',
                                    customClass: {
                                        confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold'
                                    },
                                    buttonsStyling: false
                                });
                            } else {
                                Swal.fire('Error!', response.error || 'Something went wrong', 'error');
                            }
                        },
                        error: function (xhr) {
                            let msg = xhr.responseJSON ? xhr.responseJSON.error : 'Request failed.';
                            Swal.fire('Failed!', msg, 'error');
                        }
                    });
                }
            });
        }
    </script>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #8392ab;
            font-size: 0.75rem;
            margin-bottom: 1rem;
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
