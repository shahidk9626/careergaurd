@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Roles Management</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            @if(hasPermission('roles.create'))
                                <a href="javascript:;" onclick="openAddModal()"
                                    class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Role
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="roleTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Role Name</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Slug</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Status</th>
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

    <!-- Role Modal -->
    <div id="roleModal"
        class="fixed inset-0 z-990 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
        <div id="roleModal-content"
            class="relative w-full max-w-lg p-6 mx-4 bg-white shadow-soft-2xl rounded-2xl transform transition-transform duration-300 scale-95 opacity-0">
            <h6 id="roleModal-title" class="mb-4 font-bold text-slate-700">Add Role</h6>
            <form id="roleForm">
                @csrf
                <input type="hidden" id="roleId" name="id">
                <div class="mb-4">
                    <label class="block mb-2 text-xs font-bold uppercase text-slate-700">Role Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="roleName" name="name" required
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-fuchsia-300"
                        placeholder="Enter role name">
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-xs font-bold uppercase text-slate-700">Description</label>
                    <textarea id="roleDescription" name="description" rows="3"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-fuchsia-300"
                        placeholder="Enter description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-xs font-bold uppercase text-slate-700">Status</label>
                    <select id="roleStatus" name="status"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-fuchsia-300">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Permission Matrix -->
                <div class="mb-4">
                    <label class="block mb-2 text-xs font-bold uppercase text-slate-700">Permissions</label>
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
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
                                            @endphp
                                            <td class="px-3 py-2 text-center">
                                                @if ($permission)
                                                    <input type="checkbox" name="permissions[{{ $permission->id }}]" value="1"
                                                        class="rounded text-fuchsia-600 focus:ring-fuchsia-500 permission-checkbox"
                                                        data-permission-id="{{ $permission->id }}">
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
                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" onclick="window.closeGlobalModal('roleModal')"
                        class="px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102">Cancel</button>
                    <button type="submit"
                        class="px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-gradient-to-tl from-gray-900 to-slate-800 border-0 rounded-lg cursor-pointer active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 shadow-soft-md">Save
                        Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        const canEdit = {{ hasPermission('roles.edit') ? 'true' : 'false' }};
        const canDelete = {{ hasPermission('roles.delete') ? 'true' : 'false' }};
        const canStatus = {{ hasPermission('roles.status') ? 'true' : 'false' }};

        $(document).ready(function () {
            table = $('#roleTable').DataTable({
                ajax: {
                    url: "{{ route('roles.index') }}",
                    type: 'GET'
                },
                columns: [{
                    data: 'name',
                    className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'slug',
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
                            actions += `
                                            <button onclick="openEditModal(${data.id}, '${data.name}', ${data.status}, '${data.description || ''}')" class="inline-block ml-2 px-3 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85" title="Edit">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>`;
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
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true,
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search roles..."
                }
            });
        });

        function openAddModal() {
            $('#roleModal-title').text('Add Role');
            $('#roleId').val('');
            $('#roleForm')[0].reset();
            $('.permission-checkbox').prop('checked', false);
            window.openGlobalModal('roleModal');
        }

        function openEditModal(id, name, status, description) {
            $('#roleModal-title').text('Edit Role');
            $('#roleId').val(id);
            $('#roleName').val(name);
            $('#roleStatus').val(status);
            $('#roleDescription').val(description);

            $('.permission-checkbox').prop('checked', false);

            // Load Permissions
            $.get(`{{ url('roles/permissions') }}/${id}`, function (permissions) {
                permissions.forEach(function (rp) {
                    if (rp.allowed) {
                        $(`.permission-checkbox[data-permission-id="${rp.permission_id}"]`).prop('checked', true);
                    }
                });
            });

            window.openGlobalModal('roleModal');
        }

        function closeModal() {
            window.closeGlobalModal('roleModal');
        }

        $('#roleForm').on('submit', function (e) {
            e.preventDefault();
            let roleId = $('#roleId').val();
            let url = roleId ? `{{ url('roles/update') }}/${roleId}` : `{{ route('roles.store') }}`;

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    closeModal();
                    Toast.fire({
                        icon: 'success',
                        title: response.success
                    });
                    table.ajax.reload();
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    for (let key in errors) {
                        errorMsg += errors[key][0] + '\n';
                    }
                    Swal.fire('Error', errorMsg, 'error');
                }
            });
        });

        function confirmToggleStatus(id, currentStatus) {
            let action = currentStatus ? 'Deactivate' : 'Activate';
            Swal.fire({
                title: 'Are you sure?',
                text: `You want to ${action.toLowerCase()} this role?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#8392ab',
                confirmButtonText: `Yes, ${action} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('roles/status') }}/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.success
                            });
                            table.ajax.reload();
                        }
                    });
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This role will be soft deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#8392ab',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('roles/delete') }}/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.success
                            });
                            table.ajax.reload();
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

        .overflow-hidden {
            overflow: hidden !important;
        }
    </style>
@endpush