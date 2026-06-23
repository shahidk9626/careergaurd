<!-- Navbar -->
<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start"
    navbar-main navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="leading-normal text-sm">
                    <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']"
                    aria-current="page">
                    {{ ucfirst(request()->path()) }}
                </li>
            </ol>
            <h6 class="mb-0 font-bold capitalize">{{ ucfirst(request()->path()) }}</h6>
        </nav>

        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
                
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                @if(Auth::check() && Auth::user()->role_id === 0)
                <li class="flex items-center pr-4">
                    <button type="button" onclick="openCallbackModal('direct')" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-soft-md cursor-pointer leading-pro ease-soft-in bg-150 bg-x-25 bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 active:opacity-85">
                        Request Callback
                    </button>
                </li>
                @endif
                <li class="flex items-center">
                    <!-- <a href="{{ route('profile.edit') }}" class="block px-0 py-2 font-semibold transition-all ease-nav-brand text-sm text-slate-500"> -->
                        <i class="fa fa-user sm:mr-1"></i>
                        <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                    <!-- </a> -->
                </li>
                <li class="flex items-center pl-4 xl:hidden">
                    <a href="javascript:;" class="block p-0 transition-all ease-nav-brand text-sm text-slate-500"
                        sidenav-trigger>
                        <div class="w-4.5 overflow-hidden">
                            <i
                                class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                            <i
                                class="ease-soft mb-0.75 relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                            <i class="ease-soft relative block h-0.5 rounded-sm bg-slate-500 transition-all"></i>
                        </div>
                    </a>
                </li>
                <!-- <li class="flex items-center px-4">
                    <a href="javascript:;" class="p-0 transition-all text-sm ease-nav-brand text-slate-500">
                        <i fixed-plugin-button-nav class="cursor-pointer fa fa-cog"></i>
                    </a>
                </li> -->

                <!-- notifications -->
                <li class="relative flex items-center pr-2">
                    <p class="hidden transform-dropdown-show"></p>
                    <!-- <a href="javascript:;" class="block p-0 transition-all text-sm ease-nav-brand text-slate-500"
                        dropdown-trigger aria-expanded="false">
                        <i class="cursor-pointer fa fa-bell"></i>
                    </a> -->

                    <ul dropdown-menu
                        class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease-soft lg:shadow-soft-3xl duration-250 min-w-44 before:sm:right-7.5 before:text-5.5 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-2 before:left-auto before:top-0 before:z-50 before:inline-block before:font-normal before:text-white before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-0 lg:left-auto lg:mt-2 lg:block lg:cursor-pointer">
                        <li class="relative mb-2">
                            <a class="ease-soft py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors"
                                href="javascript:;">
                                <div class="flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets/img/team-2.jpg') }}"
                                            class="inline-flex items-center justify-center mr-4 text-white text-sm h-9 w-9 max-w-none rounded-xl" />
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 font-normal leading-normal text-sm">
                                            <span class="font-semibold">New message</span> from Laur
                                        </h6>
                                        <p class="mb-0 leading-tight text-xs text-slate-400">
                                            <i class="mr-1 fa fa-clock"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- end Navbar -->