@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Support Requests</h6>
                    <p class="text-sm">Manage and review submitted support applications.</p>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="claimRequestsTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        #</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Customer</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Membership Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Membership Unique ID</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Submitted Date</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Status</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claims as $index => $claim)
                                <tr>
                                    <td class="px-6 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-semibold leading-normal text-slate-700">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <div class="flex flex-col">
                                            <h6 class="mb-0 text-sm font-semibold leading-normal">{{ $claim->user->name }}</h6>
                                            <p class="mb-0 text-xxs leading-tight text-slate-400">{{ $claim->user->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-semibold leading-normal">{{ $claim->plan->name }}</span>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-semibold leading-normal">{{ $claim->plan_unique_id }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-xs font-semibold leading-normal text-slate-400">{{ $claim->created_at->format('d M, Y') }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl {{ $claim->status === 'approved' ? 'from-green-600 to-lime-400' : ($claim->status === 'rejected' ? 'from-red-600 to-rose-400' : 'from-slate-600 to-slate-300') }}">
                                            {{ $claim->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        @if(hasPermission('claims.view_detail'))
                                            <button onclick="viewDocuments({{ json_encode($claim) }})"
                                                class="inline-block px-3 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102">
                                                View
                                            </button>
                                        @endif
                                        @if($claim->status === 'pending')
                                            @if(hasPermission('claims.approve') || hasPermission('support.approve'))
                                                <button onclick="openApprovalModal({{ $claim->id }})"
                                                    class="inline-block px-3 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102">
                                                    Approve
                                                </button>
                                            @endif
                                            @if(hasPermission('claims.reject'))
                                                <button onclick="updateStatus({{ $claim->id }}, 'rejected')"
                                                    class="inline-block px-3 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102">
                                                    Reject
                                                </button>
                                            @endif
                                        @endif
                                        @if($claim->claimedTransaction && $claim->claimedTransaction->transaction_screenshot)
                                            <a href="{{ asset('storage/' . $claim->claimedTransaction->transaction_screenshot) }}" target="_blank"
                                                class="inline-block px-3 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102">
                                                View Transaction Proof
                                            </a>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#claimRequestsTable').DataTable({
                order: [[3, 'desc']],
                responsive: true
            });
        });

        function viewDocuments(claim) {
            let salarySlipsHtml = '';
            if (claim.salary_slips) {
                claim.salary_slips.forEach((path, index) => {
                    salarySlipsHtml += `<a href="/storage/${path}" target="_blank" class="text-fuchsia-500 block mb-1">Slip ${index+1}</a>`;
                });
            }

            let otherDocsHtml = '';
            if (claim.other_documents) {
                claim.other_documents.forEach((path, index) => {
                    otherDocsHtml += `<a href="/storage/${path}" target="_blank" class="text-fuchsia-500 block mb-1">Doc ${index+1}</a>`;
                });
            }

            Swal.fire({
                title: 'Support Documents',
                html: `
                    <div class="text-left">
                        <p><strong>Termination Letter:</strong> <a href="/storage/${claim.termination_letter}" target="_blank" class="text-fuchsia-500">View File</a></p>
                        <p class="mt-2"><strong>Salary Slips:</strong></p>
                        ${salarySlipsHtml || 'N/A'}
                        <p class="mt-2"><strong>Other Documents:</strong></p>
                        ${otherDocsHtml || 'N/A'}
                        <p class="mt-2"><strong>Remarks:</strong></p>
                        <p class="text-sm">${claim.remarks || 'No remarks'}</p>
                    </div>
                `,
                confirmButtonText: 'Close',
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold'
                },
                buttonsStyling: false
            });
        }

        function updateStatus(claimId, status) {
            const title = status === 'approved' ? 'Approve Support?' : 'Reject Support?';
            const text = status === 'approved' ? 'This will mark the membership as supported.' : 'This will reject the support application.';
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Proceed!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-gradient-to-tl from-gray-900 to-slate-800 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.claim.update-status') }}",
                        type: 'POST',
                        data: {
                            claim_id: claimId,
                            status: status,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire('Success!', response.success, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', xhr.responseJSON.error || 'Failed to update status.', 'error');
                        }
                    });
                }
            });
        }

        function openApprovalModalLogic() {
            let modal = document.getElementById('claimApprovalModal');
            if (modal) {
                document.body.appendChild(modal); // Escapes parent layout traps
                modal.style.display = 'flex';     // Triggers centering
            }
        }

        function closeApprovalModal() {
            let modal = document.getElementById('claimApprovalModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        function openApprovalModal(claimId) {
            document.getElementById('approval_claim_id').value = claimId;
            document.getElementById('transaction_screenshot').value = '';
            document.getElementById('approval_remarks').value = '';
            openApprovalModalLogic();
        }

        $(document).ready(function() {
            $('#claimApprovalForm').on('submit', function(e) {
                e.preventDefault();
                
                let fileInput = document.getElementById('transaction_screenshot');
                if (!fileInput.files.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Required Field',
                        text: 'Please select a transaction screenshot before submitting.',
                    });
                    return;
                }

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        closeApprovalModal();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.success || 'Claim approved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.error || 'Unable to approve claim. Please try again.'
                        });
                    }
                });
            });
        });
    </script>

    <!-- Claim Approval Modal -->
    @if(hasPermission('claims.approve') || hasPermission('support.approve'))
        <div id="claimApprovalModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
            <div style="background-color: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 90vh; margin: 1rem;">
                <form id="claimApprovalForm" action="{{ route('admin.claim.update-status') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; height: 100%; margin: 0;">
                    @csrf
                    <input type="hidden" name="claim_id" id="approval_claim_id" value="">
                    <input type="hidden" name="status" value="approved">
                    
                    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                        <h6 style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Approve Support Request</h6>
                        <button type="button" onclick="closeApprovalModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
                    </div>

                    <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1; display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Transaction Screenshot / Payment Proof <span style="color: #ef4444;">*</span></label>
                            <input type="file" name="transaction_screenshot" id="transaction_screenshot" required accept="image/png, image/jpeg, image/jpg, application/pdf" style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none;">
                            <p style="margin-top: 0.25rem; font-size: 0.75rem; color: #94a3b8;">Accepted types: JPG, JPEG, PNG, PDF (Max: 5MB)</p>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Remarks (Optional)</label>
                            <textarea name="remarks" id="approval_remarks" rows="3" style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Any payment references or notes..."></textarea>
                        </div>
                    </div>

                    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                        <button type="button" onclick="closeApprovalModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                        <button type="submit" style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Submit & Approve</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endpush
