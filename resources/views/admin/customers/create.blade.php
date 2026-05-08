@extends('layouts.app')

@section('content')
    <!-- Custom Style for Step Icons and Lines -->
    <style>
        .step-icon-active {
            background-image: linear-gradient(310deg, #7928ca 0%, #ff0080 100%) !important;
            color: #fff !important;
            box-shadow: 0 4px 7px -1px rgba(0, 0, 0, 0.11), 0 2px 4px -1px rgba(0, 0, 0, 0.07) !important;
        }

        .step-line-active {
            background-image: linear-gradient(310deg, #7928ca 0%, #ff0080 100%) !important;
        }
    </style>

    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0 font-bold">Add New Customer (Manual)</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            <a href="{{ route('admin.customers.index') }}"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                                <i class="fas fa-arrow-left mr-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex-auto p-6">
                    <!-- Step Navigation -->
                    <div class="relative mb-12 mt-6">
                        <div class="flex justify-between items-start w-full px-2">
                            <!-- Step 1 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-pointer" data-step="1">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all shadow-soft-md">
                                    1</div>
                                <span class="text-xxs font-bold uppercase mt-2 transition-all">Identity</span>
                            </div>

                            <!-- Line 1-2 -->
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 transition-all duration-500 mx-2"
                                data-line="1"></div>

                            <!-- Step 2 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-default opacity-50" data-step="2">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all">
                                    2</div>
                                <span class="text-xxs font-bold uppercase mt-2">Personal</span>
                            </div>

                            <!-- Line 2-3 -->
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 transition-all duration-500 mx-2"
                                data-line="2"></div>

                            <!-- Step 3 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-default opacity-50" data-step="3">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all">
                                    3</div>
                                <span class="text-xxs font-bold uppercase mt-2">Contact</span>
                            </div>

                            <!-- Line 3-4 -->
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 transition-all duration-500 mx-2"
                                data-line="3"></div>

                            <!-- Step 4 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-default opacity-50" data-step="4">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all">
                                    4</div>
                                <span class="text-xxs font-bold uppercase mt-2">Bank</span>
                            </div>

                            <!-- Line 4-5 -->
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 transition-all duration-500 mx-2"
                                data-line="4"></div>

                            <!-- Step 5 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-default opacity-50" data-step="5">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all">
                                    5</div>
                                <span class="text-xxs font-bold uppercase mt-2">Docs</span>
                            </div>

                            <!-- Line 5-6 -->
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 transition-all duration-500 mx-2"
                                data-line="5"></div>

                            <!-- Step 6 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-default opacity-50" data-step="6">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all">
                                    6</div>
                                <span class="text-xxs font-bold uppercase mt-2">Finalize</span>
                            </div>
                        </div>
                    </div>

                   <form id="adminCustomerForm" action="{{ route('admin.customers.store') }}" method="POST"
      enctype="multipart/form-data">
    @csrf

    <div class="step-content block" id="step-1">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">User Identity & Referral</h6>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Enter customer name" minlength="3"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required placeholder="Enter email address"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">WhatsApp Number <span class="text-red-500">*</span></label>
                    <input type="text" name="whatsapp_number" required placeholder="Enter WhatsApp number" maxlength="10"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Referral Code (Staff Code)</label>
                    <input type="text" name="referral_code" placeholder="ENTER STAFF CODE"
                        class="uppercase focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-10">
            <button type="button"
                class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                <i class="fas fa-arrow-right ml-1"></i></button>
        </div>
    </div>

    <div class="step-content hidden" id="step-2">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Personal Information</h6>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Father Name</label>
                    <input type="text" name="father_name" placeholder="Enter father's name" minlength="3"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Date of Birth</label>
                    <input type="date" name="dob"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Gender</label>
                    <select name="gender"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Marital Status</label>
                    <select name="marital_status"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none">
                        <option value="">Select Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button"
                class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Prev</button>
            <button type="button"
                class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next</button>
        </div>
    </div>

    <div class="step-content hidden" id="step-3">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Contact Details</h6>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mb-4">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Full Address</label>
                    <textarea name="address" rows="2" placeholder="Enter full address"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none"></textarea>
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">City</label>
                    <input type="text" name="city" placeholder="City"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">State</label>
                    <input type="text" name="state" placeholder="State"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pincode</label>
                    <input type="text" name="pincode" placeholder="Pincode" maxlength="6"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button"
                class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Prev</button>
            <button type="button"
                class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next</button>
        </div>
    </div>

    <div class="step-content hidden" id="step-4">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Bank & Identity IDs</h6>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Bank Name</label>
                    <input type="text" name="bank_name" placeholder="Bank Name"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Account Number</label>
                    <input type="text" name="account_number" placeholder="Account Number" maxlength="18"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">PAN Number</label>
                    <input type="text" name="pan_number" placeholder="PAN Number" maxlength="10"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Aadhar Number</label>
                    <input type="text" name="aadhar_number" placeholder="Aadhar Number" maxlength="12"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button"
                class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Prev</button>
            <button type="button"
                class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next</button>
        </div>
    </div>

    <div class="step-content hidden" id="step-5">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h6 class="text-sm font-bold uppercase text-slate-700">Upload Documents</h6>
                <button type="button" id="addDocRow"
                    class="px-4 py-2 font-bold text-white uppercase bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
            <div id="documentRows">
                <div class="flex flex-wrap -mx-3 mb-4 doc-row items-end">
                    <div class="w-full max-w-full px-3 md:w-5/12">
                        <input type="text" name="document_names[]" placeholder="Document Name"
                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" />
                    </div>
                    <div class="w-full max-w-full px-3 md:w-5/12">
                        <input type="file" name="documents[]"
                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-1 font-normal text-gray-700" />
                    </div>
                    <div class="w-full max-w-full px-3 md:w-2/12 text-center">
                        <button type="button" class="remove-row text-red-500 py-2"><i
                                class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button"
                class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Prev</button>
            <button type="button"
                class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Preview</button>
        </div>
    </div>

    <div class="step-content hidden" id="step-6">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Admin Options</h6>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full max-w-full px-3 flex items-center">
                    <div class="min-h-6 pl-1.25 block">
                        <input type="checkbox" name="force_complete" value="1" id="forceComplete"
                            class="w-4 h-4" />
                        <label for="forceComplete"
                            class="ml-2 font-bold text-xs text-slate-700 cursor-pointer">Mark Profile as
                            COMPLETED (Bypass User Verification/Onboarding)</label>
                    </div>
                </div>
            </div>
            <div id="previewContainer" class="bg-white rounded-xl p-6 shadow-soft-sm border border-gray-100">
                </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button"
                class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Back</button>
            <button type="submit" id="submitBtn"
                class="px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Save
                Customer</button>
        </div>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // --- 1. REAL-TIME INPUT RESTRICTIONS ---
    
    // Only Alphabets and Spaces
    $('input[name="name"], input[name="father_name"], input[name="city"], input[name="state"], input[name="bank_name"]').on('input', function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });

    // Only Numbers
    $('input[name="whatsapp_number"], input[name="pincode"], input[name="account_number"], input[name="aadhar_number"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // PAN Format (Uppercase Alphanumeric)
    $('input[name="pan_number"]').on('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    // --- 2. ERROR DISPLAY HELPERS ---
    
    function showError(fieldName, message) {
        let $input = $('input[name="' + fieldName + '"]');
        removeError(fieldName);
        $input.after('<p class="text-red-500 text-xs mt-1 validation-error" data-field="' + fieldName + '">' + message + '</p>');
        $input.addClass('border-red-500').removeClass('border-gray-300');
    }

    function removeError(fieldName) {
        let $input = $('input[name="' + fieldName + '"]');
        $input.siblings('.validation-error[data-field="' + fieldName + '"]').remove();
        $input.removeClass('border-red-500').addClass('border-gray-300');
    }

    // --- 3. STEP VALIDATION FUNCTIONS ---
    
    function validateStep1() {
        let isValid = true;

        let name = $('input[name="name"]').val().trim();
        if (name.length < 3) { showError('name', 'Name must contain at least 3 letters.'); isValid = false; } 
        else { removeError('name'); }

        let email = $('input[name="email"]').val().trim();
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) { showError('email', 'Please enter a valid email address.'); isValid = false; } 
        else { removeError('email'); }

        let whatsapp = $('input[name="whatsapp_number"]').val().trim();
        if (whatsapp.length !== 10) { showError('whatsapp_number', 'WhatsApp number must be exactly 10 digits.'); isValid = false; } 
        else { removeError('whatsapp_number'); }

        return isValid;
    }

    function validateStep2() {
        let isValid = true;
        let fatherName = $('input[name="father_name"]').val().trim();
        
        // Optional field: only validate if user typed something
        if (fatherName !== '' && fatherName.length < 3) { 
            showError('father_name', 'Father Name must contain at least 3 letters.'); isValid = false; 
        } else { removeError('father_name'); }

        return isValid;
    }

    function validateStep3() {
        let isValid = true;
        let pincode = $('input[name="pincode"]').val().trim();
        
        // Optional field: only validate if user typed something
        if (pincode !== '' && pincode.length !== 6) { 
            showError('pincode', 'Pincode must be exactly 6 digits.'); isValid = false; 
        } else { removeError('pincode'); }

        return isValid;
    }

    function validateStep4() {
        let isValid = true;

        let account = $('input[name="account_number"]').val().trim();
        if (account !== '' && (account.length < 9 || account.length > 18)) { 
            showError('account_number', 'Account Number must be between 9 and 18 digits.'); isValid = false; 
        } else { removeError('account_number'); }

        let pan = $('input[name="pan_number"]').val().trim();
        let panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
        if (pan !== '' && !panRegex.test(pan)) { 
            showError('pan_number', 'Invalid PAN format (e.g., ABCDE1234F).'); isValid = false; 
        } else { removeError('pan_number'); }

        let aadhar = $('input[name="aadhar_number"]').val().trim();
        if (aadhar !== '' && aadhar.length !== 12) { 
            showError('aadhar_number', 'Aadhar Number must be exactly 12 digits.'); isValid = false; 
        } else { removeError('aadhar_number'); }

        return isValid;
    }

    // --- 4. BIND VALIDATIONS TO "NEXT" BUTTONS ---
    
    $('#step-1 .next-step').on('click', function(e) {
        if (!validateStep1()) { e.preventDefault(); e.stopImmediatePropagation(); }
    });

    $('#step-2 .next-step').on('click', function(e) {
        if (!validateStep2()) { e.preventDefault(); e.stopImmediatePropagation(); }
    });

    $('#step-3 .next-step').on('click', function(e) {
        if (!validateStep3()) { e.preventDefault(); e.stopImmediatePropagation(); }
    });

    $('#step-4 .next-step').on('click', function(e) {
        if (!validateStep4()) { e.preventDefault(); e.stopImmediatePropagation(); }
    });

    // Form Submission Catch-all
    $('#adminCustomerForm').on('submit', function(e) {
        if (!validateStep1() || !validateStep2() || !validateStep3() || !validateStep4()) {
            e.preventDefault();
            alert('Please check all steps and fix the errors before submitting.');
        }
    });

    // --- 5. CLEAR ERRORS ON BLUR ---
    $('input[name="name"], input[name="email"], input[name="whatsapp_number"]').on('blur', validateStep1);
    $('input[name="father_name"]').on('blur', validateStep2);
    $('input[name="pincode"]').on('blur', validateStep3);
    $('input[name="account_number"], input[name="pan_number"], input[name="aadhar_number"]').on('blur', validateStep4);
});
</script>
    <script>
        $(document).ready(function () {
            let currentStep = 1;

            function updateStepUI() {
                $('.step-tab').each(function () {
                    let step = $(this).data('step');
                    let numCircle = $(this).find('.step-num');
                    let labelText = $(this).find('span:last-child');

                    numCircle.removeClass('step-icon-active bg-gray-200 text-slate-500');
                    $(this).removeClass('opacity-50 opacity-100 cursor-pointer');

                    if (step < currentStep) {
                        $(this).addClass('opacity-100 cursor-pointer');
                        numCircle.addClass('step-icon-active').html('✓');
                    } else if (step == currentStep) {
                        $(this).addClass('opacity-100 cursor-pointer');
                        numCircle.addClass('step-icon-active').html(step);
                    } else {
                        $(this).addClass('opacity-50 cursor-default');
                        numCircle.addClass('bg-gray-200 text-slate-500').html(step);
                    }
                });

                $('.step-line').each(function () {
                    $(this).removeClass('step-line-active');
                    if ($(this).data('line') < currentStep) $(this).addClass('step-line-active');
                });

                $('.step-content').addClass('hidden');
                $(`#step-${currentStep}`).removeClass('hidden');

                if (currentStep === 6) {
                    $('#previewContainer').html(`
                            <p class="text-sm"><b>Name:</b> ${$('input[name="name"]').val()}</p>
                            <p class="text-sm"><b>Email:</b> ${$('input[name="email"]').val()}</p>
                            <p class="text-sm"><b>WhatsApp:</b> ${$('input[name="whatsapp_number"]').val()}</p>
                            <p class="text-sm"><b>Referral:</b> ${$('input[name="referral_code"]').val() || 'None'}</p>
                        `);
                }
            }

            $('.next-step').on('click', function () {
                let inputs = $(`#step-${currentStep} [required]`);
                let valid = true;
                inputs.each(function () { if (!$(this).val()) { valid = false; $(this).addClass('border-red-500'); } else { $(this).removeClass('border-red-500'); } });
                if (valid) { currentStep++; updateStepUI(); window.scrollTo(0, 0); }
            });

            $('.prev-step').on('click', function () { currentStep--; updateStepUI(); window.scrollTo(0, 0); });

            $('#addDocRow').on('click', function () {
                $('#documentRows').append(`
                        <div class="flex flex-wrap -mx-3 mb-4 doc-row items-end">
                            <div class="w-full max-w-full px-3 md:w-5/12"><input type="text" name="document_names[]" placeholder="Document Name" class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" /></div>
                            <div class="w-full max-w-full px-3 md:w-5/12"><input type="file" name="documents[]" class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-1 font-normal text-gray-700" /></div>
                            <div class="w-full max-w-full px-3 md:w-2/12 text-center"><button type="button" class="remove-row text-red-500 py-2"><i class="fas fa-trash"></i></button></div>
                        </div>
                    `);
            });

            $(document).on('click', '.remove-row', function () { if ($('.doc-row').length > 1) $(this).closest('.doc-row').remove(); });

            $('#adminCustomerForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                let btn = $('#submitBtn');
                btn.prop('disabled', true).html('Saving...');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        Swal.fire('Success', res.success, 'success').then(() => window.location.href = "{{ route('admin.customers.index') }}");
                    },
                    error: function (xhr) {
                        btn.prop('disabled', false).html('Save Customer');
                        
                        let errorMessage = 'Something went wrong';
                        
                        // Check if Laravel sent back validation errors (plural)
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Grab the very first validation error message to show the user
                            errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                        } 
                        // Fallback for custom exceptions (singular)
                        else if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }

                        Swal.fire('Validation Error', errorMessage, 'error');
                    }
                });
            });

            updateStepUI();
        });
    </script>
@endpush