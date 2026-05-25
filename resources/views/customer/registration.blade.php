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
                        <div class="flex items-center flex-none w-full max-w-full px-3">
                            <h6 class="mb-0 font-bold">Complete Your Profile</h6>
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
                                <span class="text-xxs font-bold uppercase mt-2 transition-all">Personal</span>
                            </div>

                            <!-- Line 1-2 -->
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 transition-all duration-500 mx-2"
                                data-line="1"></div>

                            <!-- Step 2 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-default opacity-50" data-step="2">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all">
                                    2</div>
                                <span class="text-xxs font-bold uppercase mt-2">Contact</span>
                            </div>

                            <!-- Line 2-3 -->
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 transition-all duration-500 mx-2"
                                data-line="2"></div>

                            <!-- Step 3 -->
                            <div class="step-tab flex flex-col items-center z-10 cursor-default opacity-50" data-step="3">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold transition-all">
                                    3</div>
                                <span class="text-xxs font-bold uppercase mt-2">Identity</span>
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
                                <span class="text-xxs font-bold uppercase mt-2">Preview</span>
                            </div>
                        </div>
                    </div>

                    <form id="customerForm" action="{{ route('customer.store-profile') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div class="step-content block" id="step-1">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Personal Information</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Full Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ auth()->user()->name }}" required
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Father Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="father_name" required placeholder="Enter father's name"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Mother Name</label>
                                        <input type="text" name="mother_name" placeholder="Enter mother's name"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Date of Birth <span
                                                class="text-red-500">*</span></label>
                                        <input type="date" name="dob" required
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Gender <span
                                                class="text-red-500">*</span></label>
                                        <select name="gender" required
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Marital Status <span
                                                class="text-red-500">*</span></label>
                                        <select name="marital_status" required
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none">
                                            <option value="">Select Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-10">
                                <button type="button"
                                    class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Step 2: Contact Information -->
                        <div class="step-content hidden" id="step-2">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Contact Information</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">WhatsApp Number <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="whatsapp_number"
                                            value="{{ auth()->user()->whatsapp_number }}" required
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Alternate Number</label>
                                        <input type="text" name="alternate_number" placeholder="Enter alternate number"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Full Address <span
                                                class="text-red-500">*</span></label>
                                        <textarea name="address" required rows="2" placeholder="Enter full address"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"></textarea>
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">City <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="city" required placeholder="City"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">State <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="state" required placeholder="State"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Country <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="country" required placeholder="Country"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pincode <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="pincode" required placeholder="Pincode"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Step 3: Identity Details -->
                        <div class="step-content hidden" id="step-3">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Identity Details</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">PAN Number <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="pan_number" required placeholder="Enter PAN number"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Aadhar Number <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="aadhar_number" required placeholder="Enter Aadhar number"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Occupation <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="occupation" required placeholder="e.g. Salaried, Business"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Annual Income <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="annual_income" required placeholder="e.g. 5,00,000"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Step 4: Bank Details -->
                        <div class="step-content hidden" id="step-4">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Bank Details</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Bank Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="bank_name" required placeholder="Bank Name"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Account Number <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="account_number" required placeholder="Account Number"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">IFSC Code <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="ifsc_code" required placeholder="IFSC Code"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Branch Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="branch" required placeholder="Branch Name"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Step 5: Documents -->
                        <div class="step-content hidden" id="step-5">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <h6 class="text-sm font-bold uppercase text-slate-700">Required Documents</h6>
                                    <button type="button" id="addDocRow"
                                        class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 active:opacity-85">
                                        <i class="fas fa-plus mr-1"></i> Add More
                                    </button>
                                </div>
                                <div id="documentRows">
                                    <!-- Predefined Required Documents -->
                                    <div class="flex flex-wrap -mx-3 mb-4 doc-row items-end">
                                        <div class="w-full max-w-full px-3 md:w-5/12">
                                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Document Name</label>
                                            <select name="document_names[]"
                                                class="validate-doc-name focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none">
                                                <option value="PAN Card">PAN Card</option>
                                                <option value="Aadhar Card">Aadhar Card</option>
                                                <option value="Photo">Photo</option>
                                                <option value="Address Proof">Address Proof</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="w-full max-w-full px-3 mt-2 md:w-5/12 md:mt-0">
                                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">File <span
                                                    class="text-red-500">*</span></label>
                                            <input type="file" name="documents[]" required
                                                class="validate-file focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none" />
                                        </div>
                                        <div class="w-full max-w-full px-3 mt-2 md:w-2/12 md:mt-0 text-center">
                                            <button type="button"
                                                class="remove-row text-red-500 hover:text-red-700 transition-all font-bold py-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Preview
                                    <i class="fas fa-eye ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Step 6: Preview -->
                        <div class="step-content hidden" id="step-6">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-6 text-sm font-bold uppercase text-slate-700">Review Information</h6>
                                <div id="previewContainer"
                                    class="bg-white rounded-xl p-6 shadow-soft-sm border border-gray-100">
                                    <!-- Dynamic content -->
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Back</button>
                                <button type="submit" id="submitBtn"
                                    class="px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">
                                    <i class="fas fa-check mr-1"></i> Submit Registration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let currentStep = 1;
            const totalSteps = 6;

            function updateStepUI() {
                $('.step-tab').each(function () {
                    let step = $(this).data('step');
                    let numCircle = $(this).find('.step-num');
                    let labelText = $(this).find('span:last-child');

                    numCircle.removeClass('step-icon-active bg-gray-200 text-slate-500');
                    $(this).removeClass('opacity-50 opacity-100 cursor-pointer cursor-default');
                    labelText.removeClass('text-slate-700 text-slate-400');

                    if (step < currentStep) {
                        $(this).addClass('opacity-100 cursor-pointer');
                        numCircle.addClass('step-icon-active');
                        numCircle.html('✓');
                        labelText.addClass('text-slate-700');
                    } else if (step == currentStep) {
                        $(this).addClass('opacity-100 cursor-pointer');
                        numCircle.addClass('step-icon-active');
                        numCircle.html(step);
                        labelText.addClass('text-slate-700');
                    } else {
                        $(this).addClass('opacity-50 cursor-default');
                        numCircle.addClass('bg-gray-200 text-slate-500');
                        numCircle.html(step);
                        labelText.addClass('text-slate-400');
                    }
                });

                $('.step-line').each(function () {
                    let lineNum = $(this).data('line');
                    $(this).removeClass('bg-gray-100 step-line-active');
                    if (lineNum < currentStep) {
                        $(this).addClass('step-line-active');
                    } else {
                        $(this).addClass('bg-gray-100');
                    }
                });

                $('.step-content').addClass('hidden');
                $(`#step-${currentStep}`).removeClass('hidden');

                if (currentStep === 6) {
                    generatePreview();
                }
            }

            updateStepUI();

            // Initialize Validator
            let validator = $("#customerForm").validate({
                rules: {
                    name: { required: true, lettersnspaces: true, minlength: 3 },
                    father_name: { required: true, lettersnspaces: true, minlength: 3 },
                    mother_name: { lettersnspaces: true, minlength: 3 },
                    dob: { required: true, pastdate: true },
                    gender: { required: true },
                    marital_status: { required: true },
                    whatsapp_number: { required: true, indianmobile: true },
                    alternate_number: { indianmobile: true },
                    address: { required: true },
                    city: { required: true, lettersnspaces: true },
                    state: { required: true, lettersnspaces: true },
                    country: { required: true, lettersnspaces: true },
                    pincode: { required: true, pincode_custom: true },
                    pan_number: { required: true, pan: true },
                    aadhar_number: { required: true, aadhar: true },
                    occupation: { required: true },
                    annual_income: { required: true, number: true, min: 0 },
                    bank_name: { required: true },
                    account_number: { required: true },
                    ifsc_code: { required: true },
                    branch: { required: true }
                },
                messages: {
                    name: { required: "Full Name is required" },
                    father_name: { required: "Father's Name is required" },
                    dob: { required: "Date of Birth is required" },
                    gender: { required: "Gender is required" },
                    marital_status: { required: "Marital Status is required" },
                    whatsapp_number: { required: "WhatsApp number is required" },
                    address: { required: "Address is required" },
                    city: { required: "City is required" },
                    state: { required: "State is required" },
                    country: { required: "Country is required" },
                    pincode: { required: "Pincode is required" },
                    pan_number: { required: "PAN Number is required" },
                    aadhar_number: { required: "Aadhaar Number is required" },
                    occupation: { required: "Occupation is required" },
                    annual_income: { required: "Annual Income is required" },
                    bank_name: { required: "Bank Name is required" },
                    account_number: { required: "Account Number is required" },
                    ifsc_code: { required: "IFSC Code is required" },
                    branch: { required: "Branch is required" }
                }
            });

            function validateFileElement(element) {
                let file = element.files ? element.files[0] : null;
                let parent = $(element).closest('.w-full') || $(element).parent() || $(element).closest('.doc-row');
                parent.find('.error-message').remove();
                $(element).removeClass('border-red-500');

                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        $(element).addClass('border-red-500');
                        parent.append('<p class="text-red-500 text-xs mt-1 error-message">File size must not exceed 2 MB.</p>');
                        return false;
                    }
                    let ext = file.name.split('.').pop().toLowerCase();
                    if (!['jpg', 'jpeg', 'png', 'pdf'].includes(ext)) {
                        $(element).addClass('border-red-500');
                        parent.append('<p class="text-red-500 text-xs mt-1 error-message">Invalid file type. Only jpg, jpeg, png, pdf are allowed.</p>');
                        return false;
                    }
                } else if ($(element).prop('required')) {
                    $(element).addClass('border-red-500');
                    parent.append('<p class="text-red-500 text-xs mt-1 error-message">This field is required.</p>');
                    return false;
                }
                return true;
            }

            function validateDocNameElement(element) {
                let val = $(element).val().trim();
                let parent = $(element).closest('.w-full') || $(element).parent() || $(element).closest('.doc-row');
                parent.find('.error-message').remove();
                $(element).removeClass('border-red-500');

                if (!val && $(element).prop('required')) {
                    $(element).addClass('border-red-500');
                    parent.append('<p class="text-red-500 text-xs mt-1 error-message">This field is required.</p>');
                    return false;
                }
                return true;
            }

            $(document).on('change', '.validate-file', function() {
                validateFileElement(this);
            });

            $(document).on('blur keyup change', '.validate-doc-name', function() {
                validateDocNameElement(this);
            });

            function validateCurrentStep() {
                let isValid = true;
                let firstInvalid = null;

                // Validate standard jQuery Validate fields in current step
                $(`#step-${currentStep}`).find('input, select, textarea').not('.validate-file, .validate-doc-name').each(function () {
                    if (!validator.element(this)) {
                        isValid = false;
                        if (!firstInvalid) firstInvalid = $(this);
                    }
                });

                // Validate file and doc-name fields in current step
                $(`#step-${currentStep}`).find('.validate-file').each(function() {
                    if (!validateFileElement(this)) {
                        isValid = false;
                        if (!firstInvalid) firstInvalid = $(this);
                    }
                });
                $(`#step-${currentStep}`).find('.validate-doc-name').each(function() {
                    if (!validateDocNameElement(this)) {
                        isValid = false;
                        if (!firstInvalid) firstInvalid = $(this);
                    }
                });

                if (!isValid && firstInvalid) {
                    firstInvalid.focus();
                }
                return isValid;
            }

            $('.next-step').on('click', function () {
                if (validateCurrentStep()) {
                    currentStep++;
                    updateStepUI();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            $('.prev-step').on('click', function () {
                currentStep--;
                updateStepUI();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            $('.step-tab').on('click', function () {
                let targetStep = $(this).data('step');
                if (targetStep < currentStep) {
                    currentStep = targetStep;
                    updateStepUI();
                }
            });

            function generatePreview() {
                let previewHtml = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h5 class="text-xs font-bold uppercase text-purple-700 mb-4">Personal & Contact</h5>
                                <div class="space-y-3">
                                    <p class="text-sm"><span class="text-slate-400">Name:</span> <span class="font-bold text-slate-700">${$('input[name="name"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400">WhatsApp:</span> <span class="font-bold text-slate-700">${$('input[name="whatsapp_number"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400">Address:</span> <span class="font-bold text-slate-700">${$('textarea[name="address"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400">Location:</span> <span class="font-bold text-slate-700">${$('input[name="city"]').val()}, ${$('input[name="state"]').val()}</span></p>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold uppercase text-purple-700 mb-4">Identity & Bank</h5>
                                <div class="space-y-3">
                                    <p class="text-sm"><span class="text-slate-400">PAN:</span> <span class="font-bold text-slate-700">${$('input[name="pan_number"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400">Aadhar:</span> <span class="font-bold text-slate-700">${$('input[name="aadhar_number"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400">Bank:</span> <span class="font-bold text-slate-700">${$('input[name="bank_name"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400">Account:</span> <span class="font-bold text-slate-700">${$('input[name="account_number"]').val()}</span></p>
                                </div>
                            </div>
                        </div>
                    `;
                $('#previewContainer').html(previewHtml);
            }

            $('#addDocRow').on('click', function () {
                let row = `
                        <div class="flex flex-wrap -mx-3 mb-4 doc-row items-end">
                            <div class="w-full max-w-full px-3 md:w-5/12">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Document Name</label>
                                <input type="text" name="document_names[]" placeholder="Document Name"
                                    class="validate-doc-name focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                            </div>
                            <div class="w-full max-w-full px-3 mt-2 md:w-5/12 md:mt-0">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">File</label>
                                <input type="file" name="documents[]"
                                    class="validate-file focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                            </div>
                            <div class="w-full max-w-full px-3 mt-2 md:w-2/12 md:mt-0 text-center">
                                <button type="button" class="remove-row text-red-500 hover:text-red-700 transition-all font-bold py-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                $('#documentRows').append(row);
            });

            $(document).on('click', '.remove-row', function () {
                if ($('.doc-row').length > 1) {
                    $(this).closest('.doc-row').remove();
                } else {
                    $(this).closest('.doc-row').find('input, select').val('');
                    $(this).closest('.doc-row').find('.error-message').remove();
                    $(this).closest('.doc-row').find('input, select').removeClass('border-red-500');
                }
            });

            $('#customerForm').on('submit', function (e) {
                e.preventDefault();
                let isValid = true;
                let firstInvalid = null;

                if (!$(this).valid()) {
                    isValid = false;
                }

                $('.validate-file').each(function() {
                    if (!validateFileElement(this)) {
                        isValid = false;
                        if (!firstInvalid) firstInvalid = $(this);
                    }
                });
                $('.validate-doc-name').each(function() {
                    if (!validateDocNameElement(this)) {
                        isValid = false;
                        if (!firstInvalid) firstInvalid = $(this);
                    }
                });

                if (!isValid) {
                    if (firstInvalid) firstInvalid.focus();
                    return false;
                }

                let formData = new FormData(this);
                let submitBtn = $('#submitBtn');

                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving Profile...');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful',
                            text: 'Your profile has been submitted and is now active.',
                            confirmButtonClass: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg'
                        }).then(() => {
                            window.location.href = "{{ route('customer.dashboard') }}";
                        });
                    },
                    error: function (xhr) {
                        submitBtn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> Submit Registration');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.error || 'Something went wrong',
                            confirmButtonClass: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg'
                        });
                    }
                });
            });
        });
    </script>
@endpush