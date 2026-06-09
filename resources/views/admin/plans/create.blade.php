@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Create New Membership</h6>
                    <p class="text-sm">Configure premium pricing, tenure, and service categories.</p>
                </div>
                <div class="flex-auto p-6">
                    <form id="planForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Row 1 -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Membership Name</label>
                                <input type="text" name="name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="e.g. Gold Membership" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Premium Amount (₹)</label>
                                <input type="number" name="premium_amount"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="0.00" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Commission Amount (₹)</label>
                                <input type="number" name="commission_amount" step="0.01" min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="0.00" required>
                            </div>

                            <!-- Row 2 -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Tenure Type</label>
                                <select name="tenure_type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required>
                                    <option value="days">Days</option>
                                    <option value="months">Months</option>
                                    <option value="years">Years</option>
                                    <option value="lifetime">Lifetime</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Tenure Value</label>
                                <input type="number" name="tenure_value"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="e.g. 12">
                            </div>

                            <!-- Row 3 -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Compensation Amount (₹)</label>
                                <input type="number" name="compensation_amount"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="0.00" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Claim Duration (Days)</label>
                                <input type="number" name="claim_duration_days"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="e.g. 90" required>
                            </div>

                            <!-- Row 4 -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                                <select name="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Short Description</label>
                                <input type="text" name="description"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="Quick highlight of the membership">
                            </div>

                            <!-- Row 5 (New Fields) -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Prematurity Available</label>
                                <select name="prematurity_available"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">One-Time Payment Applicable</label>
                                <select name="one_time_payment_applicable" id="one_time_payment_applicable"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <!-- Row 6 (Dynamic Amount Field) -->
                            <div id="one_time_payment_amount_container" style="display: none;" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">One-Time Payment Amount (₹)</label>
                                    <input type="number" step="0.01" min="0" name="one_time_payment_amount" id="one_time_payment_amount"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Discount Price (₹)</label>
                                    <input type="number" step="0.01" min="0" name="discount_price" id="discount_price"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- Service Bundling Section -->
                        <div class="mt-10">
                            <h6 class="mb-4 text-sm font-bold uppercase text-slate-500">Service Category Bundling</h6>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Resume Templates -->
                                <div class="p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center mr-2 shadow-soft-sm">
                                            <i class="fas fa-file-invoice text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm font-bold text-slate-700">Resume Templates</span>
                                    </div>
                                    <div class="space-y-2 category-list" data-type="resume">
                                        <!-- Load categories here -->
                                    </div>
                                </div>

                                <!-- Job Links -->
                                <div class="p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center mr-2 shadow-soft-sm">
                                            <i class="fas fa-link text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm font-bold text-slate-700">Job Links</span>
                                    </div>
                                    <div class="space-y-2 category-list" data-type="job-link">
                                        <!-- Load categories here -->
                                    </div>
                                </div>

                                <!-- Interview Questions -->
                                <div class="p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-gradient-to-tl from-red-600 to-orange-400 flex items-center justify-center mr-2 shadow-soft-sm">
                                            <i class="fas fa-question-circle text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm font-bold text-slate-700">Interview Q&A</span>
                                    </div>
                                    <div class="space-y-2 category-list" data-type="question">
                                        <!-- Load categories here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end gap-3">
                            <a href="{{ route('admin.plans.index') }}"
                                class="px-8 py-3 rounded-lg bg-gray-100 text-slate-700 font-bold uppercase text-xs hover:bg-gray-200 transition-all">Cancel</a>
                            <button type="submit"
                                class="px-8 py-3 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-bold uppercase text-xs hover:scale-102 transition-all shadow-soft-md">Create
                                Membership</button>
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
            // Toggle dynamic amount field visibility
            $('#one_time_payment_applicable').on('change', function () {
                if ($(this).val() == '1') {
                    $('#one_time_payment_amount_container').show();
                    $('#one_time_payment_amount').attr('required', true);
                    $('#discount_price').attr('required', true);
                } else {
                    $('#one_time_payment_amount_container').hide();
                    $('#one_time_payment_amount').removeAttr('required').val('');
                    $('#discount_price').removeAttr('required').val('');
                }
            });
            // Load categories into each service block
            $.get("{{ route('admin.services.categories.index') }}", function (data) {
                $('.category-list').each(function () {
                    const type = $(this).data('type');
                    let parentSlug = type;
                    if (type === 'question') {
                        parentSlug = 'interview';
                    }
                    let html = '';
                    data.forEach(cat => {
                        if (cat.parent && cat.parent.slug === parentSlug) {
                            html += `
                                <div class="flex items-center p-2 hover:bg-white rounded-lg transition-all group">
                                    <input type="checkbox" name="plan_services[${type}][]" value="${cat.id}" class="rounded text-purple-600 mr-2">
                                    <span class="text-xs text-slate-600 group-hover:text-slate-800 font-medium">${cat.name}</span>
                                </div>
                            `;
                        }
                    });
                    $(this).html(html || '<p class="text-xxs text-slate-400 italic">No categories defined</p>');
                });
            });

            $('#planForm').on('submit', function (e) {
                e.preventDefault();
                $.post("{{ route('admin.plans.store') }}", $(this).serialize(), function (response) {
                    Swal.fire({
                        title: 'Success',
                        text: response.success,
                        icon: 'success'
                    }).then(() => {
                        window.location.href = "{{ route('admin.plans.index') }}";
                    });
                }).fail(function (xhr) {
                    Swal.fire('Error', xhr.responseJSON.error || 'Something went wrong', 'error');
                });
            });
        });
    </script>
@endpush