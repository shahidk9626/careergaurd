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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            if (typeof $.validator !== 'undefined') {
                // Name validation (only letters and spaces, min 3 chars)
                $.validator.addMethod("lettersnspaces", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
                }, "Only alphabets and spaces are allowed");

                // Indian mobile validation (starts 6-9, exactly 10 digits)
                $.validator.addMethod("indianmobile", function(value, element) {
                    return this.optional(element) || /^[6-9]\d{9}$/.test(value);
                }, "Please enter a valid 10-digit Indian mobile number starting with 6-9");

                // Aadhaar validation (exactly 12 digits, numeric)
                $.validator.addMethod("aadhar", function(value, element) {
                    return this.optional(element) || /^\d{12}$/.test(value);
                }, "Aadhaar number must be exactly 12 digits");

                // PAN validation
                $.validator.addMethod("pan", function(value, element) {
                    return this.optional(element) || /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(value.toUpperCase());
                }, "Please enter a valid PAN card number (e.g. ABCDE1234F)");

                // Pincode validation (exactly 6 digits)
                $.validator.addMethod("pincode_custom", function(value, element) {
                    return this.optional(element) || /^\d{6}$/.test(value);
                }, "Pincode must be exactly 6 digits");

                // Date of birth validation (cannot be in the future)
                $.validator.addMethod("pastdate", function(value, element) {
                    if (!value) return true;
                    let inputDate = new Date(value);
                    let today = new Date();
                    inputDate.setHours(0,0,0,0);
                    today.setHours(0,0,0,0);
                    return inputDate <= today;
                }, "Date cannot be a future date");

                // File size validation (max 2MB)
                $.validator.addMethod("filesize", function(value, element, param) {
                    if (this.optional(element)) return true;
                    if (element.files && element.files.length > 0) {
                        for (let i = 0; i < element.files.length; i++) {
                            if (element.files[i].size > param) {
                                return false;
                            }
                        }
                    }
                    return true;
                }, "File size must not exceed 2 MB.");

                // File extension validation (jpg, jpeg, png, pdf)
                $.validator.addMethod("extension_custom", function(value, element, param) {
                    if (this.optional(element)) return true;
                    let ext = value.split('.').pop().toLowerCase();
                    let allowed = param.split('|');
                    return allowed.includes(ext);
                }, "Invalid file type. Only jpg, jpeg, png, pdf are allowed.");

                // Strong password validation
                $.validator.addMethod("strong_password", function(value, element) {
                    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
                }, "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character");

                // Configure default validate options
                $.validator.setDefaults({
                    errorElement: 'p',
                    errorClass: 'text-red-500 text-xs mt-1 error-message',
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('border-red-500');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('border-red-500');
                    },
                    errorPlacement: function(error, element) {
                        let parent = element.closest('.mb-4') || element.parent();
                        parent.find('.error-message').remove();
                        error.appendTo(parent);
                    }
                });
            }
        });
    </script>
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

    <?php if(auth()->check() && auth()->user()->role_id === 0): ?>
        <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['id' => 'callbackRequestModal','title' => 'Request Callback']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'callbackRequestModal','title' => 'Request Callback']); ?>
            <form id="callbackRequestForm" action="<?php echo e(route('customer.callback-request.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="flag" id="callback_flag" value="direct">
                <input type="hidden" name="purchased_plan_id" id="callback_purchased_plan_id" value="">
                <input type="hidden" name="claim_id" id="callback_claim_id" value="">

                <div class="mb-4">
                    <label for="callback_concern" class="block mb-2 text-sm font-bold text-slate-700">Enter Your Concern</label>
                    <textarea name="concern" id="callback_concern" rows="4" required class="w-full px-3 py-2 text-sm text-slate-700 placeholder-slate-400 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-fuchsia-300 focus:shadow-soft-primary-outline" placeholder="Briefly describe your concern..."></textarea>
                </div>

                <div class="flex justify-end pt-3 border-t border-gray-100">
                    <button type="button" onclick="window.closeGlobalModal('callbackRequestModal')" class="inline-block px-6 py-3 mr-2 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer leading-pro text-xs ease-soft-in tracking-tight-soft border-slate-300 hover:scale-102">
                        Cancel
                    </button>
                    <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-x-25 bg-150 tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102">
                        Submit
                    </button>
                </div>
            </form>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

        <script>
            function openCallbackModal(flag, purchasedPlanId = '', claimId = '') {
                document.getElementById('callback_flag').value = flag;
                document.getElementById('callback_purchased_plan_id').value = purchasedPlanId;
                document.getElementById('callback_claim_id').value = claimId;
                document.getElementById('callback_concern').value = '';
                window.openGlobalModal('callbackRequestModal');
            }

            $(document).ready(function() {
                $('#callbackRequestForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    const concernVal = $('#callback_concern').val().trim();
                    if (!concernVal) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Required Field',
                            text: 'Please enter your concern before submitting.',
                        });
                        return;
                    }

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            window.closeGlobalModal('callbackRequestModal');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Your callback request has been submitted successfully.',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Failed',
                                text: 'Unable to submit callback request. Please try again.',
                            });
                        }
                    });
                });
            });
        </script>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH /Users/Raif/Documents/GitHub/careergaurd/resources/views/layouts/app.blade.php ENDPATH**/ ?>