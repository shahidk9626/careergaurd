@extends('layouts.app')

@section('content')

<style>
/* ============================================
   COMMISSION HUB — UI-only overrides
   No structural changes, no backend impact
============================================= */

/* Header card polish */
.cmh-card-head h6 {
    font-size: 17px !important;
    font-weight: 700 !important;
    color: #1e293b !important;
    letter-spacing: -0.01em;
}
.cmh-card-head p {
    font-size: 13px !important;
    color: #94a3b8 !important;
}

/* Filter labels */
.cmh-filter-label {
    font-size: 10px !important;
    font-weight: 700 !important;
    color: #64748b !important;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 6px;
    display: block;
}

/* Period pill group */
.cmh-period-tabs {
    display: inline-flex !important;
    gap: 2px;
    padding: 4px !important;
    background: #f1f5f9 !important;
    border-radius: 10px !important;
}
.gperiod-btn {
    padding: 7px 14px !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    color: #64748b !important;
    background: transparent !important;
    border: none !important;
    border-radius: 7px !important;
    cursor: pointer;
    transition: all 0.2s;
}
.gperiod-btn:hover { color: #1e293b !important; }
.gperiod-btn.cmh-active {
    background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%) !important;
    color: #fff !important;
    box-shadow: 0 2px 6px -1px rgba(126, 34, 206, 0.3) !important;
}

/* Status/batch/date inputs */
.cmh-input,
#gfilter_status,
#gfilter_batch,
#gfilter_start_date,
#gfilter_end_date {
    height: 38px !important;
    padding: 0 12px !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 8px !important;
    background: #fff !important;
    font-size: 12.5px !important;
    color: #1e293b !important;
    outline: none !important;
    transition: all 0.2s;
}
#gfilter_status {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath fill='%23888' d='M0 0l5 6 5-6z'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    padding-right: 30px !important;
    min-width: 160px;
}
#gfilter_status:focus,
#gfilter_batch:focus,
#gfilter_start_date:focus,
#gfilter_end_date:focus {
    border-color: #a855f7 !important;
    box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1) !important;
}

/* ===== STAFF PROFILE — FIXES SQUISHED ICONS ===== */
#staffPhotoContainer {
    width: 64px !important;
    height: 64px !important;
    border-radius: 14px !important;
    background: linear-gradient(135deg, #faf5ff 0%, #fdf2f8 100%) !important;
    border: 1px solid #f3e8ff !important;
    color: #a855f7 !important;
    flex-shrink: 0;
}
#staffPhotoContainer i { font-size: 26px !important; color: #a855f7 !important; }
#staffPhotoContainer img { width: 100% !important; height: 100% !important; object-fit: cover; }

#staffNameDisplay {
    color: #1e293b !important;
    font-size: 18px !important;
    font-weight: 700 !important;
    letter-spacing: -0.01em;
    margin-bottom: 8px !important;
}
#staffCodeDisplay,
#staffRoleDisplay {
    height: 22px;
    display: inline-flex !important;
    align-items: center;
    padding: 0 10px !important;
    font-size: 10.5px !important;
    font-weight: 700 !important;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-radius: 6px !important;
    line-height: 1;
}
#staffCodeDisplay { background: #faf5ff !important; color: #7e22ce !important; border: 1px solid #f3e8ff !important; }
#staffRoleDisplay { background: #f1f5f9 !important; color: #475569 !important; border: 1px solid #e2e8f0 !important; }

/* THE ACTUAL FIX for squished envelope/phone/calendar icons */
#detailedSummarySection .flex.flex-wrap.gap-x-6 {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 10px 24px !important;
    font-size: 13px !important;
    color: #64748b !important;
    align-items: center;
}
#detailedSummarySection .flex.flex-wrap.gap-x-6 > div {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    white-space: nowrap;
    line-height: 1.4;
}
#detailedSummarySection .flex.flex-wrap.gap-x-6 > div i {
    font-size: 13px !important;
    width: 16px !important;
    text-align: center;
    color: #a855f7 !important;
    margin-right: 0 !important;
    flex-shrink: 0;
}
#detailedSummarySection .flex.flex-wrap.gap-x-6 > div i.text-green-500 { color: #22c55e !important; }
#detailedSummarySection .flex.flex-wrap.gap-x-6 > div i.text-red-500 { color: #ef4444 !important; }
#detailedSummarySection .flex.flex-wrap.gap-x-6 > div span {
    color: #334155 !important;
    font-weight: 500;
}
#staffStatusDot { font-size: 8px !important; }

/* KPI cards polish */
.border.rounded-2xl.p-4 {
    padding: 20px !important;
    border-radius: 14px !important;
    border-color: #f1f5f9 !important;
    transition: all 0.25s;
    min-height: 110px;
}
.border.rounded-2xl.p-4:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.08);
}
.bg-gradient-to-br.from-purple-50 { background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%) !important; border-color: #e9d5ff !important; }
.bg-gradient-to-br.from-green-50  { background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%) !important; border-color: #bbf7d0 !important; }
.bg-gradient-to-br.from-orange-50 { background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%) !important; border-color: #fed7aa !important; }
.bg-gradient-to-br.from-red-50    { background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%) !important; border-color: #fecaca !important; }
.border.rounded-2xl.p-4 .text-xxs.font-bold {
    font-size: 10px !important;
    letter-spacing: 0.12em !important;
    margin-bottom: 10px !important;
}
.border.rounded-2xl.p-4 h4 {
    font-size: 26px !important;
    font-weight: 800 !important;
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin-bottom: 4px !important;
}

/* Tab polish */
#summaryTabs button {
    font-weight: 700 !important;
    font-size: 13px !important;
    padding: 14px 20px !important;
    transition: all 0.2s;
}
#summaryTabs button.text-purple-600 {
    color: #7e22ce !important;
    border-bottom-color: #7e22ce !important;
    border-bottom-width: 2px !important;
}

/* Section header labels */
h6.uppercase.tracking-wider.text-xs {
    font-size: 10px !important;
    letter-spacing: 0.12em !important;
    color: #94a3b8 !important;
    font-weight: 700 !important;
}

/* ===== VIEW SUMMARY BUTTON — replaces pink pill with clean icon ===== */
.cmh-view-btn {
    width: 32px !important;
    height: 32px !important;
    padding: 0 !important;
    border-radius: 8px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: #fff !important;
    border: 1px solid #e2e8f0 !important;
    color: #64748b !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    font-size: 13px !important;
    box-shadow: none !important;
}
.cmh-view-btn:hover {
    transform: translateY(-1px);
    background: #faf5ff !important;
    color: #7e22ce !important;
    border-color: #e9d5ff !important;
}
.cmh-view-btn i { margin: 0 !important; }

/* DataTables polish */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    color: #64748b !important;
    font-size: 12px !important;
    margin: 1rem;
}
.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
    height: 32px;
    padding: 0 10px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 12px;
    outline: none;
    margin-left: 6px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 8px !important;
}

table.dataTable tbody td {
    vertical-align: middle !important;
    border-bottom: 1px solid #f8f9fa !important;
}

/* Modal title polish */
.cmh-card { border-radius: 16px !important; }

@media (max-width: 768px) {
    #detailedSummarySection .flex.flex-wrap.gap-x-6 {
        gap: 8px 16px !important;
    }
}
/* ===== COMMISSION HUB — MOBILE ===== */
@media (max-width: 768px) {
    /* Stack header title above the filters */
    .cmh-card-head {
        flex-direction: column;
        align-items: stretch !important;
    }
    .cmh-card-head > div:first-child {
        margin-bottom: 12px;
    }

    /* Filters toolbar: stack each field full-width */
    .cmh-card-head .flex.flex-wrap.items-end {
        flex-direction: column;
        align-items: stretch !important;
        gap: 12px !important;
        width: 100%;
    }
    .cmh-card-head .flex.flex-wrap.items-end > .flex.flex-col {
        width: 100%;
    }

    /* Period pills: let them wrap instead of overflowing */
    .cmh-period-tabs {
        display: flex !important;
        flex-wrap: wrap;
        width: 100%;
    }
    .gperiod-btn {
        flex: 1 1 auto;
        text-align: center;
        white-space: nowrap;
    }

    /* Status select + batch input full width */
    #gfilter_status {
        width: 100% !important;
        min-width: 0 !important;
    }
    #gfilter_batch {
        width: 100% !important;
    }

    /* Custom date inputs stack too */
    #globalCustomDateInputs {
        flex-wrap: wrap;
        width: 100%;
    }
    #gfilter_start_date,
    #gfilter_end_date {
        flex: 1 1 100%;
    }
}
</style>

<!-- Main Listing Card -->
<div class="flex flex-wrap -mx-3 mb-6">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border cmh-card">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl flex items-center justify-between flex-wrap gap-4 cmh-card-head">
                <div>
                    <h6 class="mb-1 font-bold text-slate-700">Commission Management Hub</h6>
                    <p class="text-xs text-slate-400">View and manage staff conversion metrics, earned commissions, and downloadable statement sheets.</p>
                </div>

                <!-- Global Filters Toolbar -->
                <div class="flex flex-wrap items-end gap-3">
                    <div class="flex flex-col">
                        <label class="cmh-filter-label">Period</label>
                        <div class="cmh-period-tabs">
                            <button type="button" onclick="setGlobalPeriod('current_month')" id="btn_gperiod_current_month" class="gperiod-btn">Current Month</button>
                            <button type="button" onclick="setGlobalPeriod('last_month')" id="btn_gperiod_last_month" class="gperiod-btn">Last Month</button>
                            <button type="button" onclick="setGlobalPeriod('current_year')" id="btn_gperiod_current_year" class="gperiod-btn">Current Year</button>
                            <button type="button" onclick="setGlobalPeriod('overall')" id="btn_gperiod_overall" class="gperiod-btn cmh-active">Overall</button>
                            <button type="button" onclick="setGlobalPeriod('custom')" id="btn_gperiod_custom" class="gperiod-btn">Custom Range</button>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label class="cmh-filter-label">Status</label>
                        <select id="gfilter_status" onchange="applyGlobalFilters()">
                            <option value="">All Statuses</option>
                            <option value="Pending">Pending</option>
                            <option value="Paid">Paid</option>
                            <option value="Hold">Hold</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="cmh-filter-label">Batch Ref</label>
                        <input type="text" id="gfilter_batch" onkeyup="applyGlobalFilters()" placeholder="e.g. COM-..." style="width: 140px;">
                    </div>

                    <div id="globalCustomDateInputs" class="flex items-center gap-2" style="display: none; margin-bottom: 0;">
                        <input type="date" id="gfilter_start_date">
                        <span class="text-xs text-slate-400">to</span>
                        <input type="date" id="gfilter_end_date">
                        <button type="button" onclick="applyGlobalCustomFilter()" style="height: 38px; padding: 0 16px; font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #fff; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 8px; cursor: pointer;">Apply</button>
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
                                <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Policies</th>
                                <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Premium</th>
                                <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Earned</th>
                                <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Paid</th>
                                <th class="px-6 py-3 pl-2 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Due</th>
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
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border p-6 cmh-card">

            <!-- Section Header -->
            <div class="flex flex-wrap items-center justify-between border-b pb-6 mb-6 gap-4">
                <div class="flex items-center gap-4">
                    <div id="staffPhotoContainer" class="overflow-hidden flex items-center justify-center"></div>
                    <div>
                        <h5 id="staffNameDisplay" class="mb-0 font-bold text-slate-800 text-lg"></h5>
                        <div class="flex items-center gap-2 mt-1">
                            <span id="staffCodeDisplay" class="text-xs font-semibold"></span>
                            <span id="staffRoleDisplay" class="text-xs font-semibold"></span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-x-6 gap-y-2 text-xs text-slate-500">
                    <div><i class="fas fa-envelope"></i> <span id="staffEmailDisplay"></span></div>
                    <div><i class="fas fa-phone"></i> <span id="staffPhoneDisplay"></span></div>
                    <div><i class="fas fa-calendar-alt"></i> Joining Date: <span id="staffJoiningDisplay"></span></div>
                    <div><i class="fas fa-circle text-green-500" id="staffStatusDot"></i> Status: <span id="staffStatusDisplay" class="font-bold"></span></div>
                </div>
            </div>

            <!-- KPI Cards Section -->
            <div class="mb-6">
                <h6 class="mb-4 font-bold text-slate-700 uppercase tracking-wider text-xs">Commission KPI Overview</h6>

                <!-- Overall Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="border rounded-2xl p-4 bg-gradient-to-br from-purple-50 to-white relative overflow-hidden shadow-sm h-full">
                        <span class="text-xxs font-bold text-purple-600 uppercase block tracking-widest mb-1">Overall Earned</span>
                        <h4 id="overallCommissionDisplay" class="font-bold text-slate-850 mb-0">₹0</h4>
                        <span class="text-xs text-slate-400">Total Earned</span>
                    </div>
                    <div class="border rounded-2xl p-4 bg-gradient-to-br from-green-50 to-white relative overflow-hidden shadow-sm h-full">
                        <span class="text-xxs font-bold text-green-600 uppercase block tracking-widest mb-1">Overall Paid</span>
                        <h4 id="overallPaidDisplay" class="font-bold text-slate-850 mb-0">₹0</h4>
                        <span class="text-xs text-slate-400">Total Settled</span>
                    </div>
                    <div class="border rounded-2xl p-4 bg-gradient-to-br from-orange-50 to-white relative overflow-hidden shadow-sm h-full">
                        <span class="text-xxs font-bold text-orange-600 uppercase block tracking-widest mb-1">Overall Due</span>
                        <h4 id="overallDueDisplay" class="font-bold text-slate-850 mb-0">₹0</h4>
                        <span class="text-xs text-slate-400">Total Pending / Hold</span>
                    </div>
                    <div class="border rounded-2xl p-4 bg-gradient-to-br from-red-50 to-white relative overflow-hidden shadow-sm h-full">
                        <span class="text-xxs font-bold text-red-600 uppercase block tracking-widest mb-1">Overall Rejected</span>
                        <h4 id="overallRejectedDisplay" class="font-bold text-slate-850 mb-0">₹0</h4>
                        <span class="text-xs text-slate-400">Rejected Commission</span>
                    </div>
                </div>

                <!-- Current Month Statistics -->
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                            <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Month Policies</span>
                            <h4 id="monthPoliciesDisplay" class="font-bold text-slate-800 mb-0">0</h4>
                            <span class="text-xs text-slate-400">Policies Converted</span>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                            <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Month Premium</span>
                            <h4 id="monthPremiumDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                            <span class="text-xs text-slate-400">Total Premium Generated</span>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <div class="border rounded-2xl p-4 bg-white relative overflow-hidden shadow-sm h-full">
                            <span class="text-xxs font-bold text-slate-500 uppercase block tracking-widest mb-1">Month Commission</span>
                            <h4 id="monthCommissionDisplay" class="font-bold text-slate-800 mb-0">₹0</h4>
                            <span class="text-xs text-slate-400">Total Earnings</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="mb-6 border-b">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="summaryTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg font-bold text-purple-600 border-purple-600 bg-transparent border-0 cursor-pointer transition-all" id="policies-tab" data-tabs-target="#policies-panel" type="button" role="tab" aria-controls="policies-panel" aria-selected="true">
                            <i class="fas fa-file-invoice mr-2"></i> Policy Breakdown
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg font-bold text-slate-500 bg-transparent border-0 cursor-pointer transition-all" id="history-tab" data-tabs-target="#history-panel" type="button" role="tab" aria-controls="history-panel" aria-selected="false" onclick="loadPaymentHistory()">
                            <i class="fas fa-history mr-2"></i> Payment Settlement History
                        </button>
                    </li>
                </ul>
            </div>

            <div id="summaryTabsContent">
                <!-- Tab Panel 1: Policy Breakdown -->
                <div class="p-0 rounded-lg" id="policies-panel" role="tabpanel" aria-labelledby="policies-tab">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                        <h6 class="font-bold text-slate-700 uppercase tracking-wider text-xs mb-0">Policy Breakdown (<span id="periodRangeLabel">Overall</span>)</h6>

                        <div class="flex gap-2">
                            <button type="button" id="bulkPayBtn" style="display: none;" onclick="openBulkPayModal()" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-green-600 to-lime-500 hover:scale-102 active:opacity-85 text-xs mb-0">
                                <i class="fas fa-coins mr-1"></i> Pay Selected (<span id="selectedCount">0</span>)
                            </button>

                            @if(hasPermission('commission.export'))
                                <button type="button" id="downloadPdfBtn" onclick="downloadInvoicePdf()" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85 text-xs mb-0">
                                    <i class="fas fa-file-pdf mr-1"></i> Download Commission Statement
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="referralsDetailTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                @if($isAdmin)
                                    <th class="px-4 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400" style="width: 40px;">
                                        <input type="checkbox" id="selectAllPolicies" class="rounded text-purple-600 cursor-pointer">
                                    </th>
                                @endif
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Policy Number</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Customer Name</th>
                                    <th class="px-2 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Membership Name</th>
                                    <th class="px-2 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Purchase Date</th>
                                    <th class="px-2 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Premium</th>
                                    <th class="px-2 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Commission</th>
                                    <th class="px-2 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Status</th>
                                    <th class="px-2 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Action</th>
                                </tr>
                            </thead>
                            <tbody id="referralsDetailBody">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Panel 2: Payment Settlement History -->
                <div class="p-0 rounded-lg hidden" id="history-panel" role="tabpanel" aria-labelledby="history-tab">
                    <div class="flex items-center justify-between mb-4">
                        <h6 class="font-bold text-slate-700 uppercase tracking-wider text-xs mb-0">Commission Settlement Logs</h6>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="historyTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Batch Reference</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Payment Date</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Policies</th>
                                    <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Total Settled</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Description</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Proof</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Created By</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Action</th>
                                </tr>
                            </thead>
                            <tbody id="historyBody">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Manage Commission Modal -->
<div id="manageCommissionModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background-color: #ffffff; width: 100%; max-width: 500px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column;">
        <form id="manageCommissionForm" enctype="multipart/form-data" style="display: flex; flex-direction: column; margin: 0;">
            @csrf
            <input type="hidden" name="purchased_plan_id" id="manage_policy_id">

            <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h6 style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Manage Commission</h6>
                <button type="button" onclick="closeManageCommissionModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
            </div>

            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Commission Status <span style="color: #ef4444;">*</span></label>
                    <select name="status" id="manage_status" onchange="toggleManageFields()" required style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: white;">
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                        <option value="Hold">Hold</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div id="manage_screenshot_container" style="display: none;">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Payment Proof Screenshot <span style="color: #ef4444;">*</span></label>
                    <input type="file" name="screenshot" id="manage_screenshot" accept=".jpg,.jpeg,.png,.pdf" style="width: 100%; font-size: 0.875rem;">
                    <small style="color: #64748b; font-size: 10px;">Allowed: JPG, PNG, PDF up to 4MB.</small>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Description / Reason <span id="manage_desc_required" style="color: #ef4444; display: none;">*</span></label>
                    <textarea name="description" id="manage_description" rows="3" style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Enter reason or reference info..."></textarea>
                </div>
            </div>

            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeManageCommissionModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Settle Modal -->
<div id="bulkSettleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background-color: #ffffff; width: 100%; max-width: 500px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column;">
        <form id="bulkSettleForm" enctype="multipart/form-data" style="display: flex; flex-direction: column; margin: 0;">
            @csrf
            <input type="hidden" name="staff_code" id="bulk_staff_code">
            <div id="bulk_policy_ids_inputs"></div>

            <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h6 style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Bulk Payout Settlement</h6>
                <button type="button" onclick="closeBulkSettleModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
            </div>

            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
                <div style="padding: 0.75rem; background-color: #f1f5f9; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <span class="text-xs text-slate-500 font-semibold block">Total Selected Policies: <strong id="bulk_policies_count" class="text-slate-800">0</strong></span>
                    <span class="text-xs text-slate-500 font-semibold block">Total Payout Amount: <strong id="bulk_total_amount" class="text-purple-700 font-bold">₹0.00</strong></span>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Payment Date <span style="color: #ef4444;">*</span></label>
                    <input type="date" name="payment_date" id="bulk_payment_date" required style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Payment Proof Screenshot <span style="color: #ef4444;">*</span></label>
                    <input type="file" name="screenshot" id="bulk_screenshot" accept=".jpg,.jpeg,.png,.pdf" required style="width: 100%; font-size: 0.875rem;">
                    <small style="color: #64748b; font-size: 10px;">Allowed: JPG, PNG, PDF up to 4MB.</small>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Description / Note</label>
                    <textarea name="description" id="bulk_description" rows="3" style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Enter payout batch notes..."></textarea>
                </div>
            </div>

            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeBulkSettleModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Confirm Payout</button>
            </div>
        </form>
    </div>
</div>

<!-- View Proof Modal -->
<div id="viewProofModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background-color: #ffffff; width: 100%; max-width: 700px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 85vh;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h6 style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Payment Proof Document</h6>
            <div style="display: flex; gap: 8px;">
                <a id="downloadProofLink" href="#" download class="inline-block px-3 py-1 bg-purple-600 text-white rounded text-xs font-bold decoration-none"><i class="fas fa-download"></i> Download</a>
                <button type="button" onclick="closeProofModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
            </div>
        </div>
        <div id="proofViewerBody" style="padding: 1.5rem; overflow-y: auto; text-align: center; display: flex; align-items: center; justify-content: center; min-height: 300px;">
            <!-- Dynamically loaded img or iframe for PDF -->
        </div>
    </div>
</div>

<!-- Batch Details Modal -->
<div id="batchDetailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background-color: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 80vh;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h6 style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Batch Settlement Details</h6>
            <button type="button" onclick="closeBatchDetailModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
        </div>
        <div style="padding: 1.5rem; overflow-y: auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; font-size: 13px; background-color: #f8fafc; padding: 12px; border-radius: 8px;">
                <div><strong>Batch Reference:</strong> <span id="batch_ref_text"></span></div>
                <div><strong>Payment Date:</strong> <span id="batch_date_text"></span></div>
                <div><strong>Total Amount:</strong> <span id="batch_amount_text" class="text-green-600 font-bold"></span></div>
                <div><strong>Total Policies:</strong> <span id="batch_count_text"></span></div>
            </div>
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th class="border-b text-left py-2 font-bold uppercase text-xxs">Policy Number</th>
                        <th class="border-b text-left py-2 font-bold uppercase text-xxs">Customer Name</th>
                        <th class="border-b text-right py-2 font-bold uppercase text-xxs">Commission Paid</th>
                    </tr>
                </thead>
                <tbody id="batch_policies_body"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        const isAdmin = @json($isAdmin);
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
                        d.status = $('#gfilter_status').val();
                        d.batch_reference = $('#gfilter_batch').val();
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
                        data: 'commission_paid',
                        className: 'text-right text-sm font-bold text-green-600 leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
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
                                <button onclick="viewStaffSummary('${row.staff_code}')" class="cmh-view-btn" title="View Summary">
                                    <i class="fas fa-eye"></i>
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
                },
                initComplete: function(settings, json) {
                    if (!isAdmin) {
                        if (json.data && json.data.length > 0) {
                            viewStaffSummary(json.data[0].staff_code);
                        }
                    }
                }
            });

            // Handle individual Form Submission
            $('#manageCommissionForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('admin.commission.manage') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire('Success', response.success, 'success');
                        closeManageCommissionModal();
                        applyGlobalFilters();
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.error : 'Failed to update commission.', 'error');
                    }
                });
            });

            // Handle Bulk Form Submission
            $('#bulkSettleForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('admin.commission.bulk-settle') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire('Success', response.success, 'success');
                        closeBulkSettleModal();
                        applyGlobalFilters();
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON ? xhr.responseJSON.error : 'Failed to settle commissions.', 'error');
                    }
                });
            });

            // Tab Switching Logic
            $(document).on('click', '[data-tabs-target]', function() {
                const target = $(this).attr('data-tabs-target');
                $('#summaryTabsContent > div').addClass('hidden');
                $(target).removeClass('hidden');

                $('#summaryTabs button').removeClass('text-purple-600 border-purple-600').addClass('text-slate-500 border-transparent');
                $(this).addClass('text-purple-600 border-purple-600').removeClass('text-slate-500 border-transparent');
            });

            // Checkbox selections checking
            $(document).on('change', '#selectAllPolicies', function() {
                $('.policy-checkbox').prop('checked', this.checked);
                recalculateSelections();
            });

            $(document).on('change', '.policy-checkbox', function() {
                if (!this.checked) {
                    $('#selectAllPolicies').prop('checked', false);
                } else if ($('.policy-checkbox:checked').length === $('.policy-checkbox').length) {
                    $('#selectAllPolicies').prop('checked', true);
                }
                recalculateSelections();
            });
        });

        function setGlobalPeriod(period) {
            globalPeriod = period;
            $('.gperiod-btn').removeClass('cmh-active');
            $('#btn_gperiod_' + period).addClass('cmh-active');

            if (period === 'custom') {
                $('#globalCustomDateInputs').css('display', 'flex');
            } else {
                $('#globalCustomDateInputs').hide();
                globalStartDate = '';
                globalEndDate = '';
                applyGlobalFilters();
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
            applyGlobalFilters();
        }

        function applyGlobalFilters() {
            if (listingTable) {
                listingTable.ajax.reload();
            }
            if (currentStaffCode) {
                loadDetailedSummary(currentStaffCode, globalPeriod, globalStartDate, globalEndDate);
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
                    end_date: end,
                    status: $('#gfilter_status').val(),
                    batch_reference: $('#gfilter_batch').val()
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
                            $('#staffPhotoContainer').html(`<i class="fas fa-user-tie"></i>`);
                        }

                        // KPI Card values
                        $('#overallCommissionDisplay').text(formatCurrency(response.period.total_commission));
                        $('#overallPaidDisplay').text(formatCurrency(response.period.total_paid));
                        $('#overallDueDisplay').text(formatCurrency(response.period.total_due));
                        $('#overallRejectedDisplay').text(formatCurrency(response.period.total_rejected));

                        // Monthly Month KPI values
                        $('#monthPoliciesDisplay').text(response.current_month.total_policies);
                        $('#monthPremiumDisplay').text(formatCurrency(response.current_month.total_premium));
                        $('#monthCommissionDisplay').text(formatCurrency(response.current_month.total_commission));

                        // Period range label
                        $('#periodRangeLabel').text(response.period.label);

                        // Reset selectAll Checkbox
                        $('#selectAllPolicies').prop('checked', false);
                        $('#bulkPayBtn').hide();

                        // Render detailed breakdown rows
                        let rowsHtml = '';
                        if (response.period.referrals && response.period.referrals.length > 0) {
                            $.each(response.period.referrals, function(idx, ref) {
                                let badgeColor = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                                if (ref.commission_status === 'Paid') badgeColor = 'bg-gradient-to-tl from-green-600 to-lime-400';
                                if (ref.commission_status === 'Hold') badgeColor = 'bg-gradient-to-tl from-yellow-600 to-orange-400';
                                if (ref.commission_status === 'Rejected') badgeColor = 'bg-gradient-to-tl from-red-600 to-rose-400';

                                let checkbox = '';
                                if (isAdmin && ref.commission_status !== 'Paid') {
                                    checkbox = `<input type="checkbox" class="policy-checkbox rounded text-purple-600 cursor-pointer" value="${ref.id}" data-amount="${ref.commission_amount}">`;
                                }

                                let actionBtn = '';
                                if (isAdmin) {
                                    if (ref.commission_status !== 'Paid') {
                                        actionBtn = `
                                            <button type="button" onclick="openManageModal(${ref.id}, '${ref.commission_status}', '${ref.reason}')" class="inline-block px-3 py-1 mb-0 text-white font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xxs ease-soft-in shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102">
                                                <i class="fas fa-edit mr-1"></i> Manage
                                            </button>
                                        `;
                                    } else if (ref.payment_proof) {
                                        actionBtn = `
                                            <button type="button" onclick="viewProof('${ref.payment_proof}')" class="inline-block px-3 py-1 mb-0 text-white font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xxs ease-soft-in shadow-soft-md bg-gradient-to-tl from-green-600 to-lime-500 hover:scale-102">
                                                <i class="fas fa-file-invoice mr-1"></i> View Proof
                                            </button>
                                        `;
                                    }
                                } else {
                                    if (ref.commission_status === 'Paid' && ref.payment_proof) {
                                        actionBtn = `
                                            <button type="button" onclick="viewProof('${ref.payment_proof}')" class="inline-block px-3 py-1 mb-0 text-white font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xxs ease-soft-in shadow-soft-md bg-gradient-to-tl from-green-600 to-lime-500 hover:scale-102">
                                                <i class="fas fa-file-invoice mr-1"></i> View Proof
                                            </button>
                                        `;
                                    }
                                }

                                rowsHtml += `
                                    <tr>
                                        ${isAdmin ? `<td class="px-4 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">${checkbox}</td>` : ''}
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-700 font-mono">${ref.policy_number}</td>
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-800">${ref.customer_name}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600">${ref.membership_name}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600">${ref.purchase_date}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-right font-semibold text-slate-800">${formatCurrency(ref.premium_amount)}</td>
                                        <td class="px-2 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none text-right font-bold text-purple-700">${formatCurrency(ref.commission_amount)}</td>
                                        <td class="px-2 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">
                                            <span class="text-xxs px-2.5 py-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeColor}">${ref.commission_status}</span>
                                        </td>
                                        <td class="px-2 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">${actionBtn}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            rowsHtml = `
                                <tr>
                                    <td colspan="${isAdmin ? 9 : 8}" class="text-center text-slate-400 italic py-6 text-sm">
                                        No commission records found matching the filters.
                                    </td>
                                </tr>
                            `;
                        }
                        $('#referralsDetailBody').html(rowsHtml);

                        $('#policies-tab').trigger('click');
                        $('#detailedSummarySection').slideDown();

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

        function recalculateSelections() {
            let selectedCheckboxes = $('.policy-checkbox:checked');
            let count = selectedCheckboxes.length;
            let total = 0;

            selectedCheckboxes.each(function() {
                total += parseFloat($(this).attr('data-amount'));
            });

            if (count > 0) {
                $('#selectedCount').text(count);
                $('#bulkPayBtn').show();
            } else {
                $('#bulkPayBtn').hide();
            }
        }

        function openManageModal(id, status, description) {
            $('#manage_policy_id').val(id);
            $('#manage_status').val(status);
            $('#manage_description').val(description !== 'null' ? description : '');
            $('#manage_screenshot').val('');

            toggleManageFields();
            $('#manageCommissionModal').css('display', 'flex');
        }

        function closeManageCommissionModal() {
            $('#manageCommissionModal').hide();
        }

        function toggleManageFields() {
            let status = $('#manage_status').val();
            if (status === 'Paid') {
                $('#manage_screenshot_container').show();
                $('#manage_screenshot').prop('required', true);
                $('#manage_desc_required').hide();
                $('#manage_description').prop('required', false);
            } else if (status === 'Hold' || status === 'Rejected') {
                $('#manage_screenshot_container').hide();
                $('#manage_screenshot').prop('required', false);
                $('#manage_desc_required').show();
                $('#manage_description').prop('required', true);
            } else {
                $('#manage_screenshot_container').hide();
                $('#manage_screenshot').prop('required', false);
                $('#manage_desc_required').hide();
                $('#manage_description').prop('required', false);
            }
        }

        function openBulkPayModal() {
            let selectedCheckboxes = $('.policy-checkbox:checked');
            let count = selectedCheckboxes.length;
            let total = 0;
            let hiddenInputsHtml = '';

            selectedCheckboxes.each(function() {
                let id = $(this).val();
                hiddenInputsHtml += `<input type="hidden" name="policy_ids[]" value="${id}">`;
                total += parseFloat($(this).attr('data-amount'));
            });

            $('#bulk_staff_code').val(currentStaffCode);
            $('#bulk_policy_ids_inputs').html(hiddenInputsHtml);
            $('#bulk_policies_count').text(count);
            $('#bulk_total_amount').text(formatCurrency(total));
            $('#bulk_payment_date').val(new Date().toISOString().substring(0, 10));
            $('#bulk_screenshot').val('');
            $('#bulk_description').val('');

            $('#bulkSettleModal').css('display', 'flex');
        }

        function closeBulkSettleModal() {
            $('#bulkSettleModal').hide();
        }

        function viewProof(url) {
            let fileExt = url.split('.').pop().toLowerCase();
            let viewerHtml = '';
            if (fileExt === 'pdf') {
                viewerHtml = `<iframe src="${url}" style="width: 100%; height: 500px; border: none;"></iframe>`;
            } else {
                viewerHtml = `<img src="${url}" class="img-fluid rounded" style="max-height: 500px; max-width: 100%; object-fit: contain;">`;
            }

            $('#proofViewerBody').html(viewerHtml);
            $('#downloadProofLink').attr('href', url);
            $('#viewProofModal').css('display', 'flex');
        }

        function closeProofModal() {
            $('#viewProofModal').hide();
        }

        let currentBatchPolicies = [];
        function openBatchDetail(idx) {
            let payment = currentBatchPolicies[idx];
            $('#batch_ref_text').text(payment.batch_reference);
            $('#batch_date_text').text(payment.payment_date);
            $('#batch_amount_text').text(formatCurrency(payment.amount));
            $('#batch_count_text').text(payment.total_policies);

            let rowsHtml = '';
            $.each(payment.policies, function(i, d) {
                rowsHtml += `
                    <tr>
                        <td class="py-2 font-mono">${d.policy_number}</td>
                        <td class="py-2">${d.customer_name}</td>
                        <td class="py-2 text-right font-bold text-slate-800">${formatCurrency(d.amount)}</td>
                    </tr>
                `;
            });
            $('#batch_policies_body').html(rowsHtml);
            $('#batchDetailModal').css('display', 'flex');
        }

        function closeBatchDetailModal() {
            $('#batchDetailModal').hide();
        }

        function loadPaymentHistory() {
            if (!currentStaffCode) return;
            $.ajax({
                url: "{{ route('admin.commission.payment-history') }}",
                type: 'GET',
                data: { staff_code: currentStaffCode },
                success: function(response) {
                    if (response.success) {
                        currentBatchPolicies = response.payments;
                        let rowsHtml = '';
                        if (response.payments && response.payments.length > 0) {
                            $.each(response.payments, function(idx, p) {
                                let proofBtn = p.proof ? `<button type="button" onclick="viewProof('${p.proof}')" class="inline-block px-3 py-1 mb-0 text-white font-bold text-center uppercase align-middle bg-gradient-to-tl from-green-600 to-lime-500 rounded-lg text-xxs cursor-pointer shadow-soft-sm"><i class="fas fa-file-invoice"></i> Proof</button>` : '<span class="text-xs italic text-slate-400">None</span>';

                                rowsHtml += `
                                    <tr>
                                        <td class="px-6 py-3 text-sm font-semibold align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-700 font-mono">${p.batch_reference}</td>
                                        <td class="px-6 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none">${p.payment_date}</td>
                                        <td class="px-6 py-3 text-sm text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">${p.total_policies}</td>
                                        <td class="px-6 py-3 text-sm text-right font-bold text-green-600 align-middle bg-transparent border-b whitespace-nowrap shadow-none">${formatCurrency(p.amount)}</td>
                                        <td class="px-6 py-3 text-sm align-middle bg-transparent border-b shadow-none max-w-xs truncate">${p.description}</td>
                                        <td class="px-6 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">${proofBtn}</td>
                                        <td class="px-6 py-3 text-sm align-middle bg-transparent border-b whitespace-nowrap shadow-none">${p.created_by}</td>
                                        <td class="px-6 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none">
                                            <button type="button" onclick="openBatchDetail(${idx})" class="inline-block px-3 py-1 mb-0 text-white font-bold text-center uppercase align-middle bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg text-xxs cursor-pointer shadow-soft-sm">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            rowsHtml = `
                                <tr>
                                    <td colspan="8" class="text-center text-slate-400 italic py-6 text-sm">
                                        No payout batch logs found.
                                    </td>
                                </tr>
                            `;
                        }
                        $('#historyBody').html(rowsHtml);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to retrieve payment history logs.', 'error');
                }
            });
        }

        function downloadInvoicePdf() {
            if (!currentStaffCode) return;

            let url = "{{ route('admin.commission.export-pdf') }}";
            let params = {
                staff_code: currentStaffCode,
                period: globalPeriod,
                status: $('#gfilter_status').val(),
                batch_reference: $('#gfilter_batch').val()
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
@endpush