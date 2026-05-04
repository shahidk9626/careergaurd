@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Claim Requests</h6>
                    <p class="text-sm">Manage and review submitted claim applications.</p>
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
                                        Plan Details</th>
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
                                        <div class="flex flex-col">
                                            <h6 class="mb-0 text-sm font-semibold leading-normal">{{ $claim->plan->name }}</h6>
                                            <p class="mb-0 text-xxs leading-tight text-slate-400">{{ $claim->plan_unique_id }}</p>
                                        </div>
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
                                        <button onclick="viewDocuments({{ json_encode($claim) }})"
                                            class="inline-block px-3 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102">
                                            View
                                        </button>
                                        @if($claim->status === 'pending')
                                            <button onclick="updateStatus({{ $claim->id }}, 'approved')"
                                                class="inline-block px-3 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102">
                                                Approve
                                            </button>
                                            <button onclick="updateStatus({{ $claim->id }}, 'rejected')"
                                                class="inline-block px-3 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102">
                                                Reject
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
                title: 'Claim Documents',
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
            const title = status === 'approved' ? 'Approve Claim?' : 'Reject Claim?';
            const text = status === 'approved' ? 'This will mark the plan as claimed.' : 'This will reject the claim application.';
            
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
    </script>
@endpush
