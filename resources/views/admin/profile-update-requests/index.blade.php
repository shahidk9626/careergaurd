@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0 font-bold">Profile Update Requests</h6>
                    <p class="text-sm">View and manage customer profile update approval requests.</p>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="profileRequestsTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        #</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Customer Name</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Request Date</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Status</th>
                                    <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Requested By</th>
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
                                        <span class="text-sm font-semibold leading-normal text-slate-700">{{ $req->customer->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-xs font-semibold leading-normal text-slate-400">{{ $req->created_at->format('d M, Y H:i') }}</span>
                                    </td>
                                    <td class="px-2 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        @if($req->status === 'pending')
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-slate-600 to-slate-300">Pending</span>
                                        @elseif($req->status === 'approved')
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-green-600 to-lime-400">Approved</span>
                                        @else
                                            <span class="text-xxs px-2.5 py-1.4 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white rounded-1.8 bg-gradient-to-tl from-red-600 to-rose-400">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-4 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <span class="text-sm leading-normal text-slate-600">{{ $req->requester->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none">
                                        <a href="{{ route('admin.profile-update-requests.show', $req->id) }}"
                                            class="inline-block px-3 py-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102">
                                            View Details
                                        </a>
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
            $('#profileRequestsTable').DataTable({
                order: [[2, 'desc']],
                responsive: true
            });
        });
    </script>
@endpush
