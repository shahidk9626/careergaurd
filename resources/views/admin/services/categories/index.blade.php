@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
                            <h6 class="mb-0">Service Categories</h6>
                        </div>
                        <div class="w-full max-w-full px-3 text-right lg:w-1/2 lg:flex-none">
                            <button onclick="openCreateModal()"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Category
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-6 px-0 pb-2">
                    <div class="overflow-x-auto">
                        <table id="categoriesTable"
                            class="table items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <!-- Playbook Step 1: Explicit Widths -->
                                    <th class="w-4/12 px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Name</th>
                                    <th class="w-4/12 px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Slug</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Status</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background-color: #ffffff; width: 100%; max-width: 450px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 90vh; margin: 1rem;">
            
            <form id="categoryForm" style="display: flex; flex-direction: column; height: 100%; margin: 0;">
                @csrf
                <input type="hidden" id="categoryId" name="id">
                
                <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h6 id="modalTitle" style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Add Service Category</h6>
                    <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
                </div>

                <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1;">
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Category Name</label>
                        <input type="text" name="name" id="name" required style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;" placeholder="e.g. Software Engineer">
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Status</label>
                        <select name="status" id="status" style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; background: white;">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" onclick="closeModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Save Category</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        $(document).ready(function () {
            table = $('#categoriesTable').DataTable({
                processing: true,
                serverSide: false, 
                autoWidth: false, // Playbook Step 2
                ajax: {
                    url: "{{ route('admin.services.categories.index') }}",
                    dataSrc: ''
                },
                columns: [
                    {
                        data: 'name',
                        className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                        render: function (data) {
                            // Playbook Step 3: whitespace-normal break-words
                            return '<h6 class="mb-0 text-sm leading-normal whitespace-normal break-words">' + data + '</h6>';
                        }
                    },
                    {
                        data: 'slug',
                        className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                        render: function (data) {
                            // Playbook Step 3: whitespace-normal break-words
                            return '<span class="text-xs font-semibold leading-tight text-slate-400 whitespace-normal break-words">' + data + '</span>';
                        }
                    },
                    {
                        data: 'status',
                        className: 'px-6 py-3 align-middle text-center text-sm bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data, type, row) {
                            const badgeColor = data === 'active' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300';
                            return '<span onclick="toggleStatus(' + row.id + ')" class="cursor-pointer text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ' + badgeColor + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'id',
                        className: 'px-6 py-3 align-middle text-center bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data) {
                            // UPDATED BUTTONS HERE
                            return `
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    <button onclick="editCategory(${data})" class="btn-action-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteCategory(${data})" class="btn-action-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });

            $('#categoryForm').on('submit', function (e) {
                e.preventDefault();
                const id = $('#categoryId').val();
                const url = id ? "{{ url('admin/services/categories/update') }}/" + id : "{{ route('admin.services.categories.store') }}";

                $.post(url, $(this).serialize(), function (response) {
                    Swal.fire('Success', response.success, 'success');
                    closeModal();
                    table.ajax.reload();
                });
            });
        });

        // Guaranteed display logic
        function openModalLogic() {
            let modal = document.getElementById('categoryModal');
            document.body.appendChild(modal); 
            modal.style.display = 'flex';     
        }

        function closeModal() {
            let modal = document.getElementById('categoryModal');
            modal.style.display = 'none';
        }

        function openCreateModal() {
            $('#categoryForm')[0].reset();
            $('#categoryId').val('');
            $('#modalTitle').text('Add Service Category');
            openModalLogic(); 
        }

        function editCategory(id) {
            $.get("{{ url('admin/services/categories/edit') }}/" + id, function (data) {
                $('#categoryId').val(data.id);
                $('#name').val(data.name);
                $('#status').val(data.status);
                $('#modalTitle').text('Edit Service Category');
                openModalLogic(); 
            });
        }

        function deleteCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#cb0c9f',
                cancelButtonColor: '#8392ab',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/services/categories/delete') }}/" + id,
                        type: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            Swal.fire('Deleted!', response.success, 'success');
                            table.ajax.reload();
                        }
                    });
                }
            });
        }

        function toggleStatus(id) {
            $.post("{{ url('admin/services/categories/status') }}/" + id, { _token: "{{ csrf_token() }}" }, function (response) {
                table.ajax.reload();
            });
        }
    </script>

    <style>
        /* Playbook Step 4: The Ultimate CSS Block for Alignment */
        
        /* Left Side Controls Padding */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info {
            padding-left: 1.5rem !important; /* 24px to match px-6 */
            color: #8392ab;
            font-size: 0.75rem;
            margin-bottom: 1rem;
        }

        /* Right Side Controls Padding */
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_paginate {
            padding-right: 1.5rem !important; /* 24px to match px-6 */
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

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(310deg, #7928ca 0%, #ff0080 100%);
            color: white !important;
            border: none;
            border-radius: 0.5rem;
        }

        /* Force table headers and data cells to have identical left padding */
        table.dataTable thead th,
        table.dataTable tbody td {
            padding-left: 1.5rem !important; /* Overrides the default DataTables squishing */
            border-bottom: 1px solid #f8f9fa;
            vertical-align: middle !important;
        }

        /* Exclude the Status and Action columns so they stay perfectly centered */
        table.dataTable thead th.text-center,
        table.dataTable tbody td.text-center {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
            text-align: center !important;
        }

        /* --- BULLETPROOF ACTION BUTTONS (Bypasses Tailwind JIT bugs) --- */
        .btn-action-edit {
            width: 38px; height: 38px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 0.75rem; color: white; border: none; cursor: pointer;
            background: linear-gradient(135deg, #38bdf8 0%, #3b82f6 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        
        .btn-action-delete {
            width: 38px; height: 38px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 0.75rem; color: white; border: none; cursor: pointer;
            background: linear-gradient(135deg, #fb7185 0%, #ef4444 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .btn-action-edit:hover, .btn-action-delete:hover {
            opacity: 0.85;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
    </style>
@endpush