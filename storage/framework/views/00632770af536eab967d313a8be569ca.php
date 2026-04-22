<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id', 'title', 'maxWidth' => 'md']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['id', 'title', 'maxWidth' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        default => 'max-w-md',
    };
?>

<div id="<?php echo e($id); ?>" class="fixed inset-0 z-[9999] hidden overflow-y-auto overflow-x-hidden outline-none"
    aria-labelledby="<?php echo e($id); ?>-title" role="dialog" aria-modal="true">

    <!-- Backdrop with Fade -->
    <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" aria-hidden="true"></div>

    <!-- Scrollable container for centering -->
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
        <!-- Modal Content with Scale/Fade Transition -->
        <div class="relative inline-block w-full <?php echo e($maxWidthClass); ?> px-4 pt-5 pb-4 overflow-hidden text-left align-middle transition-all transform bg-white shadow-soft-2xl rounded-2xl sm:my-8 sm:p-6 opacity-0 scale-95 duration-300"
            id="<?php echo e($id); ?>-content">

            <!-- Header -->
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h6 class="mb-0 text-lg font-bold text-slate-700" id="<?php echo e($id); ?>-title">
                    <?php echo e($title ?? ''); ?>

                </h6>
                <button type="button" onclick="window.closeGlobalModal('<?php echo e($id); ?>')"
                    class="box-content w-4 h-4 p-1 ml-auto text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="py-4">
                <?php echo e($slot); ?>

            </div>

            <!-- Footer (optional) -->
            <?php if(isset($footer)): ?>
                <div class="flex flex-wrap items-center justify-end pt-3 border-t border-gray-100">
                    <?php echo e($footer); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /Users/Raif/Documents/GitHub/careergaurd/resources/views/components/modal.blade.php ENDPATH**/ ?>