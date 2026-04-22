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
                            <h6 class="mb-0 font-bold">Add New Staff</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            <a href="{{ route('staff.index') }}"
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
                                <span class="text-xxs font-bold uppercase mt-2 transition-all">Role</span>
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
                                <span class="text-xxs font-bold uppercase mt-2">Employment</span>
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

                    <form id="staffForm" action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Role -->
                        <div class="step-content block" id="step-1">
                            <div class="mb-8">
                                <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                    <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Set User Role</h6>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full max-w-full px-3 md:w-1/2">
                                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Select Role <span
                                                    class="text-red-500">*</span></label>
                                            <select name="role_id" required
                                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                                <option value="">Choose a role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @if(count($roles) == 0)
                                                <p class="text-red-500 text-xxs font-bold mt-1">No roles found in table!</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end mt-10">
                                <button type="button"
                                    class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Add Other Steps (Personal, Contact, etc.) with identical logic to previous turns -->
                        <!-- Personal Information -->
                        <div class="step-content hidden" id="step-2">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Personal Information</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">First Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="first_name" required placeholder="Enter first name"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Last Name</label>
                                        <input type="text" name="last_name" placeholder="Enter last name"
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
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Nominee Name</label>
                                        <input type="text" name="nominee_name" placeholder="Enter nominee's name"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Date of Birth</label>
                                        <input type="date" name="dob"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Gender</label>
                                        <select name="gender"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Marital Status</label>
                                        <select name="marital_status"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                            <option value="">Select Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                            <option value="Widowed">Widowed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="step-content hidden" id="step-3">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Contact Information</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email Address</label>
                                        <input type="email" name="email" placeholder="Enter email"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Phone Number <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="phone" required placeholder="Enter phone"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Alternate Phone</label>
                                        <input type="text" name="alternate_phone" placeholder="Enter alternate phone"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pincode <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="pincode" required placeholder="Pincode"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Address <span
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
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Employment & Bank Details -->
                        <div class="step-content hidden" id="step-4">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Employment Details</h6>
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Department</label>
                                        <input type="text" name="department" placeholder="Enter department"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Designation</label>
                                        <input type="text" name="designation" placeholder="Enter designation"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Joining Date <span
                                                class="text-red-500">*</span></label>
                                        <input type="date" name="joining_date" required
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Salary</label>
                                        <input type="number" step="0.01" name="salary" placeholder="Salary"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                </div>
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700 border-t pt-4">Bank & IDs</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Bank Name</label>
                                        <input type="text" name="bank_name" placeholder="Bank Name"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Account Number</label>
                                        <input type="text" name="account_number" placeholder="Account Number"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">IFSC Code</label>
                                        <input type="text" name="ifsc_code" placeholder="IFSC Code"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">PAN Number</label>
                                        <input type="text" name="pan_number" placeholder="PAN Number"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Aadhar Number</label>
                                        <input type="text" name="aadhar_number" placeholder="Aadhar Number"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="step-content hidden" id="step-5">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <h6 class="text-sm font-bold uppercase text-slate-700">Additional Documents</h6>
                                    <button type="button" id="addDocRow"
                                        class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 active:opacity-85">
                                        <i class="fas fa-plus mr-1"></i> Add More
                                    </button>
                                </div>
                                <div id="documentRows">
                                    <div class="flex flex-wrap -mx-3 mb-4 doc-row items-end">
                                        <div class="w-full max-w-full px-3 md:w-5/12">
                                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Document Name</label>
                                            <input type="text" name="document_names[]" placeholder="e.g. Aadhar Card"
                                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                        </div>
                                        <div class="w-full max-w-full px-3 mt-2 md:w-5/12 md:mt-0">
                                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">File</label>
                                            <input type="file" name="documents[]"
                                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
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
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Prev</button>
                                <button type="button"
                                    class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Preview
                                    <i class="fas fa-eye ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Preview -->
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
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Back</button>
                                <button type="submit" id="submitBtn"
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 text-white uppercase bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">
                                    <i class="fas fa-check mr-1"></i> Submit
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

                    // Reset to base state
                    numCircle.removeClass('step-icon-active bg-gray-200 text-slate-500');
                    $(this).removeClass('opacity-50 opacity-100 cursor-pointer cursor-default');
                    labelText.removeClass('text-slate-700 text-slate-400');

                    if (step < currentStep) {
                        // Completed
                        $(this).addClass('opacity-100 cursor-pointer');
                        numCircle.addClass('step-icon-active');
                        numCircle.html('<span style="font-family: inherit;">✓</span>');
                        labelText.addClass('text-slate-700');
                    } else if (step == currentStep) {
                        // Current
                        $(this).addClass('opacity-100 cursor-pointer');
                        numCircle.addClass('step-icon-active');
                        numCircle.html(step);
                        labelText.addClass('text-slate-700');
                    } else {
                        // Future
                        $(this).addClass('opacity-50 cursor-default');
                        numCircle.addClass('bg-gray-200 text-slate-500');
                        numCircle.html(step);
                        labelText.addClass('text-slate-400');
                    }
                });

                // Update Progress Lines
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

            // Initial UI update
            updateStepUI();

            function validateCurrentStep() {
                let isValid = true;
                let firstInvalid = null;

                $(`#step-${currentStep} [required]`).each(function () {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('border-red-500');
                        if (!firstInvalid) firstInvalid = $(this);
                    } else {
                        $(this).removeClass('border-red-500');
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
                let roleName = $('select[name="role_id"] option:selected').text();

                let previewHtml = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                                <h5 class="text-xs font-bold uppercase text-purple-700 mb-3">Role & Personal</h5>
                                <div class="space-y-2">
                                    <p class="text-sm"><span class="text-slate-400 font-normal">Role:</span> <span class="font-bold text-slate-700">${roleName}</span></p>
                                    <p class="text-sm"><span class="text-slate-400 font-normal">Name:</span> <span class="font-bold text-slate-700">${$('input[name="first_name"]').val()} ${$('input[name="last_name"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400 font-normal">Father's Name:</span> <span class="font-bold text-slate-700">${$('input[name="father_name"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400 font-normal">DOB:</span> <span class="font-bold text-slate-700">${$('input[name="dob"]').val() || 'Not provided'}</span></p>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold uppercase text-purple-700 mb-3">Contact Details</h5>
                                <div class="space-y-2">
                                    <p class="text-sm"><span class="text-slate-400 font-normal">Phone:</span> <span class="font-bold text-slate-700">${$('input[name="phone"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400 font-normal">Email:</span> <span class="font-bold text-slate-700">${$('input[name="email"]').val() || 'N/A'}</span></p>
                                    <p class="text-sm"><span class="text-slate-400 font-normal">Address:</span> <span class="font-bold text-slate-700">${$('textarea[name="address"]').val()}</span></p>
                                    <p class="text-sm"><span class="text-slate-400 font-normal">City:</span> <span class="font-bold text-slate-700">${$('input[name="city"]').val()}, ${$('input[name="state"]').val()}</span></p>
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
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                            </div>
                            <div class="w-full max-w-full px-3 mt-2 md:w-5/12 md:mt-0">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">File</label>
                                <input type="file" name="documents[]"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
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
                    $(this).closest('.doc-row').find('input').val('');
                }
            });

            $('#staffForm').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                let submitBtn = $('#submitBtn');

                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Staff Member Created',
                            text: response.success,
                            confirmButtonClass: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg'
                        }).then(() => {
                            window.location.href = "{{ route('staff.index') }}";
                        });
                    },
                    error: function (xhr) {
                        submitBtn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> Submit Form');
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        if (errors) {
                            Object.keys(errors).forEach(key => {
                                errorMsg += errors[key][0] + '\n';
                            });
                        } else {
                            errorMsg = xhr.responseJSON.error || 'Something went wrong';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errorMsg,
                            confirmButtonClass: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg'
                        });
                    }
                });
            });
        });
    </script>
@endpush