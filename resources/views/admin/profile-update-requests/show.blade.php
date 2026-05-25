@extends('layouts.app')

@section('content')
<div class="w-full mx-auto">
    <!-- Header Card -->
    <div class="relative flex flex-col flex-auto min-w-0 p-4 mx-3 mt-6 overflow-hidden break-words border-0 shadow-blur rounded-2xl bg-white bg-clip-border">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-auto max-w-full px-3 my-auto">
                <div class="h-full">
                    <h5 class="mb-1 font-bold">Profile Update Request Details</h5>
                    <p class="mb-0 text-sm">
                        Submitted by: <strong class="text-slate-700">{{ $request->customer->name ?? 'N/A' }}</strong> on {{ $request->created_at->format('d M, Y H:i') }}
                    </p>
                </div>
            </div>
            <div class="flex-none w-auto max-w-full px-3 my-auto sm:ml-auto">
                <a href="{{ route('admin.profile-update-requests.index') }}" class="inline-block px-4 py-2 mb-0 text-xs font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer leading-pro ease-soft-in border-slate-300 text-slate-700 hover:scale-102">
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Cards -->
    <div class="flex flex-wrap -mx-3 mt-6">
        <!-- Request Status & Details Summary -->
        <div class="w-full max-w-full px-3 mb-6 lg:w-4/12 flex-none">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Summary</h6>
                </div>
                <div class="flex-auto p-4">
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Status:</strong> &nbsp;
                            @if($request->status === 'pending')
                                <span class="text-xxs px-2.5 py-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-slate-600 to-slate-300">Pending</span>
                            @elseif($request->status === 'approved')
                                <span class="text-xxs px-2.5 py-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-green-600 to-lime-400">Approved</span>
                            @else
                                <span class="text-xxs px-2.5 py-1 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-red-600 to-rose-400">Rejected</span>
                            @endif
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Customer ID:</strong> &nbsp; #{{ $request->customer_id }}
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Customer Name:</strong> &nbsp; {{ $request->customer->name ?? 'N/A' }}
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Customer Email:</strong> &nbsp; {{ $request->customer->email ?? 'N/A' }}
                        </li>
                        <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                            <strong class="text-slate-700">Requested By:</strong> &nbsp; {{ $request->requester->name ?? 'N/A' }}
                        </li>
                        @if($request->status === 'approved')
                            <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Approved By:</strong> &nbsp; {{ $request->approver->name ?? 'N/A' }}
                            </li>
                            <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-slate-700">Approved At:</strong> &nbsp; {{ $request->approved_at ? $request->approved_at->format('d M, Y H:i') : 'N/A' }}
                            </li>
                        @endif
                        @if($request->status === 'rejected')
                            <li class="relative block px-0 py-2 bg-white border-0 border-t-0 text-sm text-inherit">
                                <strong class="text-red-700">Rejection Reason:</strong><br>
                                <p class="text-sm p-3 bg-red-50 rounded-xl border border-red-100 mt-2 font-normal text-red-800">{{ $request->admin_remark }}</p>
                            </li>
                        @endif
                    </ul>

                    @if($request->status === 'pending')
                        <div class="mt-6 flex flex-col gap-3">
                            @if(hasPermission('profile-update-requests.approve'))
                                <form action="{{ route('admin.profile-update-requests.approve', $request->id) }}" method="POST" id="approveForm">
                                    @csrf
                                    <button type="submit" class="inline-block w-full px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-x-25 bg-150 tracking-tight-soft bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102">
                                        Approve Request
                                    </button>
                                </form>
                            @endif
                            @if(hasPermission('profile-update-requests.reject'))
                                <button type="button" onclick="window.openGlobalModal('rejectRequestModal')" class="inline-block w-full px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-x-25 bg-150 tracking-tight-soft bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102">
                                    Reject Request
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Request Details Table -->
        <div class="w-full max-w-full px-3 lg:w-8/12 flex-none">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Field Modifications</h6>
                    <p class="text-sm">List of profile fields modified during this request.</p>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Field Name</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Old Value</th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        New/Requested Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($request->details as $detail)
                                <tr>
                                    <td class="px-6 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm font-bold text-slate-700">{{ ucfirst(str_replace('_', ' ', $detail->field_name)) }}</span>
                                    </td>
                                    <td class="px-6 py-4 align-middle bg-transparent border-b border-gray-200 shadow-none">
                                        @if($detail->field_name === 'profile_image')
                                            @if($detail->old_value)
                                                <div class="avatar avatar-sm rounded-xl">
                                                    <img src="{{ asset('storage/' . $detail->old_value) }}" alt="old_profile_image" class="w-16 h-16 shadow-soft-sm rounded-xl object-cover" />
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400 font-semibold">None</span>
                                            @endif
                                        @else
                                            <span class="text-sm font-semibold text-slate-600">{{ $detail->old_value ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-middle bg-transparent border-b border-gray-200 shadow-none">
                                        @if($detail->field_name === 'profile_image')
                                            @if($detail->new_value)
                                                <div class="avatar avatar-sm rounded-xl">
                                                    <img src="{{ asset('storage/' . $detail->new_value) }}" alt="new_profile_image" class="w-16 h-16 shadow-soft-sm rounded-xl object-cover border border-purple-500" />
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400 font-semibold">None</span>
                                            @endif
                                        @else
                                            <span class="text-sm font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-lg border border-purple-100">{{ $detail->new_value ?? 'N/A' }}</span>
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
</div>

<!-- Reject Rejection Reason Modal -->
@if($request->status === 'pending' && hasPermission('profile-update-requests.reject'))
    <x-modal id="rejectRequestModal" title="Reject Profile Update Request">
        <form id="rejectRequestForm" action="{{ route('admin.profile-update-requests.reject', $request->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reject_remark" class="block mb-2 text-sm font-bold text-slate-700">Reason for Rejection</label>
                <textarea name="remark" id="reject_remark" rows="4" required class="w-full px-3 py-2 text-sm text-slate-700 placeholder-slate-400 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-fuchsia-300 focus:shadow-soft-primary-outline" placeholder="Enter reason here..."></textarea>
            </div>

            <div class="flex justify-end pt-3 border-t border-gray-100">
                <button type="button" onclick="window.closeGlobalModal('rejectRequestModal')" class="inline-block px-6 py-3 mr-2 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer leading-pro text-xs ease-soft-in tracking-tight-soft border-slate-300 hover:scale-102">
                    Cancel
                </button>
                <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-x-25 bg-150 tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102">
                    Submit Rejection
                </button>
            </div>
        </form>
    </x-modal>
@endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}"
                });
            @endif

            // Highlight modal validation
            $("#rejectRequestForm").validate({
                rules: {
                    remark: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    remark: {
                        required: "Please provide a reason for rejection.",
                        minlength: "Reason must be at least 5 characters long."
                    }
                }
            });
        });
    </script>
@endpush
