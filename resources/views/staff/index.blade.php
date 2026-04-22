@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Staff List</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            @if(hasPermission('staff.create'))
                                <a href="{{ route('staff.create') }}"
                                    class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Staff
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="staffTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Emp Code</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Phone</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Department</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Joining Date</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Actions</th>
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
        const canEdit = {{ hasPermission('staff.edit') ? 'true' : 'false' }};
        const canDelete = {{ hasPermission('staff.delete') ? 'true' : 'false' }};
        const canStatus = {{ hasPermission('staff.status') ? 'true' : 'false' }};

        $(document).ready(function () {
            table = $('#staffTable').DataTable({
                ajax: {
                    url: "{{ route('staff.index') }}",
                    type: 'GET'
                },
                columns: [{
                    data: 'emp_code',
                    className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'full_name',
                    className: 'text-sm font-semibold leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'role.name',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'phone',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'department',
                    render: function (data) {
                        return data || '<span class="text-slate-400 italic">N/A</span>';
                    },
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'status',
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        let badgeClass = data ?
                            'bg-gradient-to-tl from-green-600 to-lime-400' :
                            'bg-gradient-to-tl from-slate-600 to-slate-300';
                        let statusText = data ? 'Active' : 'Inactive';
                        return `
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${statusText}</span>
                                        `;
                    }
                },
                {
                    data: 'joining_date',
                    className: 'text-center text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: null,
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        let actions = `<div class="flex items-center justify-center gap-2">`;

                        if (canStatus) {
                            let statusIcon = data.status ? 'fa-toggle-on text-green-500' : 'fa-toggle-off text-slate-400';
                            let statusTitle = data.status ? 'Deactivate' : 'Activate';
                            actions += `
                                    <button onclick="confirmToggleStatus(${data.id}, ${data.status})" class="inline-block px-3 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 hover:shadow-soft-xs active:opacity-85" title="${statusTitle}">
                                        <i class="fas ${statusIcon} mr-1"></i> Status
                                    </button>`;
                        }

                        if (canEdit) {
                            let editUrl = "{{ route('staff.edit', ':slug') }}".replace(':slug', data.slug);
                            actions += `
                                    <a href="${editUrl}" class="inline-block ml-2 px-3 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85" title="Edit">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>`;
                        }

                        if (canDelete) {
                            actions += `
                                    <button onclick="confirmDelete(${data.id})" class="inline-block ml-2 px-3 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85" title="Delete">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>`;
                        }

                        actions += `</div>`;
                        return actions;
                    }
                }
                ],
                order: [
                    [0, 'desc']
                ],
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        });

        function confirmToggleStatus(id, currentStatus) {
            let action = currentStatus ? 'deactivate' : 'activate';
            Swal.fire({
                title: 'Are you sure?',
                text: `You want to ${action} this staff member!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`,
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-gradient-to-tl from-red-600 to-rose-400 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/staff/status') }}/" + id,
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            table.ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: response.success
                            });
                        }
                    });
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-red-600 to-rose-400 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/staff/delete') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            table.ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: response.success
                            });
                        }
                    });
                }
            });
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    </script>

    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #8392ab;
            font-size: 0.75rem;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.25rem 0.75rem;
            outline: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
            color: white !important;
            border: none;
            border-radius: 0.5rem;
        }

        table.dataTable thead th {
            border-bottom: 1px solid #f8f9fa;
        }

        table.dataTable tbody td {
            border-bottom: 1px solid #f8f9fa;
            vertical-align: middle !important;
        }
    </style>
@endpush