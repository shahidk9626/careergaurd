@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Resume Templates</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            <button onclick="openCreateModal()"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Template
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="templateTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Template</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Categories</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Status</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">Created At</th>
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

    <div id="templateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        
        <div style="background-color: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 90vh; margin: 1rem;">
            
            <form id="templateForm" enctype="multipart/form-data" style="display: flex; flex-direction: column; height: 100%; margin: 0;">
                @csrf
                <input type="hidden" id="templateId" name="id">
                
                <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h6 id="modalTitle" style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Add Resume Template</h6>
                    <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
                </div>

                <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1; display: flex; flex-direction: column; gap: 1rem;">
                    
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" id="title" required style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;" placeholder="Enter template title">
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Categories</label>
                        <div id="categoryCheckboxes" style="display: flex; flex-wrap: wrap; gap: 0.5rem; padding: 0.75rem; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                            </div>
                    </div>

                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Description</label>
                        <textarea name="description" id="description" rows="3" style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Enter template description"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Thumbnail (Image)</label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="width: 100%; font-size: 0.75rem; color: #475569;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Template File (PDF/DOC)</label>
                            <input type="file" name="file_path" id="file_path" accept=".pdf,.doc,.docx" style="width: 100%; font-size: 0.75rem; color: #475569;">
                        </div>
                    </div>

                </div>

                <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" onclick="closeModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Save Template</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        $(document).ready(function () {
            table = $('#templateTable').DataTable({
                ajax: "{{ route('admin.services.resumes.index') }}",
                columns: [
                    {
                        data: null,
                        className: 'px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data) {
                            let thumb = data.thumbnail ? `/storage/${data.thumbnail}` : 'https://via.placeholder.com/50x70?text=No+Img';
                            return `
                                <div class="flex px-2 py-1">
                                    <div>
                                        <img src="${thumb}" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-12 w-9 rounded-md" alt="thumb">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 text-sm leading-normal font-semibold">${data.title}</h6>
                                        <p class="mb-0 text-xs leading-tight text-slate-400 font-bold uppercase truncate w-32">${data.description || 'No description'}</p>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    {
                        data: 'categories',
                        render: function (data) {
                            if (!data || data.length === 0) return '<span class="text-xs text-slate-400 italic">No Categories</span>';
                            return '<div class="flex flex-wrap gap-1">' + data.map(c => '<span class="px-2 py-1 text-xxs font-bold bg-gray-100 text-slate-600 rounded-lg shadow-none border">' + c.name + '</span>').join('') + '</div>';
                        }
                    },
                    {
                        data: 'status',
                        className: 'text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data) {
                            let badgeClass = data === 'active' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300';
                            return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: 'created_at',
                        className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data) {
                            return new Date(data).toLocaleDateString();
                        }
                    },
                    {
                        data: null,
                        className: 'text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data) {
                            return `
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    <button onclick="toggleStatus(${data.id})" class="mr-2 text-slate-400 hover:text-slate-700 transition-colors" title="Toggle Status">
                                        <i class="fas ${data.status === 'active' ? 'fa-toggle-on text-green-500' : 'fa-toggle-off'} fa-lg"></i>
                                    </button>
                                    <button onclick="editTemplate(${data.id})" class="btn-action-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteTemplate(${data.id})" class="btn-action-delete" title="Delete">
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

            $('#templateForm').on('submit', function (e) {
                e.preventDefault();
                let id = $('#templateId').val();
                let url = id ? "{{ url('admin/services/resumes/update') }}/" + id : "{{ route('admin.services.resumes.store') }}";
                let formData = new FormData(this);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        Toast.fire({ icon: 'success', title: res.success });
                        closeModal();
                        table.ajax.reload();
                    },
                    error: function (err) {
                        let msg = err.responseJSON?.error || 'Something went wrong';
                        Toast.fire({ icon: 'error', title: msg });
                    }
                });
            });
        });

        // Guaranteed display logic
        function openModalLogic() {
            let modal = document.getElementById('templateModal');
            document.body.appendChild(modal); // Escapes parent layout traps
            modal.style.display = 'flex';     // Triggers centering
        }

        function closeModal() {
            let modal = document.getElementById('templateModal');
            modal.style.display = 'none';
        }

        function loadCategories(selectedIds = []) {
            $.get("{{ route('admin.services.categories.index') }}", function (data) {
                let html = '';
                data.forEach(cat => {
                    let checked = selectedIds.includes(cat.id) ? 'checked' : '';
                    html += `
                        <label style="display: inline-flex; align-items: center; cursor: pointer; margin-right: 0.5rem;">
                            <input type="checkbox" name="categories[]" value="${cat.id}" ${checked} style="width: 16px; height: 16px; cursor: pointer; accent-color: #cb0c9f;">
                            <span style="margin-left: 0.5rem; font-size: 0.75rem; color: #475569;">${cat.name}</span>
                        </label>
                    `;
                });
                $('#categoryCheckboxes').html(html || '<span style="font-size: 0.75rem; color: #94a3b8; font-style: italic;">No categories found. Add some first.</span>');
            });
        }

        function openCreateModal() {
            $('#templateForm')[0].reset();
            $('#templateId').val('');
            $('#modalTitle').text('Add Resume Template');
            loadCategories();
            openModalLogic(); // Using the new function
        }

        function editTemplate(id) {
            $.get("{{ url('admin/services/resumes/edit') }}/" + id, function (data) {
                $('#templateId').val(data.id);
                $('#title').val(data.title);
                $('#description').val(data.description);
                $('#modalTitle').text('Edit Resume Template');
                let selectedIds = data.categories ? data.categories.map(c => c.id) : [];
                loadCategories(selectedIds);
                openModalLogic(); // Using the new function
            });
        }

        function toggleStatus(id) {
            $.post("{{ url('admin/services/resumes/status') }}/" + id, { _token: "{{ csrf_token() }}" }, function (res) {
                table.ajax.reload();
                Toast.fire({ icon: 'success', title: res.success });
            });
        }

        function deleteTemplate(id) {
            if (confirm('Are you sure you want to delete this template?')) {
                $.ajax({
                    url: "{{ url('admin/services/resumes/delete') }}/" + id,
                    type: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        table.ajax.reload();
                        Toast.fire({ icon: 'success', title: res.success });
                    }
                });
            }
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
        /* Left Side Controls Padding */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info {
            padding-left: 1.5rem !important;
            color: #8392ab;
            font-size: 0.75rem;
            margin-bottom: 1rem;
        }

        /* Right Side Controls Padding */
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_paginate {
            padding-right: 1.5rem !important;
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

        /* Force table headers and data cells to have identical padding */
        table.dataTable thead th,
        table.dataTable tbody td {
            padding-left: 1.5rem !important; 
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

        /* --- BULLETPROOF ACTION BUTTONS --- */
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