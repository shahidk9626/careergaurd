<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('assets/img/apple-icon.png')); ?>" />
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/favicon.png')); ?>" />
    <title><?php echo e(config('app.name', 'Soft UI Dashboard Tailwind')); ?></title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons --> <!-- updated by ss -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Nucleo Icons -->
    <link href="<?php echo e(asset('assets/css/nucleo-icons.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('assets/css/nucleo-svg.css')); ?>" rel="stylesheet" />
    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Main Styling -->
    <link href="<?php echo e(asset('assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5')); ?>" rel="stylesheet" />
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
        <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="w-full px-6 py-6 mx-auto">
            <?php echo $__env->yieldContent('content'); ?>

            <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </main>

    <!-- plugin for charts  -->
    <script src="<?php echo e(asset('assets/js/plugins/chartjs.min.js')); ?>" async></script>
    <!-- plugin for scrollbar  -->
    <script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>" async></script>
    <!-- github button -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- main script file  -->
    <script src="<?php echo e(asset('assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5')); ?>" async></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- global modal helper -->
    <script>
        window.openGlobalModal = function (id) {
            const modal = document.getElementById(id);
            const content = modal.querySelector('.modal-content') || document.getElementById(id + '-content');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');

                // Trigger animation
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    if (content) {
                        content.classList.remove('opacity-0', 'scale-95');
                        content.classList.add('opacity-100', 'scale-100');
                    }
                }, 10);
            }
        };

        window.closeGlobalModal = function (id) {
            const modal = document.getElementById(id);
            const content = modal.querySelector('.modal-content') || document.getElementById(id + '-content');
            if (modal) {
                if (content) {
                    content.classList.remove('opacity-100', 'scale-100');
                    content.classList.add('opacity-0', 'scale-95');
                }
                modal.classList.remove('opacity-100');

                // Wait for animation
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }, 300);
            }
        };

        // ESC key close
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const visibleModal = document.querySelector('[role="dialog"]:not(.hidden)');
                if (visibleModal) {
                    window.closeGlobalModal(visibleModal.id);
                }
            }
        });
    </script>
    <style>
        .overflow-hidden {
            overflow: hidden !important;
        }
    </style>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH /Users/Raif/Documents/GitHub/careergaurd/resources/views/layouts/app.blade.php ENDPATH**/ ?>