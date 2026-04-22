<?php $__env->startSection('content'); ?>
    <div class="mb-4 text-sm text-gray-600">
        <?php echo e(__('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.')); ?>

    </div>
    <?php if(session('status')): ?>
        <div class="mb-4 font-medium text-sm text-green-600">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input id="email" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm mt-2"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Email Password Reset Link</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u363423261/domains/careerguard.in/public_html/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>