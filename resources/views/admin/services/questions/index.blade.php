@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-full lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
                            <h6 class="mb-0">Interview Q&A Management</h6>
                        </div>
                        <div class="w-full max-w-full px-3 text-right lg:w-1/2 lg:flex-none">
                            <button onclick="openCreateModal()"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Question
                            </button>
                        </div>
                    </div>
                </div>
                <!-- px-0 removes padding so table borders span full width -->
                <div class="flex-auto p-6 px-0 pb-2">
                    <div class="overflow-x-auto">
                        <table id="questionsTable"
                            class="table items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="w-2/12 px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Title</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Categories</th>
                                    <th class="w-4/12 px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Question Preview</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Status</th>
                                    <th class="w-2/12 px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-100 text-slate-400">Action</th>
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

    <!-- Question Modal -->
    <div id="questionModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background-color: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 90vh; margin: 1rem;">
            
            <form id="questionForm" style="display: flex; flex-direction: column; height: 100%; margin: 0;">
                @csrf
                <input type="hidden" id="questionId" name="id">
                
                <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <h6 id="modalTitle" style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Add Interview Question</h6>
                    <button type="button" onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
                </div>

                <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1; display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" id="title" required style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;" placeholder="e.g. React Hook Basics">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Categories</label>
                        <div id="categoryCheckboxes" style="display: flex; flex-wrap: wrap; gap: 0.5rem; padding: 0.75rem; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Question Text <span style="color: #ef4444;">*</span></label>
                        <textarea name="question_text" id="question_text" rows="2" required style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Enter the exact interview question"></textarea>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Suggested Answer</label>
                        <textarea name="answer_text" id="answer_text" rows="4" style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Enter the suggested or correct answer"></textarea>
                    </div>
                </div>

                <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" onclick="closeModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Save Question</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        $(document).ready(function () {
            table = $('#questionsTable').DataTable({
                processing: true,
                serverSide: false,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.services.questions.index') }}",
                    dataSrc: ''
                },
                columns: [
                    {
                        data: 'title',
                        className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                        render: function (data) {
                            return '<h6 class="mb-0 text-sm leading-normal whitespace-normal break-words">' + data + '</h6>';
                        }
                    },
                    {
                        data: 'categories',
                        className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                        render: function (data) {
                            if (!data || data.length === 0) return '<span class="text-xs text-slate-400 italic">No Categories</span>';
                            return '<div class="flex flex-wrap gap-1">' + data.map(c => '<span class="px-2 py-1 text-xxs font-bold bg-gray-100 text-slate-600 rounded-lg shadow-none border">' + c.name + '</span>').join('') + '</div>';
                        }
                    },
                    {
                        data: 'question_text',
                        className: 'px-6 py-3 align-middle bg-transparent border-b shadow-none',
                        render: function (data) {
                            return '<span class="text-xs font-semibold leading-tight text-slate-400 whitespace-normal break-words">' + (data.length > 50 ? data.substring(0, 50) + '...' : data) + '</span>';
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
                                    <button onclick="editQuestion(${data})" class="edit-category-btn inline-block px-3 py-2 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-110 mx-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteQuestion(${data})" class="inline-block px-3 py-2 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-110 mx-2">
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

            $('#questionForm').on('submit', function (e) {
                e.preventDefault();
                const id = $('#questionId').val();
                const url = id ? "{{ url('admin/services/questions/update') }}/" + id : "{{ route('admin.services.questions.store') }}";

                $.post(url, $(this).serialize(), function (response) {
                    Swal.fire('Success', response.success, 'success');
                    closeModal();
                    table.ajax.reload();
                });
            });
        });

        function openModalLogic() {
            let modal = document.getElementById('questionModal');
            document.body.appendChild(modal); 
            modal.style.display = 'flex';     
        }

        function closeModal() {
            let modal = document.getElementById('questionModal');
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
            $('#questionForm')[0].reset();
            $('#questionId').val('');
            $('#modalTitle').text('Add Interview Question');
            loadCategories();
            openModalLogic();
        }

        function editQuestion(id) {
            $.get("{{ url('admin/services/questions/edit') }}/" + id, function (data) {
                $('#questionId').val(data.id);
                $('#title').val(data.title);
                $('#question_text').val(data.question_text);
                $('#answer_text').val(data.answer_text);
                $('#modalTitle').text('Edit Interview Question');
                let selectedIds = data.categories ? data.categories.map(c => c.id) : [];
                loadCategories(selectedIds);
                openModalLogic();
            });
        }

        function deleteQuestion(id) {
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
                        url: "{{ url('admin/services/questions/delete') }}/" + id,
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
            $.post("{{ url('admin/services/questions/status') }}/" + id, { _token: "{{ csrf_token() }}" }, function (response) {
                table.ajax.reload();
            });
        }
    </script>

    <style>
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

        /* NEW: Force table headers and data cells to have identical left padding */
        table.dataTable thead th,
        table.dataTable tbody td {
            padding-left: 1.5rem !important; /* Overrides the default DataTables squishing */
            border-bottom: 1px solid #f8f9fa;
            vertical-align: middle !important;
        }

        /* NEW: Exclude the Status and Action columns so they stay perfectly centered */
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