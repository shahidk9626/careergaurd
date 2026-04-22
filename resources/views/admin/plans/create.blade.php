@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Create New Plan</h6>
                    <p class="text-sm">Configure premium pricing, tenure, and service categories.</p>
                </div>
                <div class="flex-auto p-6">
                    <form id="planForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Row 1 -->
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Plan Name</label>
                                <input type="text" name="name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="e.g. Gold Plan" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Premium Amount (₹)</label>
                                <input type="number" name="premium_amount"
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
                                    placeholder="Quick highlight of the plan">
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
                                Plan</button>
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
            // Load categories into each service block
            $.get("{{ route('admin.services.categories.index') }}", function (data) {
                $('.category-list').each(function () {
                    const type = $(this).data('type');
                    let html = '';
                    data.forEach(cat => {
                        html += `
                            <div class="flex items-center p-2 hover:bg-white rounded-lg transition-all group">
                                <input type="checkbox" name="plan_services[${type}][]" value="${cat.id}" class="rounded text-purple-600 mr-2">
                                <span class="text-xs text-slate-600 group-hover:text-slate-800 font-medium">${cat.name}</span>
                            </div>
                        `;
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