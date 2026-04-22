<?php $__env->startSection('content'); ?>
    <div class="mb-4 text-sm text-gray-600">
        <?php echo e(__('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.')); ?>

    </div>

    <?php if(session('status') == 'verification-link-sent'): ?>
        <div class="mb-4 font-medium text-sm text-green-600">
            <?php echo e(__('A new verification link has been sent to the email address you provided during registration.')); ?>

        </div>
    <?php endif; ?>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="<?php echo e(route('verification.send')); ?>">
            <?php echo csrf_field(); ?>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                <?php echo e(__('Resend Verification Email')); ?>

            </button>
        </form>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <?php echo e(__('Log Out')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u363423261/domains/careerguard.in/public_html/resources/views/auth/verify-email.blade.php ENDPATH**/ ?>