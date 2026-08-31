@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                
                <!-- Card Header -->
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0 font-bold text-slate-700">System Activity Logs & Audit Trail</h6>
                        </div>
                    </div>
                </div>

                <!-- Custom Elegant Filters Panel -->
                <div class="px-6 py-4 bg-gray-50/70 border border-gray-100/80 mx-6 my-4 rounded-xl">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                        
                        <!-- Module Filter -->
                        <div>
                            <label class="block text-xxs font-bold uppercase text-slate-500 mb-1">Module</label>
                            <select id="filter_module" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                                <option value="">All Modules</option>
                                @foreach($modules as $mod)
                                    <option value="{{ $mod->module_slug }}">{{ $mod->module_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Filter -->
                        <div>
                            <label class="block text-xxs font-bold uppercase text-slate-500 mb-1">Action</label>
                            <select id="filter_action" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                                <option value="">All Actions</option>
                                @foreach($actions as $act)
                                    <option value="{{ $act->action }}">{{ $act->action }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Role Filter -->
                        <div>
                            <label class="block text-xxs font-bold uppercase text-slate-500 mb-1">Performer Role</label>
                            <select id="filter_role" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->performed_by_role }}">{{ $role->performed_by_role }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="block text-xxs font-bold uppercase text-slate-500 mb-1">From Date</label>
                            <input type="date" id="filter_start_date" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-xxs font-bold uppercase text-slate-500 mb-1">To Date</label>
                            <input type="date" id="filter_end_date" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                        </div>

                    </div>
                    
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" id="btnResetFilters" class="inline-block px-4 py-2 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-gray-200 border-0 rounded-lg cursor-pointer text-xxs leading-normal hover:scale-102 hover:bg-gray-300 active:opacity-85 shadow-none">
                            <i class="fas fa-undo-alt mr-1"></i> Reset
                        </button>
                        <button type="button" id="btnApplyFilters" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer text-xxs leading-normal bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85 shadow-soft-md">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="activityLogTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">ID</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Module</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Action</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Performed By</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Role</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Reference No</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Timestamp (IST)</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        const canViewDetail = {{ hasPermission('activity-logs.detail') ? 'true' : 'false' }};

        $(document).ready(function () {
            table = $('#activityLogTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.activity-logs.index') }}",
                    type: 'GET',
                    data: function (d) {
                        d.module = $('#filter_module').val();
                        d.action_filter = $('#filter_action').val();
                        d.role = $('#filter_role').val();
                        
                        const start = $('#filter_start_date').val();
                        const end = $('#filter_end_date').val();
                        if (start && end) {
                            d.date_range = start + ' - ' + end;
                        }
                    }
                },
                columns: [
                    {
                        data: 'id',
                        className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-700'
                    },
                    {
                        data: 'module_name',
                        className: 'text-sm leading-normal px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none font-semibold text-slate-650'
                    },
                    {
                        data: 'action',
                        className: 'text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data) {
                            let badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                            
                            switch(data) {
                                case 'CREATE':
                                case 'REGISTER':
                                case 'CLAIM_CREATED':
                                case 'SERVICE_CREATED':
                                case 'PAYMENT_SUCCESS':
                                case 'COMMISSION_PAID':
                                    badgeClass = 'bg-gradient-to-tl from-green-600 to-lime-400';
                                    break;
                                case 'UPDATE':
                                case 'PROFILE_UPDATE':
                                case 'STATUS_CHANGE':
                                    badgeClass = 'bg-gradient-to-tl from-blue-600 to-cyan-400';
                                    break;
                                case 'DELETE':
                                case 'PAYMENT_FAILED':
                                case 'FAILED_LOGIN':
                                    badgeClass = 'bg-gradient-to-tl from-red-600 to-rose-400';
                                    break;
                                case 'LOGIN':
                                    badgeClass = 'bg-gradient-to-tl from-purple-700 to-pink-500';
                                    break;
                                case 'LOGOUT':
                                    badgeClass = 'bg-gradient-to-tl from-slate-650 to-slate-400';
                                    break;
                            }
                            
                            return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: 'performed_by_name',
                        className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-700'
                    },
                    {
                        data: 'performed_by_role',
                        className: 'text-sm leading-normal px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600'
                    },
                    {
                        data: 'reference_no',
                        className: 'text-sm leading-normal px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-600 font-mono'
                    },
                    {
                        data: 'created_at',
                        className: 'text-sm leading-normal px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-slate-500'
                    },
                    {
                        data: null,
                        className: 'text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none',
                        orderable: false,
                        render: function (data, type, row) {
                            if (canViewDetail) {
                                let showUrl = "{{ url('admin/activity-logs') }}/" + row.id;
                                return `
                                    <a href="${showUrl}" 
                                       class="inline-block px-3 py-1.5 mb-0 text-white font-bold text-center uppercase align-middle bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg text-xxs cursor-pointer shadow-soft-sm hover:scale-102 transition-all">
                                        <i class="fas fa-eye mr-1"></i> Details
                                    </a>`;
                            }
                            return `<span class="text-xs italic text-slate-400">None</span>`;
                        }
                    }
                ],
                order: [[0, 'desc']],
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });

            // Apply Filters button
            $('#btnApplyFilters').on('click', function () {
                table.draw();
            });

            // Reset Filters button
            $('#btnResetFilters').on('click', function () {
                $('#filter_module').val('');
                $('#filter_action').val('');
                $('#filter_role').val('');
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                table.draw();
            });
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #8392ab;
            font-size: 0.75rem;
            margin-bottom: 1rem;
            padding: 0 1.5rem;
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
