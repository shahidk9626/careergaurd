<aside
    class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent"
    id="sidenav-main">
    <div class="h-19.5">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden"
            sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="<?php echo e(route('dashboard')); ?>">
    <img src="https://test.careerguard.in/images/careerguard-logo-black.png"
         class="inline w-auto transition-all duration-200 ease-nav-brand h-12" alt="CareerGuard Logo" />
</a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">

            <?php if(auth()->user()->role_id !== 0): ?>
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
            <?php else: ?>
                <!-- Customer Plan Preview -->
                <li class="w-full mt-0.5">
                    <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e(request()->routeIs('customer.plan-preview') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                        href="<?php echo e(route('customer.plan-preview')); ?>">
                        <div
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e(request()->routeIs('customer.plan-preview') ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                            <i class="fas fa-boxes <?php echo e(request()->routeIs('customer.plan-preview') ? 'text-white' : 'text-slate-700'); ?>"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Membership Preview</span>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php if(auth()->user()->role_id !== 0): ?>
                <?php if(hasPermission('roles.view') || hasPermission('user-permissions.view')): ?>
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
                                 <li class="w-full mt-1">
                                    <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*role*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                        style="padding-left: 3.5rem;" href="<?php echo e(url('roles')); ?>">
                                        Role
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(hasPermission('user-permissions.view')): ?>
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
            <?php endif; ?>

            <?php if(auth()->user()->role_id !== 0): ?>
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
            <?php endif; ?>

            <?php if(auth()->user()->role_id !== 0): ?>
                <?php 
                    $hasCustomerPerm = hasPermission('customers.view') || hasPermission('customers.create') || 
                                     hasPermission('customers.edit') || hasPermission('customers.delete') || 
                                     hasPermission('customers.verify') || hasPermission('customers.view_detail');
                    $isCustomersActive = request()->is('*customer*'); 
                ?>
                <?php if($hasCustomerPerm): ?>
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
                        <?php if(hasPermission('customers.view')): ?>
                            <li class="w-full mt-1">
                                <a class="py-2 mx-4 text-sm block <?php echo e(request()->routeIs('admin.customers.index') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                    style="padding-left: 3.5rem;" href="<?php echo e(route('admin.customers.index')); ?>">
                                    Recruited Customers
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(hasPermission('customers.create')): ?>
                            <li class="w-full mt-1">
                                <a class="py-2 mx-4 text-sm block <?php echo e(request()->routeIs('admin.customers.create') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                    style="padding-left: 3.5rem;" href="<?php echo e(route('admin.customers.create')); ?>">
                                    New Customer
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(auth()->user()->role_id !== 0): ?>
                <?php if(hasPermission('service-categories.view') || hasPermission('resumes.view') || hasPermission('job-links.view') || hasPermission('questions.view')): ?>
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
                            <?php if(hasPermission('service-categories.view')): ?>
                                <li class="w-full mt-1">
                                    <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*categories*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                        style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.categories.index')); ?>">
                                        Service Categories
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(hasPermission('resumes.view')): ?>
                                <li class="w-full mt-1">
                                    <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*resumes*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                        style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.resumes.index')); ?>">
                                        Resume Templates
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(hasPermission('job-links.view')): ?>
                                <li class="w-full mt-1">
                                    <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*job-links*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                        style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.job-links.index')); ?>">
                                        Job Links
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(hasPermission('questions.view')): ?>
                                <li class="w-full mt-1">
                                    <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*questions*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                        style="padding-left: 3.5rem;" href="<?php echo e(route('admin.services.questions.index')); ?>">
                                        Interview Q&A
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(auth()->user()->role_id !== 0): ?>
                <?php if(hasPermission('plans.view')): ?>
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
                            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Membership</span>
                            <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                                id="arrow-plans-hub"></i>
                        </a>
                        <ul id="submenu-plans-hub"
                            class="<?php echo e($isPlansActive ? 'flex' : 'hidden'); ?> flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                            <li class="w-full mt-1">
                                <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('admin/plans*') && !request()->is('admin/plan-preview*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                    style="padding-left: 3.5rem;" href="<?php echo e(route('admin.plans.index')); ?>">
                                    Manage Memberships
                                </a>
                            </li>
                            <li class="w-full mt-1">
                                <a class="py-2 mx-4 text-sm block <?php echo e(request()->is('*plan-preview*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                                    style="padding-left: 3.5rem;" href="<?php echo e(route('admin.plans.preview')); ?>">
                                    Membership Preview
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(auth()->user()->verification_status === 'verified' || auth()->user()->role_id !== 0): ?>
            <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60 text-slate-500">My Memberships & Support</h6>
            </li>

            <!-- Purchased Plans -->
            <?php 
                $hasPurchasedPlansPerm = hasPermission('purchased-plans.view');
                $isPurchasedPlansActive = request()->routeIs('customer.purchased-plans') || request()->routeIs('admin.purchased-plans');
                $purchasedPlansRoute = auth()->user()->role_id === 0 ? route('customer.purchased-plans') : route('admin.purchased-plans');
            ?>
            <?php if(auth()->user()->role_id === 0 || $hasPurchasedPlansPerm): ?>
                <li class="w-full mt-0.5">
                    <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isPurchasedPlansActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                        href="<?php echo e($purchasedPlansRoute); ?>">
                        <div
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isPurchasedPlansActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                            <i class="fas fa-receipt <?php echo e($isPurchasedPlansActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Purchased Memberships</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(auth()->user()->role_id === 0): ?>
                <?php
                    $hasResume = auth()->user()->hasBenefitAccess('resume');
                    $hasJobLink = auth()->user()->hasBenefitAccess('job-link');
                    $hasQuestion = auth()->user()->hasBenefitAccess('question');
                ?>
                
                <?php if($hasResume || $hasJobLink || $hasQuestion): ?>
                    <li class="w-full mt-4">
                        <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase opacity-60 text-slate-500">My Benefits</h6>
                    </li>
                    
                    <?php if($hasResume): ?>
                        <?php $isResumeActive = request()->routeIs('customer.resume-templates') || request()->is('*resume-templates*'); ?>
                        <li class="w-full mt-0.5">
                            <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isResumeActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                                href="<?php echo e(route('customer.resume-templates')); ?>">
                                <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isResumeActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                                    <i class="fas fa-file-invoice <?php echo e($isResumeActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Resume Templates</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if($hasJobLink): ?>
                        <?php $isJobLinkActive = request()->routeIs('customer.job-links') || request()->is('*job-links*'); ?>
                        <li class="w-full mt-0.5">
                            <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isJobLinkActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                                href="<?php echo e(route('customer.job-links')); ?>">
                                <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isJobLinkActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                                    <i class="fas fa-briefcase <?php echo e($isJobLinkActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Job Opportunities</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if($hasQuestion): ?>
                        <?php $isQuestionActive = request()->routeIs('customer.interview-questions') || request()->routeIs('customer.interview-questions.category') || request()->is('*interview-questions*'); ?>
                        <li class="w-full mt-0.5">
                            <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isQuestionActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                                href="<?php echo e(route('customer.interview-questions')); ?>">
                                <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isQuestionActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                                    <i class="fas fa-graduation-cap <?php echo e($isQuestionActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                                </div>
                                <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Interview Q&As</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Claim Parent Menu -->
            <?php 
                $hasClaimsPerm = hasPermission('claims.view') || hasPermission('claims.approve') || 
                                hasPermission('claims.reject') || hasPermission('claims.view_detail');
                $isClaimManagementActive = request()->routeIs('customer.claim-management') || request()->routeIs('admin.claim-management');
                $isClaimRequestsActive = request()->routeIs('admin.claim.requests');
                $isClaimParentActive = $isClaimManagementActive || $isClaimRequestsActive;
                
                $claimManagementRoute = auth()->user()->role_id === 0 ? route('customer.claim-management') : route('admin.claim-management');
            ?>
            <?php if(auth()->user()->role_id === 0 || $hasClaimsPerm || hasPermission('purchased-plans.view')): ?>
                <a id="link-claim-group"
                    class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isClaimParentActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                    onclick="toggleSubmenu('claim-group')">
                    <div id="iconbox-claim-group"
                        class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isClaimParentActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                        <i id="icon-claim-group"
                            class="fas fa-hand-holding-usd <?php echo e($isClaimParentActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Support</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                        id="arrow-claim-group" style="<?php echo e($isClaimParentActive ? 'transform: rotate(180deg);' : ''); ?>"></i>
                </a>
                <ul id="submenu-claim-group"
                    class="<?php echo e($isClaimParentActive ? 'flex' : 'hidden'); ?> flex-col pl-0 mt-1 mb-0 list-none transition-all duration-300">
                    
                    <?php if(auth()->user()->role_id === 0 || hasPermission('purchased-plans.view')): ?>
                    <li class="w-full mt-1">
                        <a class="py-2 mx-4 text-sm block <?php echo e($isClaimManagementActive ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                            style="padding-left: 3.5rem;" href="<?php echo e($claimManagementRoute); ?>">
                            Mature Support Requests
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(auth()->user()->role_id !== 0 && hasPermission('claims.view')): ?>
                    <li class="w-full mt-1">
                        <a class="py-2 mx-4 text-sm block <?php echo e($isClaimRequestsActive ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700'); ?>"
                            style="padding-left: 3.5rem;" href="<?php echo e(route('admin.claim.requests')); ?>">
                            Support Requests
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>
            </li>
            <?php endif; ?>

            <?php if(auth()->user()->role_id !== 0): ?>
                <?php if(hasPermission('request-callback.view')): ?>
                    <?php $isCallbackActive = request()->routeIs('admin.request-callback.index') || request()->is('*request-callback*'); ?>
                    <li class="w-full mt-0.5">
                        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isCallbackActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                            href="<?php echo e(route('admin.request-callback.index')); ?>">
                            <div
                                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isCallbackActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                                <i class="fas fa-phone-alt <?php echo e($isCallbackActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                            </div>
                            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Request Callback</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(auth()->user()->role_id !== 0): ?>
                <?php if(hasPermission('profile-update-requests.view')): ?>
                    <?php $isProfileRequestsActive = request()->routeIs('admin.profile-update-requests.index') || request()->is('*profile-update-requests*'); ?>
                    <!-- <li class="w-full mt-0.5">
                        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isProfileRequestsActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                            href="<?php echo e(route('admin.profile-update-requests.index')); ?>">
                            <div
                                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isProfileRequestsActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                                <i class="fas fa-user-edit <?php echo e($isProfileRequestsActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                            </div>
                            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Profile Update Requests</span>
                        </a>
                    </li> -->
                <?php endif; ?>
            <?php endif; ?>

            <?php if(auth()->user()->role_id !== 0): ?>
                <?php if(hasPermission('staff-commission.view')): ?>
                    <?php $isCommissionActive = request()->routeIs('admin.staff-commission.index') || request()->is('*staff-commission*'); ?>
                    <li class="w-full mt-0.5">
                        <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isCommissionActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                            href="<?php echo e(route('admin.staff-commission.index')); ?>">
                            <div
                                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isCommissionActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                                <i class="fas fa-percentage <?php echo e($isCommissionActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                            </div>
                            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Staff Commission</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(auth()->user()->role_id === 0): ?>
                <?php $isProfileActive = request()->routeIs('customer.profile') || request()->routeIs('customer.registration') || request()->routeIs('customer.profile.check'); ?>
                <li class="w-full mt-0.5">
                    <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors rounded-lg <?php echo e($isProfileActive ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'text-slate-700 hover:bg-gray-50'); ?>"
                        href="<?php echo e(route('customer.profile.check')); ?>">
                        <div
                            class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 <?php echo e($isProfileActive ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl' : 'bg-white shadow-soft-2xl'); ?>">
                            <i class="fas fa-user-circle <?php echo e($isProfileActive ? 'text-white' : 'text-slate-700'); ?>"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Profile</span>
                    </a>
                </li>
            <?php endif; ?>

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
                'customer': 'customer-crm',
                'claim': 'claim-group'
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