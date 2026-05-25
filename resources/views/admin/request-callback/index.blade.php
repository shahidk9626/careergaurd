@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Callback Requests</h6>
                    <p class="text-sm">View and manage customer callback requests.</p>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="callbackRequestsTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        #</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Customer Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Email</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Phone</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Flag</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Concern</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Related Membership</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Status</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Created Date</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $index => $req)
                                <tr>
                                    <td class="px-6 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-semibold leading-normal text-slate-700">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-semibold leading-normal text-slate-700">{{ $req->user->name }}</span>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm leading-normal text-slate-600">{{ $req->user->email }}</span>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm leading-normal text-slate-600">{{ $req->user->phone ?: ($req->user->whatsapp_number ?: 'N/A') }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        @if($req->flag === 'direct')
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-blue-600 to-cyan-400">Direct</span>
                                        @elseif($req->flag === 'purchased')
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-purple-700 to-pink-500">Purchased</span>
                                        @else
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-red-600 to-orange-400">Enquiry</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 shadow-none">
                                        <span class="text-sm leading-normal text-slate-600 block max-w-xs truncate">{{ $req->concern }}</span>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        @if($req->purchasedPlan)
                                            <div class="flex flex-col">
                                                <span class="text-sm font-semibold leading-normal text-slate-700">{{ $req->purchasedPlan->plan_name }}</span>
                                                <span class="text-xxs leading-tight text-slate-400">{{ $req->purchasedPlan->plan_unique_id }}</span>
                                                @if($req->claim)
                                                    <span class="text-xxs font-bold text-purple-600">Claim ID: #{{ $req->claim->id }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        @if($req->status === 'pending')
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-slate-600 to-slate-300">Pending</span>
                                        @elseif($req->status === 'contacted')
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-blue-600 to-cyan-400">Contacted</span>
                                        @elseif($req->status === 'resolved')
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-green-600 to-lime-400">Resolved</span>
                                        @else
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-red-600 to-rose-400">Closed</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-xs font-semibold leading-normal text-slate-400">{{ $req->created_at->format('d M, Y H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <button onclick="viewConcern({{ json_encode($req) }})"
                                            class="inline-block px-3 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102">
                                            View
                                        </button>
                                        @if(hasPermission('request-callback.status'))
                                            <button onclick="openStatusModal({{ $req->id }}, '{{ $req->status }}')"
                                                class="inline-block px-3 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102">
                                                Update Status
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Status Update Modal -->
    @if(hasPermission('request-callback.status'))
        <x-modal id="updateStatusModal" title="Update Callback Status">
            <form id="updateStatusForm" action="{{ route('admin.request-callback.update-status') }}" method="POST">
                @csrf
                <input type="hidden" name="request_id" id="status_request_id" value="">
                <div class="mb-4">
                    <label for="status_select" class="block mb-2 text-sm font-bold text-slate-700">Select Status</label>
                    <select name="status" id="status_select" class="w-full px-3 py-2 text-sm text-slate-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-fuchsia-300 focus:shadow-soft-primary-outline">
                        <option value="pending">Pending</option>
                        <option value="contacted">Contacted</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="flex justify-end pt-3 border-t border-gray-100">
                    <button type="button" onclick="window.closeGlobalModal('updateStatusModal')" class="inline-block px-6 py-3 mr-2 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer leading-pro text-xs ease-soft-in tracking-tight-soft border-slate-300 hover:scale-102">
                        Cancel
                    </button>
                    <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-x-25 bg-150 tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102">
                        Save Changes
                    </button>
                </div>
            </form>
        </x-modal>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#callbackRequestsTable').DataTable({
                order: [[8, 'desc']],
                responsive: true
            });

            @if(hasPermission('request-callback.status'))
                $('#updateStatusForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            window.closeGlobalModal('updateStatusModal');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.success || 'Status updated successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON.error || 'Failed to update callback request status.'
                            });
                        }
                    });
                });
            @endif
        });

        function viewConcern(req) {
            let membershipInfo = 'N/A';
            if (req.purchased_plan) {
                membershipInfo = `${req.purchased_plan.plan_name} (${req.purchased_plan.plan_unique_id})`;
                if (req.claim) {
                    membershipInfo += ` <br><span class="text-xs text-purple-600 font-bold">Claim Request ID: #${req.claim.id}</span>`;
                }
            }

            let flagBadge = '';
            if (req.flag === 'direct') {
                flagBadge = '<span class="text-xxs px-2 py-0.5 text-white bg-cyan-500 rounded-lg font-bold uppercase">Direct</span>';
            } else if (req.flag === 'purchased') {
                flagBadge = '<span class="text-xxs px-2 py-0.5 text-white bg-purple-500 rounded-lg font-bold uppercase">Purchased</span>';
            } else {
                flagBadge = '<span class="text-xxs px-2 py-0.5 text-white bg-orange-500 rounded-lg font-bold uppercase">Enquiry</span>';
            }

            let statusBadge = '';
            if (req.status === 'pending') {
                statusBadge = '<span class="text-xxs px-2 py-0.5 text-white bg-slate-500 rounded-lg font-bold uppercase">Pending</span>';
            } else if (req.status === 'contacted') {
                statusBadge = '<span class="text-xxs px-2 py-0.5 text-white bg-blue-500 rounded-lg font-bold uppercase">Contacted</span>';
            } else if (req.status === 'resolved') {
                statusBadge = '<span class="text-xxs px-2 py-0.5 text-white bg-green-500 rounded-lg font-bold uppercase">Resolved</span>';
            } else {
                statusBadge = '<span class="text-xxs px-2 py-0.5 text-white bg-red-500 rounded-lg font-bold uppercase">Closed</span>';
            }

            let phone = req.user.phone ? req.user.phone : (req.user.whatsapp_number ? req.user.whatsapp_number : 'N/A');

            Swal.fire({
                title: 'Callback Request Details',
                html: `
                    <div class="text-left">
                        <p class="mb-1"><strong>Customer Name:</strong> ${req.user.name}</p>
                        <p class="mb-1"><strong>Email:</strong> ${req.user.email}</p>
                        <p class="mb-1"><strong>Phone:</strong> ${phone}</p>
                        <p class="mb-1"><strong>Source Flag:</strong> ${flagBadge}</p>
                        <p class="mb-1"><strong>Status:</strong> ${statusBadge}</p>
                        <p class="mb-1"><strong>Related Membership:</strong> ${membershipInfo}</p>
                        <p class="mb-1"><strong>Submitted On:</strong> ${new Date(req.created_at).toLocaleString()}</p>
                        <hr class="my-3">
                        <p><strong>Customer Concern:</strong></p>
                        <p class="text-sm p-3 bg-gray-50 rounded-xl border border-gray-100 whitespace-pre-wrap">${req.concern}</p>
                    </div>
                `,
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold'
                },
                buttonsStyling: false
            });
        }

        function openStatusModal(requestId, currentStatus) {
            document.getElementById('status_request_id').value = requestId;
            document.getElementById('status_select').value = currentStatus;
            window.openGlobalModal('updateStatusModal');
        }
    </script>
@endpush
