@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Plans Management</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            <a href="{{ route('admin.plans.create') }}"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Plan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="planTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Plan Name</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Tenure</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
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
        $(document).ready(function () {
            table = $('#planTable').DataTable({
                ajax: "{{ route('admin.plans.index') }}",
                columns: [
                    {
                        data: 'name',
                        className: 'px-6 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-sm font-semibold'
                    },
                    {
                        data: 'premium_amount',
                        className: 'px-2 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-sm font-semibold',
                        render: function (data) { return '₹' + parseFloat(data).toLocaleString(); }
                    },
                    {
                        data: null,
                        className: 'px-2 align-middle bg-transparent border-b whitespace-nowrap shadow-none text-sm',
                        render: function (data) {
                            return `<span class="capitalize font-bold text-slate-700">${data.tenure_type}</span> ${data.tenure_value ? '(' + data.tenure_value + ')' : ''}`;
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
                        data: null,
                        className: 'text-center align-middle bg-transparent border-b whitespace-nowrap shadow-none',
                        render: function (data) {
                            let editUrl = "{{ url('admin/plans/edit') }}/" + data.id;
                            return `
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="toggleStatus(${data.id})" class="text-xs font-bold text-slate-400 hover:text-slate-700">
                                        <i class="fas ${data.status === 'active' ? 'fa-toggle-on text-green-500' : 'fa-toggle-off'} fa-lg"></i>
                                    </button>
                                    <a href="${editUrl}" class="text-xs font-bold text-slate-400 hover:text-slate-700">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="deletePlan(${data.id})" class="text-xs font-bold text-rose-400 hover:text-rose-600">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                language: {
                    paginate: { previous: "<i class='fas fa-angle-left'></i>", next: "<i class='fas fa-angle-right'></i>" }
                }
            });
        });

        function toggleStatus(id) {
            $.post("{{ url('admin/plans/status') }}/" + id, { _token: "{{ csrf_token() }}" }, function (res) {
                table.ajax.reload();
                Toast.fire({ icon: 'success', title: res.success });
            });
        }

        function deletePlan(id) {
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: "{{ url('admin/plans/delete') }}/" + id,
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