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
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">
                                        Slug</th>
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

    <!-- Category Modal -->
    <div id="categoryModal"
        class="fixed inset-0 z-990 hidden items-center justify-center overflow-auto bg-black/50 transition-all duration-300 opacity-0"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="relative w-full max-w-md mx-auto transition-all duration-300 scale-95 opacity-0 modal-content">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <form id="categoryForm">
                    @csrf
                    <input type="hidden" id="categoryId" name="id">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                        <h6 class="mb-0" id="modalTitle">Add Service Category</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Category Name</label>
                            <input type="text" name="name" id="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder:text-gray-400"
                                placeholder="e.g. Software Engineer" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                            <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" onclick="closeModal()"
                                class="px-6 py-2 rounded-lg bg-gray-100 text-slate-700 font-bold uppercase text-xs hover:bg-gray-200 transition-all">Cancel</button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-bold uppercase text-xs hover:scale-102 transition-all shadow-soft-md">Save
                                Category</button>
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
            table = $('#categoriesTable').DataTable({
                processing: true,
                serverSide: false, // Small dataset
                ajax: {
                    url: "{{ route('admin.services.categories.index') }}",
                    dataSrc: ''
                },
                columns: [
                    {
                        data: 'name',
                        render: function (data) {
                            return '<div class="flex px-2 py-1"><div class="flex flex-col justify-center"><h6 class="mb-0 text-sm leading-normal">' + data + '</h6></div></div>';
                        }
                    },
                    {
                        data: 'slug',
                        render: function (data) {
                            return '<span class="text-xs font-semibold leading-tight text-slate-400">' + data + '</span>';
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
                                '<button onclick="editCategory(' + data + ')" class="text-xs font-semibold leading-tight text-slate-400 hover:text-slate-700"><i class="fas fa-edit"></i></button>' +
                                '<button onclick="deleteCategory(' + data + ')" class="text-xs font-semibold leading-tight text-red-400 hover:text-red-700"><i class="fas fa-trash"></i></button>' +
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

        function openCreateModal() {
            $('#categoryForm')[0].reset();
            $('#categoryId').val('');
            $('#modalTitle').text('Add Service Category');
            window.openGlobalModal('categoryModal');
        }

        function editCategory(id) {
            $.get("{{ url('admin/services/categories/edit') }}/" + id, function (data) {
                $('#categoryId').val(data.id);
                $('#name').val(data.name);
                $('#status').val(data.status);
                $('#modalTitle').text('Edit Service Category');
                window.openGlobalModal('categoryModal');
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

        function closeModal() {
            window.closeGlobalModal('categoryModal');
        }
    </script>
@endpush