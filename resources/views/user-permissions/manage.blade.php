@extends('layouts.app')

@section('content')
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Custom User Permissions: <span
                                    class="text-purple-600 font-bold">{{ $user->name }}</span></h6>
                        </div>
                        <div class="w-1/2 max-w-full px-3 text-right">
                            <a href="{{ route('user-permissions.index') }}"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-gray-900 to-slate-800 hover:scale-102 active:opacity-85">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-6">
                    @if($user->id === 1)
                        <div class="p-8 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <i class="fas fa-crown text-5xl text-yellow-500 mb-4 scale-110"></i>
                            <h5 class="font-bold text-slate-700">All Access Granted</h5>
                            <p class="text-sm text-slate-500">Super Admin (User ID: 1) has full system access and requires no
                                manual permissions.</p>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg text-sm text-slate-600">
                            <strong>Assigned Role:</strong> {{ $user->role->name }} <br>
                            <span class="text-xs italic">Checking a permission here will grant it explicitly, overriding role
                                defaults. Unchecking will remove the explicit grant.</span>
                        </div>
                        <div class="mb-4 flex items-center">
                            <div class="flex items-center">
                                <input type="checkbox" id="selectAllGlobal" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                                <label for="selectAllGlobal" class="ml-2 text-sm font-bold text-slate-700 cursor-pointer">Select All Overrides</label>
                            </div>
                        </div>
                        <form id="userPermForm" action="{{ route('user-permissions.save', $user->id) }}" method="POST">
                            @csrf
                            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                    <thead class="align-bottom">
                                        <tr class="bg-gray-50 text-slate-700 uppercase font-bold text-xxs">
                                            <th class="px-6 py-3 text-left border-b tracking-tight-soft opacity-70">Module</th>
                                            <th class="px-6 py-3 text-center border-b tracking-tight-soft opacity-70 text-green-600">All</th>
                                            <th class="px-6 py-3 text-center border-b tracking-tight-soft opacity-70">View</th>
                                            <th class="px-6 py-3 text-center border-b tracking-tight-soft opacity-70">Create</th>
                                            <th class="px-6 py-3 text-center border-b tracking-tight-soft opacity-70">Edit</th>
                                            <th class="px-6 py-3 text-center border-b tracking-tight-soft opacity-70">Delete</th>
                                            <th class="px-6 py-3 text-center border-b tracking-tight-soft opacity-70">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modules as $module)
                                            <tr class="border-b hover:bg-gray-50 module-row" data-module="{{ $module->slug }}">
                                                <td class="px-6 py-4 text-sm font-semibold text-slate-700">{{ $module->name }}</td>
                                                <td class="px-6 py-4 text-center">
                                                    @if($module->permissions->count() > 0)
                                                        <input type="checkbox" class="row-select-all w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                                                    @endif
                                                </td>
                                                @foreach (['view', 'create', 'edit', 'delete', 'status'] as $action)
                                                    @php
                                                        $permission = $module->permissions->where('slug', $module->slug . '.' . $action)->first();
                                                    @endphp
                                                    <td class="px-6 py-4 text-center">
                                                        @if ($permission)
                                                            <input type="checkbox" name="user_permissions[{{ $permission->id }}]" value="1"
                                                                {{ isset($userPermissions[$permission->id]) && $userPermissions[$permission->id] ? 'checked' : '' }}
                                                                class="permission-checkbox w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
                                                        @else
                                                            <span class="text-xs text-slate-300">-</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-6 text-right">
                                <button type="submit"
                                    class="inline-block px-12 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                                    Save User Overrides
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // Check initial state for row-wise "All"
            $('.module-row').each(function () {
                updateRowState($(this));
            });
            updateGlobalState();

            // Global Select All
            $('#selectAllGlobal').on('change', function () {
                const checked = $(this).is(':checked');
                $('.permission-checkbox, .row-select-all').prop('checked', checked);
            });

            // Row-wise Select All
            $('.row-select-all').on('change', function () {
                const checked = $(this).is(':checked');
                $(this).closest('tr').find('.permission-checkbox').prop('checked', checked);
                updateGlobalState();
            });

            // Individual Permission Checkbox
            $('.permission-checkbox').on('change', function () {
                updateRowState($(this).closest('tr'));
                updateGlobalState();
            });

            function updateRowState(row) {
                const total = row.find('.permission-checkbox').length;
                const checked = row.find('.permission-checkbox:checked').length;
                row.find('.row-select-all').prop('checked', total > 0 && total === checked);
            }

            function updateGlobalState() {
                const total = $('.permission-checkbox').length;
                const checked = $('.permission-checkbox:checked').length;
                $('#selectAllGlobal').prop('checked', total > 0 && total === checked);
            }

            $('#userPermForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.success,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('user-permissions.index') }}";
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: xhr.responseJSON.error || 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>
@endsection