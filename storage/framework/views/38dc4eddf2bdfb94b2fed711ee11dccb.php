<?php $__env->startSection('content'); ?>
    <!-- Navbar -->
    <nav
        class="absolute top-0 z-30 flex flex-wrap items-center justify-between w-full px-4 py-2 mt-6 mb-4 shadow-none lg:flex-nowrap lg:justify-start">
        <div class="container flex items-center justify-between py-0 flex-wrap-inherit">
            <a class="py-2.375 text-sm mr-4 ml-4 whitespace-nowrap font-bold text-white lg:ml-0" href="/">
                Soft UI Dashboard
            </a>
            <button navbar-trigger
                class="px-3 py-1 ml-2 leading-none transition-all bg-transparent border border-transparent border-solid rounded-lg shadow-none cursor-pointer text-lg ease-soft-in-out lg:hidden"
                type="button" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="inline-block mt-2 align-middle bg-center bg-no-repeat bg-cover w-6 h-6 bg-none">
                    <span bar1
                        class="w-5.5 rounded-xs duration-350 relative my-0 mx-auto block h-px bg-white transition-all"></span>
                    <span bar2
                        class="w-5.5 rounded-xs mt-1.75 duration-350 relative my-0 mx-auto block h-px bg-white transition-all"></span>
                    <span bar3
                        class="w-5.5 rounded-xs mt-1.75 duration-350 relative my-0 mx-auto block h-px bg-white transition-all"></span>
                </span>
            </button>
            <div navbar-menu
                class="items-center flex-grow transition-all ease-soft duration-350 lg-max:bg-white lg-max:max-h-0 lg-max:overflow-hidden basis-full rounded-xl lg:flex lg:basis-auto">
                <ul class="flex flex-col pl-0 mx-auto mb-0 list-none lg:flex-row xl:ml-auto">
                    <li>
                        <a class="flex items-center px-4 py-2 mr-2 font-normal text-white transition-all duration-250 lg-max:opacity-0 lg-max:text-slate-700 ease-soft-in-out text-sm lg:px-2 lg:hover:text-white/75"
                            aria-current="page" href="<?php echo e(url('dashboard')); ?>">
                            <i class="mr-1 text-white lg-max:text-slate-700 fa fa-chart-pie opacity-60"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="block px-4 py-2 mr-2 font-normal text-white transition-all duration-250 lg-max:opacity-0 lg-max:text-slate-700 ease-soft-in-out text-sm lg:px-2 lg:hover:text-white/75"
                            href="<?php echo e(url('profile')); ?>">
                            <i class="mr-1 text-white lg-max:text-slate-700 fa fa-user opacity-60"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a class="block px-4 py-2 mr-2 font-normal text-white transition-all duration-250 lg-max:opacity-0 lg-max:text-slate-700 ease-soft-in-out text-sm lg:px-2 lg:hover:text-white/75"
                            href="<?php echo e(route('register')); ?>">
                            <i class="mr-1 text-white lg-max:text-slate-700 fas fa-user-circle opacity-60"></i>
                            Sign Up
                        </a>
                    </li>
                    <li>
                        <a class="block px-4 py-2 mr-2 font-normal text-white transition-all duration-250 lg-max:opacity-0 lg-max:text-slate-700 ease-soft-in-out text-sm lg:px-2 lg:hover:text-white/75"
                            href="<?php echo e(route('login')); ?>">
                            <i class="mr-1 text-white lg-max:text-slate-700 fas fa-key opacity-60"></i>
                            Sign In
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="mt-0 transition-all duration-200 ease-soft-in-out">
        <section class="min-h-screen mb-32">
            <div class="relative flex items-start pt-12 pb-56 m-4 overflow-hidden bg-center bg-cover min-h-50-screen rounded-xl"
                style="
                background-image: url('<?php echo e(asset('assets/img/curved-images/curved14.jpg')); ?>');
              ">
                <span
                    class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-60"></span>
                <div class="container z-10">
                    <div class="flex flex-wrap justify-center -mx-3">
                        <div class="w-full max-w-full px-3 mx-auto mt-0 text-center lg:flex-0 shrink-0 lg:w-5/12">
                            <h1 class="mt-12 mb-2 text-white">Welcome!</h1>
                            <p class="text-white">
                                Use these awesome forms to login or create new account in your
                                project for free.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="flex flex-wrap -mx-3 -mt-48 md:-mt-56 lg:-mt-48">
                    <div class="w-full max-w-full px-3 mx-auto mt-0 md:flex-0 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                        <div
                            class="relative z-0 flex flex-col min-w-0 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                                <h3 class="relative z-10 font-bold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">Welcome!</h3>
                                <p class="mb-0">Enter your email and password to register</p>
                                
                                <?php if(session('status')): ?>
                                    <div class="relative w-full p-4 mb-4 text-white rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 mt-4">
                                        <?php echo e(session('status')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="flex-auto p-6">
                                <!-- Validation Errors -->
                                <?php if($errors->any()): ?>
                                    <div class="mb-4 p-3 rounded-lg bg-red-100 border border-red-200 text-red-600 text-sm">
                                        <ul class="list-disc pl-5">
                                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($error); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="<?php echo e(route('register')); ?>" role="form">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-4">
                                        <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                                            autofocus autocomplete="name"
                                            class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                                            placeholder="Name" aria-label="Name" aria-describedby="name-addon" />
                                    </div>
                                    <div class="mb-4">
                                        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                                            autocomplete="username"
                                            class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                                            placeholder="Email" aria-label="Email" aria-describedby="email-addon" />
                                    </div>
                                    <div class="mb-4">
                                        <input type="text" name="whatsapp_number" id="whatsapp_number"
                                            value="<?php echo e(old('whatsapp_number')); ?>" required
                                            class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                                            placeholder="WhatsApp Number" aria-label="WhatsApp"
                                            aria-describedby="whatsapp-addon" />
                                    </div>
                                    <div class="mb-4">
                                        <input type="text" name="referral_code" id="referral_code"
                                            value="<?php echo e(old('referral_code')); ?>"
                                            class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                                            placeholder="Referral Code (Optional)" aria-label="Referral"
                                            aria-describedby="referral-addon" />
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" name="password" id="password" required
                                            autocomplete="new-password"
                                            class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                                            placeholder="Password" aria-label="Password"
                                            aria-describedby="password-addon" />
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            required autocomplete="new-password"
                                            class="text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow"
                                            placeholder="Confirm Password" aria-label="Confirm Password"
                                            aria-describedby="password-confirmation-addon" />
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="inline-block w-full px-6 py-3 mt-6 mb-2 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:scale-102 hover:shadow-soft-xs leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 hover:border-slate-700 hover:bg-slate-700 hover:text-white">
                                            Sign up
                                        </button>
                                    </div>
                                    <p class="mt-4 mb-0 leading-normal text-sm">
                                        Already have an account?
                                        <a href="<?php echo e(route('login')); ?>" class="font-bold text-slate-700">Sign in</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="py-12">
            <div class="container">
                <div class="flex flex-wrap -mx-3">
                    <div class="flex-shrink-0 w-full max-w-full mx-auto mb-6 text-center lg:flex-0 lg:w-8/12">
                        <a href="javascript:;" target="_blank" class="mb-2 mr-4 text-slate-400 sm:mb-0 xl:mr-12">
                            Company
                        </a>
                        <a href="javascript:;" target="_blank" class="mb-2 mr-4 text-slate-400 sm:mb-0 xl:mr-12">
                            About Us
                        </a>
                        <a href="javascript:;" target="_blank" class="mb-2 mr-4 text-slate-400 sm:mb-0 xl:mr-12">
                            Team
                        </a>
                        <a href="javascript:;" target="_blank" class="mb-2 mr-4 text-slate-400 sm:mb-0 xl:mr-12">
                            Products
                        </a>
                        <a href="javascript:;" target="_blank" class="mb-2 mr-4 text-slate-400 sm:mb-0 xl:mr-12">
                            Blog
                        </a>
                        <a href="javascript:;" target="_blank" class="mb-2 mr-4 text-slate-400 sm:mb-0 xl:mr-12">
                            Pricing
                        </a>
                    </div>
                    <div class="flex-shrink-0 w-full max-w-full mx-auto mt-2 mb-6 text-center lg:flex-0 lg:w-8/12">
                        <a href="javascript:;" target="_blank" class="mr-6 text-slate-400">
                            <span class="text-lg fab fa-dribbble"></span>
                        </a>
                        <a href="javascript:;" target="_blank" class="mr-6 text-slate-400">
                            <span class="text-lg fab fa-twitter"></span>
                        </a>
                        <a href="javascript:;" target="_blank" class="mr-6 text-slate-400">
                            <span class="text-lg fab fa-instagram"></span>
                        </a>
                        <a href="javascript:;" target="_blank" class="mr-6 text-slate-400">
                            <span class="text-lg fab fa-pinterest"></span>
                        </a>
                        <a href="javascript:;" target="_blank" class="mr-6 text-slate-400">
                            <span class="text-lg fab fa-github"></span>
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-8/12 max-w-full px-3 mx-auto mt-1 text-center flex-0">
                        <p class="mb-0 text-slate-400">
                            Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            Soft by Creative Tim.
                            <span class="w-full"> Distributed by ❤️ ThemeWagon </span>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/Raif/Documents/GitHub/careergaurd/resources/views/auth/register.blade.php ENDPATH**/ ?>