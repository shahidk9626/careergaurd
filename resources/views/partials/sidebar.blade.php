<!-- sidenav  -->
<aside
    class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent"
    id="sidenav-main">
    <div class="h-19.5">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden"
            sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logo-ct.png') }}"
                class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
            <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Soft UI Dashboard</span>
        </a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
            <!-- Dashboard -->
            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ request()->routeIs('dashboard') ? 'shadow-soft-xl rounded-lg bg-white font-semibold text-slate-700' : 'text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors' }} flex items-center whitespace-nowrap px-4 transition-colors"
                    href="{{ route('dashboard') }}">
                    <div
                        class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <i
                            class="fas fa-tv {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-700' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Dashboard</span>
                </a>
            </li>

            <!-- Access Control (Accordion) -->
            @if(hasPermission('roles.view') || hasPermission('staff.view'))
                <li class="mt-0.5 w-full">
                    <a class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
                        onclick="toggleSubmenu('access-control')">
                        <div
                            class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                            <i class="fas fa-shield-alt text-slate-700"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Access Control</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-access-control"></i>
                    </a>
                    <ul id="submenu-access-control"
                        class="hidden flex-col pl-10 mb-0 list-none transition-all duration-300">
                        @if(hasPermission('roles.view'))
                            <li class="mt-1 w-full">
                                <a class="py-2 text-xs {{ request()->is('role-permissions*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                    href="{{ url('role-permissions') }}">
                                    Role Permissions
                                </a>
                            </li>
                        @endif
                        @if(hasPermission('staff.view'))
                            <li class="mt-1 w-full">
                                <a class="py-2 text-xs {{ request()->is('user-permissions*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                    href="{{ url('user-permissions') }}">
                                    User Permissions
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Staff Management (Accordion) -->
            @if(hasPermission('staff.view'))
                <li class="mt-0.5 w-full">
                    <a class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
                        onclick="toggleSubmenu('staff-management')">
                        <div
                            class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                            <i class="fas fa-users-cog text-slate-700"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Staff Management</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-staff-management"></i>
                    </a>
                    <ul id="submenu-staff-management"
                        class="hidden flex-col pl-10 mb-0 list-none transition-all duration-300">
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->routeIs('staff.index') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('staff.index') }}">
                                All Staff
                            </a>
                        </li>
                        @if(hasPermission('staff.create'))
                            <li class="mt-1 w-full">
                                <a class="py-2 text-xs {{ request()->routeIs('staff.create') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                    href="{{ route('staff.create') }}">
                                    Add Staff
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Service Management (Accordion) -->
            @if(hasPermission('staff.view'))
                <li class="mt-0.5 w-full">
                    <a class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
                        onclick="toggleSubmenu('service-management')">
                        <div
                            class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                            <i class="fas fa-concierge-bell text-slate-700"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Services</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-service-management"></i>
                    </a>
                    <ul id="submenu-service-management"
                        class="hidden flex-col pl-10 mb-0 list-none transition-all duration-300">
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->is('admin/services/categories*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.services.categories.index') }}">
                                Service Categories
                            </a>
                        </li>
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->is('admin/services/resumes*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.services.resumes.index') }}">
                                Resume Templates
                            </a>
                        </li>
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->is('admin/services/job-links*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.services.job-links.index') }}">
                                Job Links
                            </a>
                        </li>
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->is('admin/services/questions*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.services.questions.index') }}">
                                Interview Q&A
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Plans Hub (Accordion) -->
                <li class="mt-0.5 w-full">
                    <a class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
                        onclick="toggleSubmenu('plans-hub')">
                        <div
                            class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                            <i class="fas fa-boxes text-slate-700"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Plans</span>
                        <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                            id="arrow-plans-hub"></i>
                    </a>
                    <ul id="submenu-plans-hub" class="hidden flex-col pl-10 mb-0 list-none transition-all duration-300">
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->is('admin/plans*') && !request()->is('admin/plan-preview*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.plans.index') }}">
                                Manage Plans
                            </a>
                        </li>
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->is('admin/plan-preview*') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.plans.preview') }}">
                                Plan Preview
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <!-- Customer CRM (Accordion) -->
            <li class="mt-0.5 w-full">
                <a class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
                    onclick="toggleSubmenu('customer-crm')">
                    <div
                        class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <i class="fas fa-user-friends text-slate-700"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Customers</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                        id="arrow-customer-crm"></i>
                </a>
                <ul id="submenu-customer-crm" class="hidden flex-col pl-10 mb-0 list-none transition-all duration-300">
                    @if(auth()->user()->role && auth()->user()->role->name === 'customer')
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->routeIs('customer.dashboard') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('customer.dashboard') }}">
                                My Dashboard
                            </a>
                        </li>
                    @endif
                    @if(hasPermission('staff.view'))
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->routeIs('admin.customers.index') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.customers.index') }}">
                                Recruited Customers
                            </a>
                        </li>
                    @endif
                    @if(hasPermission('staff.create'))
                        <li class="mt-1 w-full">
                            <a class="py-2 text-xs {{ request()->routeIs('admin.customers.create') ? 'font-bold text-slate-700' : 'text-slate-500 hover:text-slate-700' }} block"
                                href="{{ route('admin.customers.create') }}">
                                New Customer
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            <!-- Reports (Accordion Dummy) -->
            <li class="mt-0.5 w-full">
                <a class="py-2.7 cursor-pointer text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors"
                    onclick="toggleSubmenu('reports')">
                    <div
                        class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <i class="fas fa-chart-line text-slate-700"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Reports</span>
                    <i class="fas fa-chevron-down ml-auto text-xs transition-transform duration-300"
                        id="arrow-reports"></i>
                </a>
                <ul id="submenu-reports" class="hidden flex-col pl-10 mb-0 list-none transition-all duration-300">
                    <li class="mt-1 w-full">
                        <a class="py-2 text-xs text-slate-500 hover:text-slate-700 block" href="javascript:;">Sales
                            Report</a>
                    </li>
                    <li class="mt-1 w-full">
                        <a class="py-2 text-xs text-slate-500 hover:text-slate-700 block" href="javascript:;">Staff
                            Report</a>
                    </li>
                </ul>
            </li>

            <li class="w-full mt-4">
                <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 {{ request()->routeIs('profile.edit') ? 'shadow-soft-xl rounded-lg bg-white font-semibold text-slate-700' : 'text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors' }} flex items-center whitespace-nowrap px-4 transition-colors"
                    href="{{ route('profile.edit') }}">
                    <div
                        class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
                        <i
                            class="fas fa-cog {{ request()->routeIs('profile.edit') ? 'text-slate-700' : 'text-slate-700' }}"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Settings</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors cursor-pointer"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <div
                            class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5">
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

            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                submenu.classList.add('flex');
                arrow.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                submenu.classList.remove('flex');
                arrow.classList.remove('rotate-180');
            }
        }

        // Auto-open submenu based on current URL
        document.addEventListener('DOMContentLoaded', function () {
            const currentPath = window.location.pathname;

            const mapping = {
                'role-permissions': 'access-control',
                'user-permissions': 'access-control',
                'staff': 'staff-management',
                'services': 'service-management',
                'plans': 'plans-hub',
                'plan-preview': 'plans-hub',
                'customers': 'customer-crm'
            };

            for (const [path, id] of Object.entries(mapping)) {
                if (currentPath.includes(path)) {
                    const submenu = document.getElementById('submenu-' + id);
                    const arrow = document.getElementById('arrow-' + id);
                    if (submenu) {
                        submenu.classList.remove('hidden');
                        submenu.classList.add('flex');
                    }
                    if (arrow) arrow.classList.add('rotate-180');
                }
            }
        });
    </script>
</aside>
<!-- end sidenav -->