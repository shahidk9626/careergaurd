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
                        <div class="w-full md:w-1/2 max-w-full px-3 flex flex-wrap items-center justify-center md:justify-end mt-3 md:mt-0" style="gap:10px;">
    @if(hasPermission('staff.delete'))
        <button id="bulkDeleteBtn" onclick="bulkDelete()"
            style="display: none; white-space:nowrap; padding:10px 18px;"
            class="inline-flex items-center justify-center font-bold text-center text-white uppercase transition-all border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 active:opacity-85 text-xs">
            <i class="fas fa-trash-alt" style="margin-right:6px;"></i> Delete Selected
        </button>
    @endif
    @if(hasPermission('staff.create'))
        <a href="{{ route('staff.create') }}"
            style="white-space:nowrap; padding:10px 18px;"
            class="inline-flex items-center justify-center font-bold text-center text-white uppercase transition-all border-0 rounded-lg cursor-pointer text-xs shadow-soft-md bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
            <i class="fas fa-plus" style="margin-right:6px;"></i> Add Staff
        </a>
    @endif
</div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="relative">
                        <!-- Horizontal Scroll Buttons for mobile / small screen sizes -->
                        <div class="absolute inset-y-0 left-0 flex items-center z-10 pointer-events-none">
                            <button type="button" id="tableScrollLeft" class="pointer-events-auto flex items-center justify-center w-9 h-9 ml-2 bg-white/95 backdrop-blur text-slate-800 rounded-full shadow-md border border-gray-200 transition-all duration-200 hover:bg-slate-50 hover:scale-105 active:scale-95 opacity-0 pointer-events-none" onclick="scrollTable(-150)" aria-label="Scroll Left">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center z-10 pointer-events-none">
                            <button type="button" id="tableScrollRight" class="pointer-events-auto flex items-center justify-center w-9 h-9 mr-2 bg-white/95 backdrop-blur text-slate-800 rounded-full shadow-md border border-gray-200 transition-all duration-200 hover:bg-slate-50 hover:scale-105 active:scale-95 opacity-0 pointer-events-none" onclick="scrollTable(150)" aria-label="Scroll Right">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>

                        <div id="tableScrollContainer" class="p-6 overflow-x-auto scroll-smooth">
                            <table id="staffTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    @if(hasPermission('staff.delete'))
                                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400" style="width: 40px;">
                                            <input type="checkbox" id="selectAll" class="rounded text-purple-600 cursor-pointer">
                                        </th>
                                    @endif
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
    </div>
@endsection

@push('scripts')
    <script>
        let table;
        const canEdit = {{ hasPermission('staff.edit') ? 'true' : 'false' }};
        const canDelete = {{ hasPermission('staff.delete') ? 'true' : 'false' }};
        const canStatus = {{ hasPermission('staff.status') ? 'true' : 'false' }};

        function scrollTable(offset) {
            const container = document.getElementById('tableScrollContainer');
            if (container) {
                container.scrollBy({
                    left: offset,
                    behavior: 'smooth'
                });
            }
        }

        $(document).ready(function () {
            table = $('#staffTable').DataTable({
                ajax: {
                    url: "{{ route('staff.index') }}",
                    type: 'GET'
                },
                scrollX: true,
                responsive: false, 
                autoWidth: false,
                columns: [
                @if(hasPermission('staff.delete'))
                {
                    data: 'id',
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return `<input type="checkbox" class="row-checkbox rounded text-purple-600 cursor-pointer" value="${data}">`;
                    }
                },
                @endif
                {
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

                        // View Button
                        if ({{ hasPermission('staff.view') ? 'true' : 'false' }}) {
                            let viewUrl = "{{ url('/staff') }}/" + data.id + "/view";
                            actions += `
                                <a href="${viewUrl}" 
                                   class="inline-block px-3 py-2 mx-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 hover:shadow-soft-xs active:opacity-85" 
                                   title="View Profile">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>`;
                        }

                        if (canStatus) {
                            let statusIcon = data.status ? 'fa-toggle-on text-green-500' : 'fa-toggle-off text-slate-400';
                            let statusTitle = data.status ? 'Deactivate' : 'Activate';

                            actions += `
                                <button onclick="confirmToggleStatus(${data.id}, ${data.status})" 
                                    class="inline-block px-3 py-2 mx-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 hover:shadow-soft-xs active:opacity-85" 
                                    title="${statusTitle}">
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
                    [@if(hasPermission('staff.delete')) 1 @else 0 @endif, 'desc']
                ],
                scrollX: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });

            // Scroll Button Visibility Control
            const container = document.getElementById('tableScrollContainer');
            const leftBtn = document.getElementById('tableScrollLeft');
            const rightBtn = document.getElementById('tableScrollRight');

            function updateScrollButtons() {
                if (!container || !leftBtn || !rightBtn) return;
                
                const showButtons = container.scrollWidth > container.clientWidth;
                
                if (showButtons) {
                    // Show right button if not scrolled to the end
                    if (container.scrollLeft + container.clientWidth < container.scrollWidth - 5) {
                        rightBtn.classList.remove('opacity-0', 'pointer-events-none');
                        rightBtn.classList.add('opacity-100');
                    } else {
                        rightBtn.classList.add('opacity-0', 'pointer-events-none');
                        rightBtn.classList.remove('opacity-100');
                    }
                    
                    // Show left button if scrolled away from start
                    if (container.scrollLeft > 5) {
                        leftBtn.classList.remove('opacity-0', 'pointer-events-none');
                        leftBtn.classList.add('opacity-100');
                    } else {
                        leftBtn.classList.add('opacity-0', 'pointer-events-none');
                        leftBtn.classList.remove('opacity-100');
                    }
                } else {
                    leftBtn.classList.add('opacity-0', 'pointer-events-none');
                    leftBtn.classList.remove('opacity-100');
                    rightBtn.classList.add('opacity-0', 'pointer-events-none');
                    rightBtn.classList.remove('opacity-100');
                }
            }

            if (container) {
                container.addEventListener('scroll', updateScrollButtons);
                window.addEventListener('resize', updateScrollButtons);
                
                table.on('draw', function() {
                    setTimeout(updateScrollButtons, 150);
                });
            }

            // Select All Checkbox
            $(document).on('change', '#selectAll', function() {
                $('.row-checkbox').prop('checked', this.checked);
                toggleBulkDeleteButton();
            });

            $(document).on('change', '.row-checkbox', function() {
                if (!this.checked) {
                    $('#selectAll').prop('checked', false);
                } else if ($('.row-checkbox:checked').length === $('.row-checkbox').length) {
                    $('#selectAll').prop('checked', true);
                }
                toggleBulkDeleteButton();
            });

            table.on('draw', function() {
                $('#selectAll').prop('checked', false);
                toggleBulkDeleteButton();
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
                title: 'Delete Record',
                text: "Are you sure you want to delete this record?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes Delete',
                cancelButtonText: 'Cancel',
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
                            if (response.error) {
                                Swal.fire('Cannot Delete!', response.error, 'error');
                            } else {
                                Swal.fire('Deleted!', 'Record deleted successfully.', 'success');
                                table.ajax.reload(null, false);
                                $('#selectAll').prop('checked', false);
                                toggleBulkDeleteButton();
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Failed to delete staff member.', 'error');
                        }
                    });
                }
            });
        }

        function toggleBulkDeleteButton() {
            const checkedCount = $('.row-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#bulkDeleteBtn').show();
            } else {
                $('#bulkDeleteBtn').hide();
            }
        }

        function bulkDelete() {
            const selectedIds = [];
            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire('Warning', 'Please select at least one record.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Delete Selected Records',
                text: "Are you sure you want to delete the selected records?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-red-600 to-rose-400 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('staff.bulk-destroy') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: selectedIds
                        },
                        success: function (response) {
                            if (response.summary) {
                                Swal.fire({
                                    title: 'Bulk Delete Summary',
                                    html: response.summary.message.replace(/\n/g, '<br>'),
                                    icon: response.summary.deleted > 0 ? 'success' : 'info'
                                });
                            } else {
                                Swal.fire('Deleted!', 'Selected records deleted.', 'success');
                            }
                            table.ajax.reload(null, false);
                            $('#selectAll').prop('checked', false);
                            toggleBulkDeleteButton();
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to delete selected staff.', 'error');
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
        #tableScrollContainer {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        #tableScrollLeft, #tableScrollRight {
            transition: opacity 0.2s ease, transform 0.2s ease, background-color 0.2s ease;
        }

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
        /* Force the DataTables container to handle overflow */
.dataTables_wrapper {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}

/* Prevent the table from shrinking smaller than its content */
#staffTable {
    width: 100% !important;
    min-width: max-content; 
}
    </style>
@endpush