@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0 font-bold">Staff Referrals & Commissions</h6>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="commissionTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    @if(auth()->user()->id === 1 || (auth()->user()->role && auth()->user()->role->slug === 'admin'))
                                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                            Staff Name</th>
                                    @endif
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Customer Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Membership Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Amount</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Purchase Date</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Payment Status</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Referral Status</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
                                        Transaction ID</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-70 text-slate-400">
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
        const isAdmin = {{ (auth()->user()->id === 1 || (auth()->user()->role && auth()->user()->role->slug === 'admin')) ? 'true' : 'false' }};
        const canChangeStatus = {{ hasPermission('staff-commission.status') ? 'true' : 'false' }};

        $(document).ready(function () {
            let columns = [];
            
            if (isAdmin) {
                columns.push({
                    data: 'staff_name',
                    className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                });
            }

            columns.push(
                {
                    data: 'customer_name',
                    className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'plan_name',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'amount',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        return '₹' + data;
                    }
                },
                {
                    data: 'purchase_date',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: 'payment_status',
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        let badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                        if (data === 'success') badgeClass = 'bg-gradient-to-tl from-green-600 to-lime-400';
                        if (data === 'failed') badgeClass = 'bg-gradient-to-tl from-red-600 to-rose-400';
                        if (data === 'expired' || data === 'cancelled') badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                        
                        let label = data ? data.toUpperCase() : 'PENDING';
                        return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${label}</span>`;
                    }
                },
                {
                    data: 'referral_status',
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        let badgeClass = 'bg-gradient-to-tl from-slate-600 to-slate-300';
                        if (data === 'paid') badgeClass = 'bg-gradient-to-tl from-green-600 to-lime-400';
                        if (data === 'expired') badgeClass = 'bg-gradient-to-tl from-yellow-600 to-amber-400';
                        if (data === 'cancelled') badgeClass = 'bg-gradient-to-tl from-red-600 to-rose-400';
                        if (data === 'pending') badgeClass = 'bg-gradient-to-tl from-purple-700 to-pink-500';
                        
                        let label = data ? data.charAt(0).toUpperCase() + data.slice(1) : 'Pending';
                        return `<span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 ${badgeClass}">${label}</span>`;
                    }
                },
                {
                    data: 'transaction_id',
                    className: 'text-sm leading-normal px-2 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
                },
                {
                    data: null,
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (row) {
                        if (row.referral_status === 'pending' && canChangeStatus) {
                            return `
                                <button onclick="cancelReferral(${row.id})" 
                                        class="inline-block px-3 py-1.5 mb-0 text-white font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xxs ease-soft-in shadow-soft-md bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 active:opacity-85" 
                                        title="Cancel Referral">
                                    Cancel
                                </button>
                            `;
                        }
                        return '<span class="text-xxs text-slate-400">N/A</span>';
                    }
                }
            );

            table = $('#commissionTable').DataTable({
                ajax: {
                    url: "{{ route('admin.staff-commission.index') }}",
                    type: 'GET'
                },
                columns: columns,
                order: [[isAdmin ? 4 : 3, 'desc']],
                responsive: true,
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        });

        function cancelReferral(id) {
            Swal.fire({
                title: 'Cancel Payment Link?',
                text: "Are you sure you want to cancel this referral link? The customer will no longer be able to use it to pay.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Cancel It!',
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-red-600 to-rose-400 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/staff-commission') }}/" + id + "/status",
                        type: 'POST',
                        data: { 
                            _token: "{{ csrf_token() }}",
                            status: 'cancelled'
                        },
                        success: function (response) {
                            if (response.success) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cancelled!',
                                    text: 'Referral link has been cancelled successfully.',
                                    customClass: {
                                        confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold'
                                    },
                                    buttonsStyling: false
                                });
                            } else {
                                Swal.fire('Error!', response.error || 'Something went wrong', 'error');
                            }
                        },
                        error: function (xhr) {
                            let msg = xhr.responseJSON ? xhr.responseJSON.error : 'Request failed.';
                            Swal.fire('Failed!', msg, 'error');
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
