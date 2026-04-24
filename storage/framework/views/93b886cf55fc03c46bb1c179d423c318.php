<aside
    class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent"
    id="sidenav-main">
    <div class="h-19.5">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden"
            sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="<?php echo e(route('dashboard')); ?>">
            <img src="<?php echo e(asset('assets/img/logo-ct.png')); ?>"
                class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
            <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Soft UI Dashboard</span>
        </a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">

            <?php $isDashboard = request()->routeIs('dashboard') || request()->is('/'); ?>
            <li class="w-full mt-0.5">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isDashboard ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                    href="<?php echo e(route('dashboard')); ?>">
                    <div
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isDashboard ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                        <i class="fas fa-tv <?php echo e($isDashboard ? 'text-white' : 'text-slate-700'); ?>"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Dashboard</span>
                </a>
            </li>

            <?php if(hasPermission('roles.view') || hasPermission('staff.view')): ?>
                <?php $isAccessActive = request()->is('*role*') || request()->is('*user*'); ?>
                <li class="w-full mt-0.5">
                    <a id="link-access-control"
                        class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isAccessActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                        onclick="toggleSubmenu('access-control')">
                        <div id="iconbox-access-control"
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isAccessActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                            <i id="icon-access-control"
                                class="fas fa-shield-alt <?php echo e($isAccessActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Access Control</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-access-control"></i>
                    </a>
                    <ul id="submenu-access-control"
                        class="<?php echo e($isAccessActive ? 'flex' : 'hidden'); ?> flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                        <?php if(hasPermission('roles.view')): ?>
                            <li class="w-full mt-1">
                                <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*role*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                    style="padding-left: 3.5rem;" href="<?php echo e(url('role-permissions')); ?>">
                                    Role Permissions
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(hasPermission('staff.view')): ?>
                            <li class="w-full mt-1">
                                <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*user*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                    style="padding-left: 3.5rem;" href="<?php echo e(url('user-permissions')); ?>">
                                    User Permissions
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(hasPermission('staff.view')): ?>
                <?php $isStaffActive = request()->is('*staff*'); ?>
                <li class="w-full mt-0.5">
                    <a id="link-staff-management"
                        class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isStaffActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                        onclick="toggleSubmenu('staff-management')">
                        <div id="iconbox-staff-management"
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isStaffActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                            <i id="icon-staff-management"
                                class="fas fa-users-cog <?php echo e($isStaffActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Staff Management</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-staff-management"></i>
                    </a>
                    <ul id="submenu-staff-management"
                        class="<?php echo e($isStaffActive ? 'flex' : 'hidden'); ?> flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->routeIs('staff.index') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('staff.index')); ?>">
                                All Staff
                            </a>
                        </li>
                        <?php if(hasPermission('staff.create')): ?>
                            <li class="w-full mt-1">
                                <a class="py-2 mx-4 text-sm block <?php echo e(request()->routeIs('staff.create') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                    style="padding-left: 3.5rem;" href="<?php echo e(route('staff.create')); ?>">
                                    Add Staff
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(hasPermission('staff.view')): ?>
                <?php $isServicesActive = request()->is('*service*'); ?>
                <li class="w-full mt-0.5">
                    <a id="link-service-management"
                        class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isServicesActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                        onclick="toggleSubmenu('service-management')">
                        <div id="iconbox-service-management"
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isServicesActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                            <i id="icon-service-management"
                                class="fas fa-concierge-bell <?php echo e($isServicesActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Services</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-service-management"></i>
                    </a>
                    <ul id="submenu-service-management"
                        class="<?php echo e($isServicesActive ? 'flex' : 'hidden'); ?> flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*categories*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.categories.index')); ?>">
                                Service Categories
                            </a>
                        </li>
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*resumes*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.resumes.index')); ?>">
                                Resume Templates
                            </a>
                        </li>
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*job-links*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.job-links.index')); ?>">
                                Job Links
                            </a>
                        </li>
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*questions*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.questions.index')); ?>">
                                Interview Q&A
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(hasPermission('staff.view')): ?>
                <?php $isPlansActive = request()->is('*plan*'); ?>
                <li class="w-full mt-0.5">
                    <a id="link-plans-hub"
                        class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isPlansActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                        onclick="toggleSubmenu('plans-hub')">
                        <div id="iconbox-plans-hub"
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isPlansActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                            <i id="icon-plans-hub"
                                class="fas fa-boxes <?php echo e($isPlansActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Plans</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-plans-hub"></i>
                    </a>
                    <ul id="submenu-plans-hub"
                        class="<?php echo e($isPlansActive ? 'flex' : 'hidden'); ?> flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('admin/plans*') && !request()->is('admin/plan-preview*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.plans.index')); ?>">
                                Manage Plans
                            </a>
                        </li>
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*plan-preview*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.plans.preview')); ?>">
                                Plan Preview
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php $isCustomersActive = request()->is('*customer*'); ?>
            <li class="w-full mt-0.5">
                <a id="link-customer-crm"
                    class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isCustomersActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                    onclick="toggleSubmenu('customer-crm')">
                    <div id="iconbox-customer-crm"
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isCustomersActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                        <i id="icon-customer-crm"
                            class="fas fa-user-friends <?php echo e($isCustomersActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Customers</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                        id="arrow-customer-crm"></i>
                </a>
                <ul id="submenu-customer-crm"
                    class="<?php echo e($isCustomersActive ? 'flex' : 'hidden'); ?> flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                    <?php if(auth()->user()->role && auth()->user()->role->name === 'customer'): ?>
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->routeIs('customer.dashboard') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('customer.dashboard')); ?>">
                                My Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(hasPermission('staff.view')): ?>
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->routeIs('admin.customers.index') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.customers.index')); ?>">
                                Recruited Customers
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(hasPermission('staff.create')): ?>
                        <li class="w-full mt-1">
                            <a class="py-2 mx-4 text-sm block <?php echo e(request()->routeIs('admin.customers.create') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                style="padding-left: 3.5rem;" href="<?php echo e(route('admin.customers.create')); ?>">
                                New Customer
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>

            <!-- <li class="w-full mt-0.5">
                <a id="link-reports" class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg text-slate-700 hover:bg-gray-50"
                    onclick="toggleSubmenu('reports')">
                    <div id="iconbox-reports" class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white shadow-soft-2xl bg-center stroke-0 text-center xl:p-2.5">
                        <i id="icon-reports" class="fas fa-chart-line text-slate-700"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Reports</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300" id="arrow-reports"></i>
                </a>
                <ul id="submenu-reports" class="hidden flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                    <li class="w-full mt-1">
                        <a class="py-2 mx-4 text-sm block text-slate-500 hover:text-slate-700" style="padding-left: 3.5rem;" href="javascript:;">
                            Sales Report
                        </a>
                    </li>
                    <li class="w-full mt-1">
                        <a class="py-2 mx-4 text-sm block text-slate-500 hover:text-slate-700" style="padding-left: 3.5rem;" href="javascript:;">
                            Staff Report
                        </a>
                    </li>
                </ul>
            </li> -->

            <li class="w-full mt-4">
                <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />
            </li>

            <?php $isSettingsActive = request()->routeIs('profile.edit') || request()->is('*profile*'); ?>
            <!-- <li class="w-full mt-0.5">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isSettingsActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                    href="<?php echo e(route('profile.edit')); ?>">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isSettingsActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                        <i class="fas fa-cog <?php echo e($isSettingsActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Settings</span>
                </a>
            </li> -->

            <li class="w-full mt-0.5">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors cursor-pointer rounded-lg text-slate-700 hover:bg-gray-50"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <div
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white shadow-soft-2xl bg-center stroke-0 text-center xl:p-2.5">
                            <i class="fas fa-sign-out-alt text-slate-700"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <script>
        function toggleSubmenu(id) {
            const submenu = document.getElementById('submenu-' + id);
            const arrow = document.getElementById('arrow-' + id);
            const link = document.getElementById('link-' + id);
            const iconbox = document.getElementById('iconbox-' + id);
            const icon = document.getElementById('icon-' + id);

            if (submenu.classList.contains('hidden')) {
                // Open Submenu
                submenu.classList.remove('hidden');
                submenu.classList.add('flex');
                if (arrow) arrow.style.transform = 'rotate(180deg)';

                // Force visually active state
                if (link) {
                    link.classList.add('bg-white', 'shadow-soft-xl', 'font-semibold');
                    link.classList.remove('hover:bg-gray-50');
                }
                if (iconbox) {
                    iconbox.classList.add('bg-gradient-to-tl', 'from-purple-700', 'to-pink-500');
                    iconbox.classList.remove('bg-white');
                }
                if (icon) {
                    icon.classList.add('text-white');
                    icon.classList.remove('text-slate-700');
                }
            } else {
                // Close Submenu
                submenu.classList.add('hidden');
                submenu.classList.remove('flex');
                if (arrow) arrow.style.transform = 'rotate(0deg)';

                // Remove visually active state
                if (link) {
                    link.classList.remove('bg-white', 'shadow-soft-xl', 'font-semibold');
                    link.classList.add('hover:bg-gray-50');
                }
                if (iconbox) {
                    iconbox.classList.remove('bg-gradient-to-tl', 'from-purple-700', 'to-pink-500');
                    iconbox.classList.add('bg-white');
                }
                if (icon) {
                    icon.classList.remove('text-white');
                    icon.classList.add('text-slate-700');
                }
            }
        }

        // Auto-open based on URL (just in case backend misses it)
        document.addEventListener('DOMContentLoaded', function () {
            const currentPath = window.location.pathname;

            const mapping = {
                'role': 'access-control',
                'user': 'access-control',
                'staff': 'staff-management',
                'service': 'service-management',
                'plan': 'plans-hub',
                'customer': 'customer-crm'
            };

            for (const [path, id] of Object.entries(mapping)) {
                if (currentPath.includes(path)) {
                    const submenu = document.getElementById('submenu-' + id);
                    if (submenu && submenu.classList.contains('hidden')) {
                        toggleSubmenu(id);
                    }
                }
            }
        });
    </script>
</aside><?php /**PATH /Users/Raif/Documents/GitHub/careergaurd/resources/views/partials/sidebar.blade.php ENDPATH**/ ?>