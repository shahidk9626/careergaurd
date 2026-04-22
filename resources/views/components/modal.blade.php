@props(['id', 'title', 'maxWidth' => 'md'])

@php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        default => 'max-w-md',
    };
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-[9999] hidden overflow-y-auto overflow-x-hidden outline-none"
    aria-labelledby="{{ $id }}-title" role="dialog" aria-modal="true">

    <!-- Backdrop with Fade -->
    <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" aria-hidden="true"></div>

    <!-- Scrollable container for centering -->
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
        <!-- Modal Content with Scale/Fade Transition -->
        <div class="relative inline-block w-full {{ $maxWidthClass }} px-4 pt-5 pb-4 overflow-hidden text-left align-middle transition-all transform bg-white shadow-soft-2xl rounded-2xl sm:my-8 sm:p-6 opacity-0 scale-95 duration-300"
            id="{{ $id }}-content">

            <!-- Header -->
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h6 class="mb-0 text-lg font-bold text-slate-700" id="{{ $id }}-title">
                    {{ $title ?? '' }}
                </h6>
                <button type="button" onclick="window.closeGlobalModal('{{ $id }}')"
                    class="box-content w-4 h-4 p-1 ml-auto text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="py-4">
                {{ $slot }}
            </div>

            <!-- Footer (optional) -->
            @if(isset($footer))
                <div class="flex flex-wrap items-center justify-end pt-3 border-t border-gray-100">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>