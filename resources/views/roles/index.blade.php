@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
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
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Role Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Slug</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Status</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="roleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        
        <div style="background-color: #ffffff; width: 100%; max-width: 800px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 90vh; margin: 1rem;">
            
            <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h6 id="roleModal-title" style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Add Role</h6>
                <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
            </div>

            <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1;">
                <form id="roleForm">
                    @csrf
                    <input type="hidden" id="roleId" name="id">
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Role Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="roleName" name="name" required style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;" placeholder="Enter role name">
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Description</label>
                        <textarea id="roleDescription" name="description" rows="2" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Enter description"></textarea>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Status</label>
                        <select id="roleStatus" name="status" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: white;">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Permissions</label>
                        <div style="border: 1px solid #e2e8f0; border-radius: 0.5rem; overflow: hidden;">
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; min-width: 600px; border-collapse: collapse; font-size: 0.875rem; color: #475569;">
                                    <thead style="background-color: #f8fafc; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">
                                        <tr>
                                            <th style="padding: 0.75rem; text-align: left; border-bottom: 1px solid #e2e8f0;">Module</th>
                                            <th style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #e2e8f0;">View</th>
                                            <th style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #e2e8f0;">Create</th>
                                            <th style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #e2e8f0;">Edit</th>
                                            <th style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #e2e8f0;">Delete</th>
                                            <th style="padding: 0.75rem; text-align: center; border-bottom: 1px solid #e2e8f0;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                                <td style="padding: 0.75rem; font-weight: 600;">{{ $module->name }}</td>
                                                @foreach (['view', 'create', 'edit', 'delete', 'status'] as $action)
                                                    @php
                                                        $permission = $module->permissions->where('slug', $module->slug . '.' . $action)->first();
                                                    @endphp
                                                    <td style="padding: 0.75rem; text-align: center;">
                                                        @if ($permission)
                                                            <input type="checkbox" name="permissions[{{ $permission->id }}]" value="1"
                                                                class="permission-checkbox"
                                                                style="width: 16px; height: 16px; cursor: pointer; accent-color: #cb0c9f;"
                                                                data-permission-id="{{ $permission->id }}">
                                                        @else
                                                            <span style="color: #cbd5e1;">-</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeModal()" style="padding: 0.5rem 1rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                <button type="button" onclick="$('#roleForm').submit()" style="padding: 0.5rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #1e293b 0%, #0f172a 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Save Role</button>
            </div>
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

        // Guaranteed display logic
        function openModalLogic() {
            let modal = document.getElementById('roleModal');
            document.body.appendChild(modal); // Escapes parent layout traps
            modal.style.display = 'flex';     // Triggers centering
        }

        function closeModal() {
            let modal = document.getElementById('roleModal');
            modal.style.display = 'none';
        }

        function openAddModal() {
            $('#roleModal-title').text('Add Role');
            $('#roleId').val('');
            $('#roleForm')[0].reset();
            $('.permission-checkbox').prop('checked', false);
            openModalLogic();
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

            openModalLogic();
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