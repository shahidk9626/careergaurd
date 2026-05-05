@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0 font-bold">Recruited Customers</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            @if(hasPermission('staff.create'))
                                <a href="{{ route('admin.customers.create') }}"
                                    class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                                    <i class="fas fa-plus mr-1"></i> Add Customer
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="customerTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Email / WhatsApp</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Referred By</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Verification</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Profile</th>
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
@endsection

@push('scripts')
    <script>
        let table;
        const canEdit = {{ hasPermission('staff.edit') ? 'true' : 'false' }};
        const canDelete = {{ hasPermission('staff.delete') ? 'true' : 'false' }};

        $(document).ready(function () {
            table = $('#customerTable').DataTable({
                ajax: {
                    url: "{{ route('admin.customers.index') }}",
                    type: 'GET'
                },
                columns: [
                    {
                        data: 'name',
                        className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                    },
                    {
                        data: null,
                        className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function (data) {
                            return `
                                    <div class="flex flex-col">
                                        <h6 class="mb-0 text-sm leading-normal font-semibold">${data.email}</h6>
                                        <p class="mb-0 text-xxs leading-tight text-slate-400"><i class="fab fa-whatsapp text-green-500 mr-1"></i> ${data.whatsapp}</p>
                                    </div>
                                `;
                        }
                    },
                    {
                        data: 'referral',
                        className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                    },
                    {
                        data: 'verified',
                        className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function (data) {
                            let badgeClass = data === 'Yes' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300';
                            return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${data === 'Yes' ? 'Verified' : 'Pending'}</span>`;
                        }
                    },
                    {
                        data: 'profile_complete',
                        className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function (data) {
                            let badgeClass = data === 'Yes' ? 'bg-gradient-to-tl from-blue-600 to-cyan-400' : 'bg-gradient-to-tl from-red-600 to-rose-400';
                            return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${data === 'Yes' ? 'Complete' : 'Incomplete'}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function (data) {
                            let badgeClass = data === 'active' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-slate-600 to-slate-300';
                            return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${data}</span>`;
                        }
                    },
                    {
                        data: null,
                        className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                        render: function (data, type, row) {
                            let actions = `<div class="flex items-center justify-center gap-2">`;

                            if (canEdit) {
                                // FOOLPROOF URL: Uses the customer's ID to safely build the edit URL
                                let editUrl = "{{ url('admin/customers') }}/" + row.id + "/edit";
                                
                                actions += `
                                    <a href="${editUrl}" 
                                       class="inline-block p-2 mb-0 text-white transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-110 mx-1" 
                                       title="Edit">
                                        <i class="fas fa-edit text-sm pointer-events-none"></i>
                                    </a>`;
                            }

                            if (canDelete) {
                                actions += `
                                    <button onclick="confirmDelete(${row.id})" 
                                            class="inline-block p-2 mb-0 text-white transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-110 mx-1" 
                                            title="Delete">
                                        <i class="fas fa-trash text-sm pointer-events-none"></i>
                                    </button>`;
                            }

                            actions += `</div>`;
                            return actions;
                        }
                    }
                ],
                order: [[0, 'asc']],
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Deleting a customer will remove their profile association!",
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
                        url: "{{ url('/admin/customers/delete') }}/" + id,
                        type: 'DELETE',
                        data: { _token: "{{ csrf_token() }}" },
                        success: function (response) {
                            table.ajax.reload();
                            Swal.fire('Deleted!', response.success, 'success');
                        }
                    });
                }
            });
        }
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

        table.dataTable tbody td {
            vertical-align: middle !important;
            border-bottom: 1px solid #f8f9fa;
        }
    </style>
@endpush