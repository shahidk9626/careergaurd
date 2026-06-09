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
                        <div class="flex flex-col">
                            <label class="text-xxs font-bold text-slate-400 uppercase mb-1">Period</label>
                            <div class="flex flex-wrap gap-1 bg-slate-100 p-1 rounded-lg">
                                <button type="button" onclick="setGlobalPeriod('current_month')" id="btn_gperiod_current_month" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Current Month</button>
                                <button type="button" onclick="setGlobalPeriod('last_month')" id="btn_gperiod_last_month" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Last Month</button>
                                <button type="button" onclick="setGlobalPeriod('current_year')" id="btn_gperiod_current_year" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Current Year</button>
                                <button type="button" onclick="setGlobalPeriod('overall')" id="btn_gperiod_overall" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Overall</button>
                                <button type="button" onclick="setGlobalPeriod('custom')" id="btn_gperiod_custom" class="gperiod-btn px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:text-slate-800 transition-all border-0 bg-transparent cursor-pointer">Custom Range</button>
                            </div>
                        </div>

                        <!-- Status Filter Dropdown -->
                        <div class="flex flex-col">
                            <label class="text-xxs font-bold text-slate-400 uppercase mb-1">Status</label>
                            <select id="gfilter_status" onchange="applyGlobalFilters()" class="px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 bg-white">
                                <option value="">All Statuses</option>
                                <option value="Pending">Pending</option>
                                <option value="Paid">Paid</option>
                                <option value="Hold">Hold</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>

                        <!-- Batch Reference Search -->
                        <div class="flex flex-col">
                            <label class="text-xxs font-bold text-slate-400 uppercase mb-1">Batch Ref</label>
                            <input type="text" id="gfilter_batch" onkeyup="applyGlobalFilters()" placeholder="e.g. COM-..." class="px-2 py-1.5 text-xs border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 bg-white" style="width: 140px;">
                        </div>
                        
                        <!-- Custom Date Inputs -->
                        <div id="globalCustomDateInputs" class="flex items-center gap-2" style="display: none; margin-bottom: 2px;">
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
            $('.gperiod-btn').removeClass('bg-white text-purple-700 shadow-soft-sm').addClass('text-slate-600 bg-transparent');
            $('#btn_gperiod_' + period).addClass('bg-white text-purple-700 shadow-soft-sm').removeClass('text-slate-600 bg-transparent');
            
            if (period === 'custom') {
                $('#globalCustomDateInputs').slideDown();
            } else {
                $('#globalCustomDateInputs').slideUp();
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
                            $('#staffPhotoContainer').html(`<i class="fas fa-user-tie text-2xl text-slate-400"></i>`);
                        }
                        
                        // KPI Card values
                        $('#overallCommissionDisplay').text(formatCurrency(response.period.total_commission)); // earned
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
                                let badgeColor = 'bg-gradient-to-tl from-slate-600 to-slate-300'; // Pending
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
                        
                        // Switch default active tab back to policy breakdown panel
                        $('#policies-tab').trigger('click');
                        
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

        // Selections Calculation
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

        // Manage Modal Logic
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

        // Bulk Pay Modal Logic
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

        // Proof Viewer Modal Logic
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

        // Batch Details Modal Logic
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

        // Payout Batch History logs
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
