@extends('layouts.auth')

@section('content')
    <div class="container sticky top-0 z-sticky">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 flex-0">
                <nav class="absolute top-0 left-0 right-0 z-30 flex flex-wrap items-center px-4 py-2 mx-6 my-4 shadow-soft-2xl rounded-blur bg-white/80 backdrop-blur-2xl backdrop-saturate-200 lg:flex-nowrap lg:justify-start">
                    <div class="flex items-center justify-between w-full p-0 pl-6 mx-auto flex-wrap-inherit">
                        <a class="py-2.375 text-sm mr-4 ml-4 whitespace-nowrap font-bold text-slate-700 lg:ml-0" href="/">
                            Soft UI Dashboard
                        </a>
                        <button navbar-trigger class="px-3 py-1 ml-2 leading-none transition-all bg-transparent border border-transparent border-solid rounded-lg shadow-none cursor-pointer text-lg ease-soft-in-out lg:hidden" type="button" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="inline-block mt-2 align-middle bg-center bg-no-repeat bg-cover w-6 h-6 bg-none">
                                <span bar1 class="w-5.5 rounded-xs relative my-0 mx-auto block h-px bg-gray-600 transition-all duration-300"></span>
                                <span bar2 class="w-5.5 rounded-xs mt-1.75 relative my-0 mx-auto block h-px bg-gray-600 transition-all duration-300"></span>
                                <span bar3 class="w-5.5 rounded-xs mt-1.75 relative my-0 mx-auto block h-px bg-gray-600 transition-all duration-300"></span>
                            </span>
                        </button>
                        <div navbar-menu class="items-center flex-grow overflow-hidden transition-all duration-500 ease-soft lg-max:max-h-0 basis-full lg:flex lg:basis-auto">
                            <ul class="flex flex-col pl-0 mx-auto mb-0 list-none lg:flex-row xl:ml-auto">
                                <li>
                                    <a class="flex items-center px-4 py-2 mr-2 font-normal transition-all lg-max:opacity-0 duration-250 ease-soft-in-out text-sm text-slate-700 lg:px-2" aria-current="page" href="{{ url('dashboard') }}">
                                        <i class="mr-1 fa fa-chart-pie opacity-60"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 mr-2 font-normal transition-all lg-max:opacity-0 duration-250 ease-soft-in-out text-sm text-slate-700 lg:px-2" href="{{ url('profile') }}">
                                        <i class="mr-1 fa fa-user opacity-60"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 mr-2 font-normal transition-all lg-max:opacity-0 duration-250 ease-soft-in-out text-sm text-slate-700 lg:px-2" href="{{ route('register') }}">
                                        <i class="mr-1 fas fa-user-circle opacity-60"></i> Sign Up
                                    </a>
                                </li>
                                <li>
                                    <a class="block px-4 py-2 mr-2 font-normal transition-all lg-max:opacity-0 duration-250 ease-soft-in-out text-sm text-slate-700 lg:px-2" href="{{ route('login') }}">
                                        <i class="mr-1 fas fa-key opacity-60"></i> Sign In
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <main class="mt-0 transition-all duration-200 ease-soft-in-out">
        <section>
            <div class="relative flex items-center p-0 overflow-hidden bg-center bg-cover min-h-75-screen">
                <div class="container z-10">
                    <div class="flex flex-wrap mt-0 -mx-3">
                        
                        <div class="flex flex-col w-full max-w-full px-3 mx-auto md:flex-0 shrink-0 md:w-6/12 lg:w-5/12 xl:w-4/12">
                            <div class="relative flex flex-col min-w-0 mt-32 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border">
                                
                                <div class="p-6 pb-0 mb-0 bg-transparent border-b-0 rounded-t-2xl">
                                    <h3 class="relative z-10 font-bold text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">
                                        Create New Password
                                    </h3>
                                    <p class="mb-0 text-sm text-slate-600">
                                        Please enter and confirm your secure new password below.
                                    </p>
                                </div>

                                <div class="flex-auto p-6">
                                    <form method="POST" action="{{ route('password.store') }}" role="form">
                                        @csrf
                                        
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700 uppercase tracking-wider">Email</label>
                                        <div class="mb-4">
                                            <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required readonly autocomplete="username"
                                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-50 bg-clip-padding px-3 py-2 font-normal text-gray-500 select-none cursor-not-allowed" />
                                            @error('email')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700 uppercase tracking-wider">New Password</label>
                                        <div class="mb-4">
                                            <input type="password" name="password" id="password" required autofocus autocomplete="new-password"
                                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                                placeholder="••••••••" />
                                            @error('password')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <label class="mb-2 ml-1 font-bold text-xs text-slate-700 uppercase tracking-wider">Confirm Password</label>
                                        <div class="mb-4">
                                            <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                                placeholder="••••••••" />
                                            @error('password_confirmation')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="text-center">
                                            <button type="submit"
                                                class="inline-block w-full px-6 py-3 mt-4 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-x-25 bg-150 leading-pro text-xs ease-soft-in tracking-tight-soft bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102 hover:shadow-soft-xs active:opacity-85">
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="w-full max-w-full px-3 lg:flex-0 shrink-0 md:w-6/12">
                            <div class="absolute top-0 hidden w-3/5 h-full -mr-32 overflow-hidden -skew-x-10 -right-40 rounded-bl-xl md:block">
                                <div class="absolute inset-x-0 top-0 z-0 h-full -ml-16 bg-cover skew-x-10" style="background-image: url('{{ asset('assets/img/curved-images/curved6.jpg') }}');"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-12">
        <div class="container">
            <div class="flex flex-wrap -mx-3">
                <div class="w-8/12 max-w-full px-3 mx-auto text-center flex-0">
                    <p class="mb-0 text-slate-400 text-sm">
                        Copyright © <script>document.write(new Date().getFullYear());</script> Soft by Creative Tim. Distributed by ❤️ ThemeWagon
                    </p>
                </div>
            </div>
        </div>
    </footer>
@endsection