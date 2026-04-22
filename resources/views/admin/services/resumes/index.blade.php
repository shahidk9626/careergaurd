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
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Template</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Created At</th>
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

    <!-- Template Modal -->
    <div id="templateModal"
        class="fixed inset-0 z-990 hidden items-center justify-center overflow-auto bg-black/50 transition-all duration-300 opacity-0"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="relative w-full max-w-lg mx-auto transition-all duration-300 scale-95 opacity-0 modal-content">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <form id="templateForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="templateId" name="id">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                        <h6 class="mb-0" id="modalTitle">Add Resume Template</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Title</label>
                                <input type="text" name="title" id="title"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Categories</label>
                                <div id="categoryCheckboxes"
                                    class="flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <!-- Dynamic categories -->
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Thumbnail (Image)</label>
                                    <input type="file" name="thumbnail" id="thumbnail" class="w-full text-xs"
                                        accept="image/*">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Template File
                                        (PDF/DOC)</label>
                                    <input type="file" name="file_path" id="file_path" class="w-full text-xs"
                                        accept=".pdf,.doc,.docx">
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" onclick="closeModal()"
                                class="px-6 py-2 rounded-lg bg-gray-100 text-slate-700 font-bold uppercase text-xs hover:bg-gray-200 transition-all">Cancel</button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-bold uppercase text-xs hover:scale-102 transition-all shadow-soft-md">Save
                                Template</button>
                        </div>
                    </div>
                </form>
            </div>
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
                            return data.map(c => '<span class="px-2 py-1 mr-1 text-xxs font-bold bg-gray-100 text-slate-600 rounded-lg shadow-none border">' + c.name + '</span>').join('');
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
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="toggleStatus(${data.id})" class="text-xs font-bold text-slate-400 hover:text-slate-700" title="Toggle Status">
                                                <i class="fas ${data.status === 'active' ? 'fa-toggle-on text-green-500' : 'fa-toggle-off'} fa-lg"></i>
                                            </button>
                                            <button onclick="editTemplate(${data.id})" class="text-xs font-bold text-slate-400 hover:text-slate-700">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button onclick="deleteTemplate(${data.id})" class="text-xs font-bold text-rose-400 hover:text-rose-600">
                                                <i class="fas fa-trash"></i> Delete
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

        function loadCategories(selectedIds = []) {
            $.get("{{ route('admin.services.categories.index') }}", function (data) {
                let html = '';
                data.forEach(cat => {
                    let checked = selectedIds.includes(cat.id) ? 'checked' : '';
                    html += `
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="categories[]" value="${cat.id}" ${checked} class="rounded text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-xs text-slate-600">${cat.name}</span>
                            </label>
                        `;
                });
                $('#categoryCheckboxes').html(html || '<span class="text-xs text-slate-400 italic">No categories found. Add some first.</span>');
            });
        }

        function openCreateModal() {
            $('#templateForm')[0].reset();
            $('#templateId').val('');
            $('#modalTitle').text('Add Resume Template');
            loadCategories();
            $('#templateModal').removeClass('hidden');
            setTimeout(() => {
                $('#templateModal').removeClass('opacity-0');
                $('#templateModal .modal-content').removeClass('scale-95 opacity-0');
            }, 10);
        }

        function editTemplate(id) {
            $.get("{{ url('admin/services/resumes/edit') }}/" + id, function (data) {
                $('#templateId').val(data.id);
                $('#title').val(data.title);
                $('#description').val(data.description);
                $('#modalTitle').text('Edit Resume Template');
                let selectedIds = data.categories ? data.categories.map(c => c.id) : [];
                loadCategories(selectedIds);
                $('#templateModal').removeClass('hidden');
                setTimeout(() => {
                    $('#templateModal').removeClass('opacity-0');
                    $('#templateModal .modal-content').removeClass('scale-95 opacity-0');
                }, 10);
            });
        }

        function closeModal() {
            $('#templateModal').addClass('opacity-0');
            $('#templateModal .modal-content').addClass('scale-95 opacity-0');
            setTimeout(() => {
                $('#templateModal').addClass('hidden');
            }, 300);
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
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
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

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
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