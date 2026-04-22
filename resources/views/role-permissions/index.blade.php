@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Role Permissions</h6>
                        </div>
                    </div>
                </div>
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-6 overflow-x-auto">
                        <table id="rolePermTable" class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-tight-soft opacity-40 text-slate-400 opacity-70">
                                        Role Name</th>
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
        $(document).ready(function () {
            $('#rolePermTable').DataTable({
                ajax: {
                    url: "{{ route('role-permissions.index') }}",
                    type: 'GET'
                },
                columns: [{
                    data: 'name',
                    className: 'text-sm font-semibold leading-normal px-6 align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none'
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
                    data: null,
                    className: 'text-center align-middle bg-transparent border-b border-gray-200 whitespace-nowrap shadow-none',
                    render: function (data) {
                        return `
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ url('role-permissions') }}/${data.id}" class="inline-block px-4 py-2 mb-0 text-xs font-bold text-center text-white uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                                        <i class="fas fa-shield-alt mr-1"></i> Manage Permissions
                                    </a>
                                    <a href="javascript:;" onclick="window.location.href='{{ url('roles') }}'" class="inline-block px-4 py-2 mb-0 text-xs font-bold text-center text-slate-700 uppercase transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in bg-150 tracking-tight-soft bg-x-25 bg-gray-100 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                                        <i class="fas fa-edit mr-1"></i> Edit Role
                                    </a>
                                </div>
                            `;
                    }
                }
                ],
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true,
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search roles..."
                }
            });
        });
    </script>
@endpush