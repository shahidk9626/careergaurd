@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
                            <h6 class="mb-0">Job Links Management</h6>
                        </div>
                        <div class="w-full max-w-full px-3 text-right lg:w-1/2 lg:flex-none">
                            <button onclick="openCreateModal()"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Job Link
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-6 px-0 pb-2">
                    <div class="overflow-x-auto">
                        <table id="jobLinksTable"
                            class="table items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">
                                        Title</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">
                                        Categories</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">
                                        Url</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables content -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Link Modal -->
    <div id="jobModal"
        class="fixed inset-0 z-990 hidden items-center justify-center overflow-auto bg-black/50 transition-all duration-300 opacity-0"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="relative w-full max-w-lg mx-auto transition-all duration-300 scale-95 opacity-0 modal-content">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <form id="jobForm">
                    @csrf
                    <input type="hidden" id="jobId" name="id">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                        <h6 class="mb-0" id="modalTitle">Add Job Link</h6>
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
                                <label class="block text-sm font-medium text-slate-600 mb-1">Company Name</label>
                                <input type="text" name="company_name" id="company_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Categories</label>
                                <div id="categoryCheckboxes"
                                    class="flex flex-wrap gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <!-- Dynamic categories -->
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Job URL</label>
                                <input type="url" name="job_url" id="job_url"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" onclick="closeModal()"
                                class="px-6 py-2 rounded-lg bg-gray-100 text-slate-700 font-bold uppercase text-xs hover:bg-gray-200 transition-all">Cancel</button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-bold uppercase text-xs hover:scale-102 transition-all shadow-soft-md">Save
                                Job Link</button>
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
            table = $('#jobLinksTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('admin.services.job-links.index') }}",
                    dataSrc: ''
                },
                columns: [
                    {
                        data: 'title',
                        render: function (data, type, row) {
                            return '<div class="flex px-2 py-1"><div class="flex flex-col justify-center"><h6 class="mb-0 text-sm leading-normal">' + data + '</h6><p class="mb-0 text-xs leading-tight text-slate-400">' + (row.company_name || '') + '</p></div></div>';
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
                        data: 'job_url',
                        render: function (data) {
                            return '<a href="' + data + '" target="_blank" class="text-xs font-semibold leading-tight text-slate-400 hover:text-slate-700"><i class="fas fa-external-link-alt"></i> View Link</a>';
                        }
                    },
                    {
                        data: 'status',
                        className: 'align-middle text-center text-sm',
                        render: function (data, type, row) {
                            const badgeColor = data === 'active' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300';
                            return '<span onclick="toggleStatus(' + row.id + ')" class="cursor-pointer badge badge-sm ' + badgeColor + '">' + data + '</span>';
                        }
                    },
                    {
                        data: 'id',
                        className: 'align-middle text-center',
                        render: function (data) {
                            return '<div class="flex justify-center gap-2">' +
                                '<button onclick="editJob(' + data + ')" class="text-xs font-semibold leading-tight text-slate-400 hover:text-slate-700"><i class="fas fa-edit"></i></button>' +
                                '<button onclick="deleteJob(' + data + ')" class="text-xs font-semibold leading-tight text-red-400 hover:text-red-700"><i class="fas fa-trash"></i></button>' +
                                '</div>';
                        }
                    }
                ],
                language: {
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                }
            });

            $('#jobForm').on('submit', function (e) {
                e.preventDefault();
                const id = $('#jobId').val();
                const url = id ? "{{ url('admin/services/job-links/update') }}/" + id : "{{ route('admin.services.job-links.store') }}";

                $.post(url, $(this).serialize(), function (response) {
                    Swal.fire('Success', response.success, 'success');
                    closeModal();
                    table.ajax.reload();
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
            $('#jobForm')[0].reset();
            $('#jobId').val('');
            $('#modalTitle').text('Add Job Link');
            loadCategories();
            window.openGlobalModal('jobModal');
        }

        function editJob(id) {
            $.get("{{ url('admin/services/job-links/edit') }}/" + id, function (data) {
                $('#jobId').val(data.id);
                $('#title').val(data.title);
                $('#company_name').val(data.company_name);
                $('#job_url').val(data.job_url);
                $('#description').val(data.description);
                $('#modalTitle').text('Edit Job Link');
                let selectedIds = data.categories ? data.categories.map(c => c.id) : [];
                loadCategories(selectedIds);
                window.openGlobalModal('jobModal');
            });
        }

        function deleteJob(id) {
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
                        url: "{{ url('admin/services/job-links/delete') }}/" + id,
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
            $.post("{{ url('admin/services/job-links/status') }}/" + id, { _token: "{{ csrf_token() }}" }, function (response) {
                table.ajax.reload();
            });
        }

        function closeModal() {
            window.closeGlobalModal('jobModal');
        }
    </script>
@endpush