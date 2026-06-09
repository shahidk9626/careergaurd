@extends('layouts.app')

@section('content')
    <!-- Main Listing Card -->
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h6 class="mb-1 font-bold text-slate-700">Commission Management Hub</h6>
                        <p class="text-xs text-slate-400">View and manage staff conversion metrics, earned commissions, and downloadable statement sheets.</p>
                    </div>
                    
                    <!-- Global Filters Toolbar -->
                    <div class="flex flex-wrap items-end gap-3">
                        <div class="flex flex-wrap gap-1 bg-slate-100 p-1 rounded-lg">
                            <button type="button" onclick="setGlobalPeriod('current_month')" id="btn_gperiod_current_month" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Current Month</button>
                            <button type="button" onclick="setGlobalPeriod('last_month')" id="btn_gperiod_last_month" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Last Month</button>
                            <button type="button" onclick="setGlobalPeriod('current_year')" id="btn_gperiod_current_year" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Current Year</button>
                            <button type="button" onclick="setGlobalPeriod('overall')" id="btn_gperiod_overall" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Overall</button>
                            <button type="button" onclick="setGlobalPeriod('custom')" id="btn_gperiod_custom" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Custom Range</button>
                        </div>
                        
                        <!-- Custom Date Inputs -->
                        <div id="globalCustomDateInputs" class="flex items-center gap-2" style="display: none;">
                            <input type="date" id="gfilter_start_date" class="px-2 py-1 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                            <span class="text-xs text-slate-400">to</span>
                            <input type="date" id="gfilter_end_date" class="px-2 py-1 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                            <button type="button" onclick="applyGlobalCustomFilter()" class="px-3 py-1.5 text-xs font-bold text-white bg-purple-600 hover:bg-purple-700 transition-all border-0 rounded-lg cursor-pointer">Apply</button>
                        </div>
                    </div>
                </div>
                
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="commissionListingTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Staff Code</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Staff Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Role</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Active Policies</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Premium Generated</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Commission Earned</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Commission Due</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Summary Section (Hidden by Default, loaded via AJAX) -->
    <div id="detailedSummarySection" class="flex flex-wrap -mx-3 mb-6" style="display: none;">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border p-6">
                
                <!-- Section Header -->
                <div class="flex flex-wrap items-center justify-between border-b pb-6 mb-6 gap-4">
                    <div class="flex items-center gap-4">
                        <div id="staffPhotoContainer" class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center border shadow-inner"></div>
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

                <!-- KPI Cards Section -->
                <div class="mb-6">
                    <h6 class="mb-4 font-bold text-slate-700 uppercase tracking-wider text-xs">Commission KPI Overview</h6>
                    
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <!-- Current Month Statistics -->
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-50 to-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-purple-600 uppercase block tracking-widest mb-1">Current Month Performance</span>
                                <h4 id="monthPoliciesDisplay" class="font-bold text-slate-800 mb-0">0</h4>
                                <span class="text-xs text-slate-400">Policies Converted</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-50 to-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-purple-600 uppercase block tracking-widest mb-1">Current Month Premium</span>
                                <h4 id="monthPremiumDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                                <span class="text-xs text-slate-400">Total Premium Generated</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-50 to-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-purple-600 uppercase block tracking-widest mb-1">Current Month Commission</span>
                                <h4 id="monthCommissionDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                                <span class="text-xs text-slate-400">Total Earnings</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3">
                        <!-- Overall Statistics -->
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Overall Policies</span>
                                <h4 id="overallPoliciesDisplay" class="font-bold text-slate-800 mb-0">0</h4>
                                <span class="text-xs text-slate-400">Policies Converted</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                                <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Overall Premium</span>
                                <h4 id="overallPremiumDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                                <span class="text-xs text-slate-400">Total Premium Generated</span>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-600 to-indigo-600 relative overflow-hidden shadow-md text-white h-full">
                                <div class="absolute right-4 top-4 opacity-10" style="font-size: 2.5rem;">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <span class="text-xxs font-bold text-purple-200 uppercase block tracking-widest mb-1">Overall Commission Earned</span>
                                <h4 id="overallCommissionDisplay" class="font-bold mb-0 text-white">₹0</h4>
                                <span class="text-xs text-purple-200">Total Earnings</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Table -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                        <h6 class="font-bold text-slate-700 uppercase tracking-wider text-xs mb-0">Policy Breakdown (<span id="periodRangeLabel">Overall</span>)</h6>
                        
                        @if(hasPermission('commission.export'))
                            <button type="button" id="downloadPdfBtn" onclick="downloadInvoicePdf()" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85 text-xs mb-0 border-0">
                                <i class="fas fa-file-pdf mr-1"></i> Download Commission Invoice
                            </button>
                        @endif
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="referralsDetailTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Policy Number</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Customer Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Membership Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Purchase Date</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Premium Amount</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Plan Commission</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Payment Status</th>
                                </tr>
                            </thead>
                            <tbody id="referralsDetailBody">
                                <!-- Dynamic rows -->
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
        let listingTable;
        let globalPeriod = 'overall';
        let globalStartDate = '';
        let globalEndDate = '';
        
        let currentStaffCode = '';

        function formatCurrency(amount) {
            return '₹' + parseFloat(amount).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        $(document).ready(function () {
            listingTable = $('#commissionListingTable').DataTable({
                ajax: {
                    url: "{{ route('admin.commission.index') }}",
                    type: 'GET',
                    data: function(d) {
                        d.period = globalPeriod;
                        d.start_date = globalStartDate;
                        d.end_date = globalEndDate;
                    }
                },
                columns: [
                    {
                        data: 'staff_code',
                        className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                    },
                    {
                        data: 'staff_name',
                        className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                    },
                    {
                        data: 'role',
                        className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                    },
                    {
                        data: 'active_policies',
                        className: 'text-center text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                    },
                    {
                        data: 'premium_generated',
                        className: 'text-right text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function(data) {
                            return formatCurrency(data);
                        }
                    },
                    {
                        data: 'commission_earned',
                        className: 'text-right text-sm font-bold text-purple-700 leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function(data) {
                            return formatCurrency(data);
                        }
                    },
                    {
                        data: 'commission_due',
                        className: 'text-right text-sm font-bold text-slate-700 leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function(data) {
                            return formatCurrency(data);
                        }
                    },
                    {
                        data: null,
                        className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function(row) {
                            return `
                                <button onclick="viewStaffSummary('${row.staff_code}')" class="inline-block px-3 py-1.5 mb-0 text-white font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xxs ease-soft-in shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                                    <i class="fas fa-eye mr-1"></i> View Summary
                                </button>
                            `;
                        }
                    }
                ],
                order: [[5, 'desc']],
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });

            setGlobalPeriod('overall');
        });

        function setGlobalPeriod(period) {
            globalPeriod = period;
            
            // Highlight button
            $('.gperiod-btn').removeClass('bg-white text-purple-700 shadow-soft-sm').addClass('text-slate-600 bg-transparent');
            $('#btn_gperiod_' + period).addClass('bg-white text-purple-700 shadow-soft-sm').removeClass('text-slate-600 bg-transparent');
            
            if (period === 'custom') {
                $('#globalCustomDateInputs').slideDown();
            } else {
                $('#globalCustomDateInputs').slideUp();
                globalStartDate = '';
                globalEndDate = '';
                if (listingTable) {
                    listingTable.ajax.reload();
                }
                // If detailed summary is open, reload it too
                if (currentStaffCode) {
                    loadDetailedSummary(currentStaffCode, globalPeriod, '', '');
                }
            }
        }

        function applyGlobalCustomFilter() {
            const start = $('#gfilter_start_date').val();
            const end = $('#gfilter_end_date').val();
            
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
            
            globalStartDate = start;
            globalEndDate = end;
            
            if (listingTable) {
                listingTable.ajax.reload();
            }
            
            if (currentStaffCode) {
                loadDetailedSummary(currentStaffCode, 'custom', globalStartDate, globalEndDate);
            }
        }

        function viewStaffSummary(code) {
            currentStaffCode = code;
            loadDetailedSummary(code, globalPeriod, globalStartDate, globalEndDate);
        }

        function loadDetailedSummary(code, period, start, end) {
            $.ajax({
                url: "{{ route('admin.commission.summary') }}",
                type: 'GET',
                data: {
                    staff_code: code,
                    period: period,
                    start_date: start,
                    end_date: end
                },
                success: function(response) {
                    if (response.success) {
                        const staff = response.staff;
                        
                        // Profile Header
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
                        
                        if (staff.profile_image) {
                            $('#staffPhotoContainer').html(`<img src="${staff.profile_image}" class="w-full h-full object-cover">`);
                        } else {
                            $('#staffPhotoContainer').html(`<i class="fas fa-user-tie text-2xl text-slate-400"></i>`);
                        }
                        
                        // Current Month KPI Card values
                        $('#monthPoliciesDisplay').text(response.current_month.total_policies);
                        $('#monthPremiumDisplay').text(formatCurrency(response.current_month.total_premium));
                        $('#monthCommissionDisplay').text(formatCurrency(response.current_month.total_commission));
                        
                        // Overall KPI Card values
                        $('#overallPoliciesDisplay').text(response.overall.total_policies);
                        $('#overallPremiumDisplay').text(formatCurrency(response.overall.total_premium));
                        $('#overallCommissionDisplay').text(formatCurrency(response.overall.total_commission));
                        
                        // Labels
                        $('#periodRangeLabel').text(response.period.label);
                        
                        // Render detailed rows
                        let rowsHtml = '';
                        if (response.period.referrals && response.period.referrals.length > 0) {
                            $.each(response.period.referrals, function(idx, ref) {
                                let badgeClass = ref.status === 'active' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-red-600 to-rose-400';
                                rowsHtml += `
                                    <tr>
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-700 font-mono">${ref.policy_number}</td>
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-800">${ref.customer_name}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600">${ref.membership_name}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600">${ref.purchase_date}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-right font-semibold text-slate-800">${formatCurrency(ref.premium_amount)}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-right font-bold text-purple-700">${formatCurrency(ref.commission_amount)}</td>
                                        <td class="px-2 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">
                                            <span class="text-xxs px-2.5 py-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">SUCCESS</span>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            rowsHtml = `
                                <tr>
                                    <td colspan="7" class="text-center text-slate-400 italic py-6 text-sm">
                                        No commission records found for this period.
                                    </td>
                                </tr>
                            `;
                        }
                        $('#referralsDetailBody').html(rowsHtml);
                        
                        // Slide Down
                        $('#detailedSummarySection').slideDown();
                        
                        // Scroll to section
                        $('html, body').animate({
                            scrollTop: $("#detailedSummarySection").offset().top - 20
                        }, 500);
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.error : 'Failed to retrieve summaries', 'error');
                }
            });
        }

        function downloadInvoicePdf() {
            if (!currentStaffCode) return;
            
            let url = "{{ route('admin.commission.export-pdf') }}";
            let params = {
                staff_code: currentStaffCode,
                period: globalPeriod
            };
            
            if (globalPeriod === 'custom') {
                if (!globalStartDate || !globalEndDate) {
                    Swal.fire('Warning', 'Please select custom range dates first.', 'warning');
                    return;
                }
                params.start_date = globalStartDate;
                params.end_date = globalEndDate;
            }
            
            window.location.href = url + '?' + $.param(params);
        }
    </script>
    
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #8392ab;
            font-size: 0.75rem;
            margin: 1rem;
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
