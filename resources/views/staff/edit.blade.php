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
                            <h6 class="mb-0 font-bold">Edit Staff: {{ $staff->full_name }}</h6>
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

                    <form id="staffForm" action="{{ route('staff.update', $staff->slug) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Step 1: Role -->
                        <div class="step-content block" id="step-1">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Set User Role</h6>
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full max-w-full px-3 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Select Role <span
                                                class="text-red-500">*</span></label>
                                        <select name="role_id" required
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                            <option value="">Choose a role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $staff->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Permission Overrides -->
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">User Specific Permissions (Overrides)</h6>
                                <div class="overflow-x-auto border border-gray-200 rounded-lg bg-white">
                                    <table class="w-full text-xs text-left text-slate-500">
                                        <thead class="bg-slate-50 text-slate-700 uppercase font-bold">
                                            <tr>
                                                <th class="px-3 py-2 border-b">Module</th>
                                                <th class="px-3 py-2 border-b text-center">View</th>
                                                <th class="px-3 py-2 border-b text-center">Create</th>
                                                <th class="px-3 py-2 border-b text-center">Edit</th>
                                                <th class="px-3 py-2 border-b text-center">Delete</th>
                                                <th class="px-3 py-2 border-b text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($modules as $module)
                                                <tr class="border-b hover:bg-slate-50">
                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $module->name }}</td>
                                                    @foreach (['view', 'create', 'edit', 'delete', 'status'] as $action)
                                                        @php
                                                            $permission = $module->permissions->where('slug', $module->slug . '.' . $action)->first();
                                                            $currentOverride = $permission ? ($userPermissions[$permission->id] ?? null) : null;
                                                        @endphp
                                                        <td class="px-3 py-2 text-center">
                                                            @if ($permission)
                                                                <select name="user_permissions[{{ $permission->id }}]" 
                                                                    class="text-xxs border border-gray-200 rounded p-1 focus:outline-none focus:border-fuchsia-300">
                                                                    <option value="" {{ $currentOverride === null ? 'selected' : '' }}>Inherit</option>
                                                                    <option value="1" {{ $currentOverride === 1 ? 'selected' : '' }} class="text-green-600">Allow</option>
                                                                    <option value="0" {{ $currentOverride === 0 ? 'selected' : '' }} class="text-red-600">Deny</option>
                                                                </select>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="flex justify-end mt-10">
                                <button type="button"
                                    class="next-step mt-2 px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Next
                                    <i class="fas fa-arrow-right ml-1"></i></button>
                            </div>
                        </div>

                        <!-- Step 2: Personal -->
                        <div class="step-content hidden" id="step-2">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Personal Information</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">First Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="first_name" required value="{{ $staff->first_name }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Last Name</label>
                                        <input type="text" name="last_name" value="{{ $staff->last_name }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Father Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="father_name" required value="{{ $staff->father_name }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Mother Name</label>
                                        <input type="text" name="mother_name" value="{{ $staff->mother_name }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Date of Birth</label>
                                        <input type="date" name="dob" value="{{ $staff->dob }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Gender</label>
                                        <select name="gender"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ $staff->gender == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ $staff->gender == 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="Other" {{ $staff->gender == 'Other' ? 'selected' : '' }}>Other
                                            </option>
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

                        <!-- Step 3: Contact -->
                        <div class="step-content hidden" id="step-3">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Contact Information</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Email Address</label>
                                        <input type="email" name="email" value="{{ $staff->email }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Phone Number <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="phone" required value="{{ $staff->phone }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Address <span
                                                class="text-red-500">*</span></label>
                                        <textarea name="address" required rows="2"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">{{ $staff->address }}</textarea>
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">City <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="city" required value="{{ $staff->city }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">State <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="state" required value="{{ $staff->state }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pincode <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="pincode" required value="{{ $staff->pincode }}"
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

                        <!-- Step 4: Employment -->
                        <div class="step-content hidden" id="step-4">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Employment & Bank</h6>
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Joining Date <span
                                                class="text-red-500">*</span></label>
                                        <input type="date" name="joining_date" required value="{{ $staff->joining_date }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Salary</label>
                                        <input type="number" step="0.01" name="salary" value="{{ $staff->salary }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Bank Name</label>
                                        <input type="text" name="bank_name" value="{{ $staff->bank_name }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Account Number</label>
                                        <input type="text" name="account_number" value="{{ $staff->account_number }}"
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

                        <!-- Step 5: Docs -->
                        <div class="step-content hidden" id="step-5">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Documents</h6>
                                <!-- Existing Docs -->
                                @if($staff->documents->count() > 0)
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        @foreach($staff->documents as $doc)
                                            <div class="w-full max-w-full px-3 mb-2 md:w-1/2 flex items-center justify-between bg-white p-2 rounded border border-gray-100 shadow-sm"
                                                id="doc-{{ $doc->id }}">
                                                <div class="flex items-center overflow-hidden">
                                                    <i class="fas fa-file-alt text-fuchsia-500 mr-2 flex-shrink-0"></i>
                                                    <span class="text-xs font-bold truncate">{{ $doc->document_name }}</span>
                                                </div>
                                                @if(hasPermission('staff.delete'))
                                                <button type="button" onclick="deleteDocument({{ $doc->id }})"
                                                    class="text-red-500 text-xs ml-2">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <!-- New Docs -->
                                <button type="button" id="addDocRow"
                                    class="text-xs font-bold uppercase text-fuchsia-600 mb-4"><i
                                        class="fas fa-plus mr-1"></i> Add Document</button>
                                <div id="documentRows"></div>
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

                        <!-- Step 6: Preview -->
                        <div class="step-content hidden" id="step-6">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-6 text-sm font-bold uppercase text-slate-700">Review Information</h6>
                                <div id="previewContainer"
                                    class="bg-white rounded-xl p-6 shadow-soft-sm border border-gray-100"></div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs"><i
                                        class="fas fa-arrow-left mr-1"></i> Back</button>
                                <button type="submit" id="submitBtn"
                                    class="prev-step mt-2 px-8 py-3 font-bold text-slate-700 text-white uppercase bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Save</button>
                                    
                                    
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

                    // Reset
                    numCircle.removeClass('step-icon-active bg-gray-200 text-slate-500');
                    $(this).removeClass('opacity-50 opacity-100 cursor-pointer cursor-default');
                    labelText.removeClass('text-slate-700 text-slate-400');

                    if (step < currentStep) {
                        $(this).addClass('opacity-100 cursor-pointer');
                        numCircle.addClass('step-icon-active');
                        numCircle.html('<span style="font-family: inherit;">✓</span>');
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

                if (currentStep === 6) { generatePreview(); }
            }

            updateStepUI();

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

            function validateCurrentStep() {
                let isValid = true;
                $(`#step-${currentStep} [required]`).each(function () {
                    if (!$(this).val()) { $(this).addClass('border-red-500'); isValid = false; }
                    else { $(this).removeClass('border-red-500'); }
                });
                return isValid;
            }

            function generatePreview() {
                let roleName = $('select[name="role_id"] option:selected').text();
                $('#previewContainer').html(`<div class="text-sm">Summary for ${$('input[name="first_name"]').val()} (${roleName})</div>`);
            }

            // Docs handling
            $('#addDocRow').on('click', function () {
                $('#documentRows').append(`
                        <div class="flex gap-2 mb-2 doc-row">
                            <input type="text" name="document_names[]" class="text-xs border p-1 rounded w-1/2" placeholder="Doc Name">
                            <input type="file" name="documents[]" class="text-xs w-1/2">
                            <button type="button" class="remove-row text-red-500">×</button>
                        </div>
                    `);
            });
            $(document).on('click', '.remove-row', function () { $(this).parent().remove(); });

            $('#staffForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire('Success', response.success, 'success').then(() => { window.location.href = "{{ route('staff.index') }}"; });
                    }
                });
            });
        });

        function deleteDocument(id) {
            $.ajax({
                url: "{{ url('/staff/delete-document') }}/" + id,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) { $('#doc-' + id).remove(); }
            });
        }
    </script>
@endpush