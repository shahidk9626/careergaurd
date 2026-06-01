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

    <div class="step-content block" id="step-1">
        <div class="mb-8">
            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100">
                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Set User Role</h6>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 md:w-1/2">
                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Select Role <span class="text-red-500">*</span></label>
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
            <button type="button" class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next <i class="fas fa-arrow-right ml-1"></i></button>
        </div>
    </div>

    <div class="step-content hidden" id="step-2">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Personal Information</h6>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">First Name <span class="text-red-500">*</span></label>
                    <input type="text" name="first_name" required placeholder="Enter first name" minlength="3"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Last Name</label>
                    <input type="text" name="last_name" placeholder="Enter last name"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Father Name <span class="text-red-500">*</span></label>
                    <input type="text" name="father_name" required placeholder="Enter father's name" minlength="3"
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
            <button type="button" class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i class="fas fa-arrow-left mr-1"></i> Prev</button>
            <button type="button" class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next <i class="fas fa-arrow-right ml-1"></i></button>
        </div>
    </div>

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
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" required placeholder="Enter phone" maxlength="10"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Alternate Phone</label>
                    <input type="text" name="alternate_phone" placeholder="Enter alternate phone" maxlength="10"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pincode <span class="text-red-500">*</span></label>
                    <input type="text" name="pincode" required placeholder="Pincode" maxlength="6"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Address <span class="text-red-500">*</span></label>
                    <textarea name="address" required rows="2" placeholder="Enter full address"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"></textarea>
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">City <span class="text-red-500">*</span></label>
                    <input type="text" name="city" required placeholder="City"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">State <span class="text-red-500">*</span></label>
                    <input type="text" name="state" required placeholder="State"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Country <span class="text-red-500">*</span></label>
                    <input type="text" name="country" required placeholder="Country"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button" class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i class="fas fa-arrow-left mr-1"></i> Prev</button>
            <button type="button" class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next <i class="fas fa-arrow-right ml-1"></i></button>
        </div>
    </div>

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
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Joining Date <span class="text-red-500">*</span></label>
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
                    <input type="text" name="account_number" placeholder="Account Number" maxlength="18"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">IFSC Code</label>
                    <input type="text" name="ifsc_code" placeholder="IFSC Code" maxlength="11"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">PAN Number</label>
                    <input type="text" name="pan_number" placeholder="PAN Number" maxlength="10"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
                <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Aadhar Number</label>
                    <input type="text" name="aadhar_number" placeholder="Aadhar Number" maxlength="12"
                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button" class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i class="fas fa-arrow-left mr-1"></i> Prev</button>
            <button type="button" class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next <i class="fas fa-arrow-right ml-1"></i></button>
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
                                                class="validate-doc-name focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                        </div>
                                        <div class="w-full max-w-full px-3 mt-2 md:w-5/12 md:mt-0">
                                            <label class="mb-2 ml-1 font-bold text-xs text-slate-700">File</label>
                                            <input type="file" name="documents[]"
                                                class="validate-file focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
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

    <div class="step-content hidden" id="step-6">
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h6 class="mb-6 text-sm font-bold uppercase text-slate-700">Review Information</h6>
            <div id="previewContainer" class="bg-white rounded-xl p-6 shadow-soft-sm border border-gray-100">
                </div>
        </div>
        <div class="flex justify-between mt-10">
            <button type="button" class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i class="fas fa-arrow-left mr-1"></i> Back</button>
            <button type="submit" id="submitBtn" class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 text-white uppercase bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // --- 1. REAL-TIME INPUT RESTRICTIONS ---
    
    // Only Alphabets and Spaces for Name/Location Fields
    $('input[name="first_name"], input[name="last_name"], input[name="father_name"], input[name="mother_name"], input[name="nominee_name"], input[name="city"], input[name="state"], input[name="country"], input[name="bank_name"]').on('input', function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });

    // Only Numbers for Phone, PIN, Bank Account, Aadhar
    $('input[name="phone"], input[name="alternate_phone"], input[name="pincode"], input[name="account_number"], input[name="aadhar_number"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Uppercase Alphanumeric for PAN and IFSC
    $('input[name="pan_number"], input[name="ifsc_code"]').on('input', function() {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });

    // --- 2. ERROR DISPLAY HELPERS ---
    
    function showError(fieldName, message) {
        let $input = $('[name="' + fieldName + '"]'); // Works for select and input
        removeError(fieldName);
        $input.after('<p class="text-red-500 text-xs mt-1 validation-error" data-field="' + fieldName + '">' + message + '</p>');
        $input.addClass('border-red-500').removeClass('border-gray-300');
    }

    function removeError(fieldName) {
        let $input = $('[name="' + fieldName + '"]');
        $input.siblings('.validation-error[data-field="' + fieldName + '"]').remove();
        $input.removeClass('border-red-500').addClass('border-gray-300');
    }

    // --- 3. STEP VALIDATION FUNCTIONS ---
    
    function validateStep1() {
        let isValid = true;
        let role = $('select[name="role_id"]').val();
        
        if (!role) { showError('role_id', 'Please select a role.'); isValid = false; } 
        else { removeError('role_id'); }

        return isValid;
    }

    function validateStep2() {
        let isValid = true;

        let fName = $('input[name="first_name"]').val().trim();
        if (fName.length < 3) { showError('first_name', 'First name must contain at least 3 letters.'); isValid = false; } 
        else { removeError('first_name'); }

        let fatherName = $('input[name="father_name"]').val().trim();
        if (fatherName.length < 3) { showError('father_name', 'Father name must contain at least 3 letters.'); isValid = false; } 
        else { removeError('father_name'); }

        return isValid;
    }

    function validateStep3() {
        let isValid = true;

        let email = $('input[name="email"]').val().trim();
        if(email !== '') {
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) { showError('email', 'Please enter a valid email address.'); isValid = false; } 
            else { removeError('email'); }
        } else { removeError('email'); } // Email isn't marked required in HTML

        let phone = $('input[name="phone"]').val().trim();
        if (phone.length !== 10) { showError('phone', 'Phone number must be exactly 10 digits.'); isValid = false; } 
        else { removeError('phone'); }

        let altPhone = $('input[name="alternate_phone"]').val().trim();
        if (altPhone !== '' && altPhone.length !== 10) { showError('alternate_phone', 'Alternate phone must be exactly 10 digits.'); isValid = false; } 
        else { removeError('alternate_phone'); }

        let pincode = $('input[name="pincode"]').val().trim();
        if (pincode.length !== 6) { showError('pincode', 'Pincode must be exactly 6 digits.'); isValid = false; } 
        else { removeError('pincode'); }
        
        let city = $('input[name="city"]').val().trim();
        if (city === '') { showError('city', 'City is required.'); isValid = false; } else { removeError('city'); }
        
        let state = $('input[name="state"]').val().trim();
        if (state === '') { showError('state', 'State is required.'); isValid = false; } else { removeError('state'); }
        
        let country = $('input[name="country"]').val().trim();
        if (country === '') { showError('country', 'Country is required.'); isValid = false; } else { removeError('country'); }

        return isValid;
    }

    function validateStep4() {
        let isValid = true;

        let joining = $('input[name="joining_date"]').val().trim();
        if (joining === '') { showError('joining_date', 'Joining Date is required.'); isValid = false; } 
        else { removeError('joining_date'); }

        let account = $('input[name="account_number"]').val().trim();
        if (account !== '' && (account.length < 9 || account.length > 18)) { 
            showError('account_number', 'Account Number must be between 9 and 18 digits.'); isValid = false; 
        } else { removeError('account_number'); }
        
        let ifsc = $('input[name="ifsc_code"]').val().trim();
        let ifscRegex = /^[A-Z]{4}0[A-Z0-9]{6}$/;
        if (ifsc !== '' && !ifscRegex.test(ifsc)) { 
            showError('ifsc_code', 'Invalid IFSC format (e.g., ABCD0123456).'); isValid = false; 
        } else { removeError('ifsc_code'); }

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
    $('#staffForm').on('submit', function(e) {
        if (!validateStep1() || !validateStep2() || !validateStep3() || !validateStep4()) {
            e.preventDefault();
            alert('Please check all steps and fix the errors before submitting.');
        }
    });

    // --- 5. CLEAR ERRORS ON BLUR ---
    $('select[name="role_id"]').on('change', validateStep1);
    $('input[name="first_name"], input[name="father_name"]').on('blur', validateStep2);
    $('input[name="email"], input[name="phone"], input[name="alternate_phone"], input[name="pincode"], input[name="city"], input[name="state"], input[name="country"]').on('blur', validateStep3);
    $('input[name="joining_date"], input[name="account_number"], input[name="ifsc_code"], input[name="pan_number"], input[name="aadhar_number"]').on('blur', validateStep4);
});
</script>
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

            // Initialize Validator
            let validator = $("#staffForm").validate({
                ignore: [],
                rules: {
                    role_id: { required: true },
                    first_name: { required: true, lettersnspaces: true, minlength: 3 },
                    last_name: { lettersnspaces: true, minlength: 3 },
                    father_name: { required: true, lettersnspaces: true, minlength: 3 },
                    mother_name: { lettersnspaces: true, minlength: 3 },
                    nominee_name: { lettersnspaces: true, minlength: 3 },
                    dob: { pastdate: true },
                    email: { email: true },
                    phone: { required: true, indianmobile: true },
                    alternate_phone: { indianmobile: true },
                    pincode: { required: true, pincode_custom: true },
                    address: { required: true },
                    city: { required: true, lettersnspaces: true },
                    state: { required: true, lettersnspaces: true },
                    country: { required: true, lettersnspaces: true },
                    joining_date: { required: true, pastdate: true },
                    salary: { number: true, min: 0 },
                    pan_number: { pan: true },
                    aadhar_number: { aadhar: true }
                },
                messages: {
                    first_name: { required: "First Name is required" },
                    father_name: { required: "Father Name is required" },
                    phone: { required: "Phone number is required" },
                    pincode: { required: "Pincode is required" },
                    address: { required: "Address is required" },
                    city: { required: "City is required" },
                    state: { required: "State is required" },
                    country: { required: "Country is required" },
                    joining_date: { required: "Joining date is required" }
                }
            });

            function validateFileElement(element) {
                let file = element.files ? element.files[0] : null;
                let parent = $(element).closest('.w-full') || $(element).parent();
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
                let parent = $(element).closest('.w-full') || $(element).parent();
                parent.find('.error-message').remove();
                $(element).removeClass('border-red-500');

                if (!val && $(element).prop('required')) {
                    $(element).addClass('border-red-500');
                    parent.append('<p class="text-red-500 text-xs mt-1 error-message">This field is required.</p>');
                    return false;
                }
                return true;
            }

            // File input validation triggers
            $(document).on('change', '.validate-file', function() {
                validateFileElement(this);
            });

            $(document).on('blur keyup', '.validate-doc-name', function() {
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
                    $(this).closest('.doc-row').find('input').val('');
                    $(this).closest('.doc-row').find('.error-message').remove();
                    $(this).closest('.doc-row').find('input').removeClass('border-red-500');
                }
            });

            $('#staffForm').on('submit', function (e) {
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