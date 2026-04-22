@extends('layouts.app')

@section('content')
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
                            <h6 class="mb-0 font-bold">Edit Customer: {{ $customer->name }}</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            <a href="{{ route('admin.customers.index') }}"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102">
                                <i class="fas fa-arrow-left mr-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex-auto p-6">
                    <!-- Step Navigation -->
                    <div class="relative mb-12 mt-6">
                        <div class="flex justify-between items-start w-full px-2">
                            <div class="step-tab flex flex-col items-center z-10 cursor-pointer" data-step="1">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold shadow-soft-md">
                                    1</div>
                                <span class="text-xxs font-bold uppercase mt-2">Account</span>
                            </div>
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 mx-2" data-line="1"></div>
                            <div class="step-tab flex flex-col items-center z-10 cursor-pointer" data-step="2">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold">
                                    2</div>
                                <span class="text-xxs font-bold uppercase mt-2">Personal</span>
                            </div>
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 mx-2" data-line="2"></div>
                            <div class="step-tab flex flex-col items-center z-10 cursor-pointer" data-step="3">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold">
                                    3</div>
                                <span class="text-xxs font-bold uppercase mt-2">Contact</span>
                            </div>
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 mx-2" data-line="3"></div>
                            <div class="step-tab flex flex-col items-center z-10 cursor-pointer" data-step="4">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold">
                                    4</div>
                                <span class="text-xxs font-bold uppercase mt-2">Bank</span>
                            </div>
                            <div class="step-line flex-1 h-1 bg-gray-100 mt-5 mx-2" data-line="4"></div>
                            <div class="step-tab flex flex-col items-center z-10 cursor-pointer" data-step="5">
                                <div
                                    class="step-num w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-slate-500 font-bold">
                                    5</div>
                                <span class="text-xxs font-bold uppercase mt-2">Docs</span>
                            </div>
                        </div>
                    </div>

                    <form id="editCustomerForm" action="{{ route('admin.customers.update', $customer->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Step 1: Account -->
                        <div class="step-content block" id="step-1">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Account Security & Referrer</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Full Name</label>
                                        <input type="text" name="name" value="{{ $customer->name }}" required
                                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Referral Code (Staff
                                            Code)</label>
                                        <input type="text" name="referral_code"
                                            value="{{ $customer->referredBy->staffDetail->emp_code ?? '' }}"
                                            class="uppercase focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                                        <select name="status"
                                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700">
                                            <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="pending" {{ $customer->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
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

                        <!-- Step 2: Personal (Details Table) -->
                        <div class="step-content hidden" id="step-2">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Personal Data</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Father Name</label>
                                        <input type="text" name="father_name"
                                            value="{{ $customer->customerDetail->father_name ?? '' }}"
                                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Annual Income</label>
                                        <input type="text" name="annual_income"
                                            value="{{ $customer->customerDetail->annual_income ?? '' }}"
                                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" />
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

                        <!-- Step 3: Contact -->
                        <div class="step-content hidden" id="step-3">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Contact Information</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Address</label>
                                        <textarea name="address" rows="2"
                                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700">{{ $customer->customerDetail->address ?? '' }}</textarea>
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

                        <!-- Step 4: Bank -->
                        <div class="step-content hidden" id="step-4">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Financial Identity</h6>
                                <div class="flex flex-wrap -mx-3">
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">PAN</label>
                                        <input type="text" name="pan_number"
                                            value="{{ $customer->customerDetail->pan_number ?? '' }}"
                                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" />
                                    </div>
                                    <div class="w-full max-w-full px-3 mb-4 md:w-1/2">
                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Aadhar</label>
                                        <input type="text" name="aadhar_number"
                                            value="{{ $customer->customerDetail->aadhar_number ?? '' }}"
                                            class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-solid border-gray-300 bg-white px-3 py-2 font-normal text-gray-700" />
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

                        <!-- Step 5: Docs -->
                        <div class="step-content hidden" id="step-5">
                            <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <h6 class="mb-4 text-sm font-bold uppercase text-slate-700">Documents Hub</h6>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    @foreach($customer->customerDocuments as $doc)
                                        <div class="relative group border rounded-xl p-2 bg-white shadow-soft-sm">
                                            <div
                                                class="aspect-square bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                                <i class="fas fa-file-alt text-2xl text-slate-300"></i>
                                            </div>
                                            <p class="text-xxs font-bold mt-2 truncate">{{ $doc->document_name }}</p>
                                            <a href="{{ asset('storage/' . $doc->document_path) }}" target="_blank"
                                                class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-all rounded-xl text-white text-xs">View</a>
                                        </div>
                                    @endforeach
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
                                        <div class="w-full max-w-full px-3 md:w-2/12 text-center text-red-500"><i
                                                class="fas fa-plus cursor-pointer" id="addDocRow"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-10">
                                <button type="button"
                                    class="prev-step px-8 py-3 font-bold text-slate-700 uppercase bg-gray-100 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Prev</button>
                                <button type="submit" id="submitBtn"
                                    class="px-8 py-3 font-bold text-white uppercase bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg shadow-soft-md hover:scale-102 transition-all text-xs">Update
                                    Profile</button>
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
            function updateStepUI() {
                $(`.step-tab`).each(function () {
                    let s = $(this).data('step');
                    let circle = $(this).find('.step-num');
                    circle.removeClass('step-icon-active bg-gray-200');
                    if (s <= currentStep) circle.addClass('step-icon-active'); else circle.addClass('bg-gray-200');
                });
                $(`.step-line`).each(function () {
                    $(this).removeClass('step-line-active');
                    if ($(this).data('line') < currentStep) $(this).addClass('step-line-active');
                });
                $(`.step-content`).addClass('hidden');
                $(`#step-${currentStep}`).removeClass('hidden');
            }
            $('.next-step').click(function () { currentStep++; updateStepUI(); window.scrollTo(0, 0); });
            $('.prev-step').click(function () { currentStep--; updateStepUI(); window.scrollTo(0, 0); });
            $('.step-tab').click(function () { currentStep = $(this).data('step'); updateStepUI(); });
            $('#addDocRow').click(function () {
                $('#documentRows').append(`<div class="flex flex-wrap -mx-3 mb-4 doc-row items-end">
                        <div class="w-full max-w-full px-3 md:w-5/12"><input type="text" name="document_names[]" class="text-sm block w-full rounded-lg border border-gray-300 px-3 py-2 font-normal text-gray-700" /></div>
                        <div class="w-full max-w-full px-3 md:w-5/12"><input type="file" name="documents[]" class="text-sm block w-full rounded-lg border border-gray-300 px-3 py-1 font-normal text-gray-700" /></div>
                    </div>`);
            });
            $('#editCustomerForm').submit(function (e) {
                e.preventDefault();
                let fd = new FormData(this);
                $('#submitBtn').prop('disabled', true).text('Updating...');
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (res) { Swal.fire('Updated', res.success, 'success').then(() => window.location.href = "{{ route('admin.customers.index') }}"); },
                    error: function (xhr) { $('#submitBtn').prop('disabled', false).text('Update Profile'); Swal.fire('Error', 'Update failed', 'error'); }
                });
            });
            updateStepUI();
        });
    </script>
@endpush