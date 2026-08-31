<!doctype html>
<html class="no-js" lang="en">

<head>
    <title>@yield('title', 'CareerGuard – Career Support & Membership Platform')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="ThemeZaa">
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="description"
        content="@yield('meta_description', 'CareerGuard is a membership-based career support platform providing job resources, resume templates, interview preparation, business opportunities, and eligibility-based financial assistance support for working professionals.')">
    
    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{ asset('frontend/images/fevicon-new.png') }}">
    
    <!-- google fonts preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- style sheets and font icons -->
    <link rel="stylesheet" href="{{ asset('frontend/css/vendors.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/icon.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/demos/application/application.css') }}" />
    @stack('styles')
</head>

<body data-mobile-nav-style="classic" class="custom-cursor">
    <!-- start cursor -->
    <div class="cursor-page-inner">
        <div class="circle-cursor circle-cursor-inner"></div>
        <div class="circle-cursor circle-cursor-outer"></div>
    </div>
    <!-- end cursor -->

    <!-- start header -->
    <header>
        <!-- start navigation -->
        <nav class="navbar navbar-expand-lg header-light bg-transparent always-fixed responsive-sticky fixed-top"
            data-header-hover="light">
            <div class="container-fluid">
                <div class="col-auto me-auto">
                    <a class="navbar-brand" href="{{ route('frontend.index') }}">
                        <img src="{{ asset('frontend/images/careerguard-logo.png') }}" data-at2x="{{ asset('frontend/images/careerguard-logo.png') }}" alt="CareerGuard"
                            class="default-logo">
                        <img src="{{ asset('frontend/images/careerguard-logo-black.png') }}" data-at2x="{{ asset('frontend/images/careerguard-logo-black.png') }}"
                            alt="CareerGuard" class="alt-logo">
                        <img src="{{ asset('frontend/images/careerguard-logo-black-mobile.png') }}"
                            data-at2x="{{ asset('frontend/images/careerguard-logo-black-mobile.png') }}" alt="CareerGuard" class="mobile-logo">
                    </a>
                </div>
                <div class="col-auto menu-order position-static">
                    <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                        <span class="navbar-toggler-line"></span>
                        <span class="navbar-toggler-line"></span>
                        <span class="navbar-toggler-line"></span>
                        <span class="navbar-toggler-line"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a href="{{ route('frontend.index') }}" class="nav-link {{ request()->routeIs('frontend.index') ? 'active' : '' }}">Home</a></li>
                            <li class="nav-item"><a href="{{ route('frontend.about') }}" class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}">About</a></li>
                            <li class="nav-item"><a href="{{ route('frontend.features') }}" class="nav-link {{ request()->routeIs('frontend.features') ? 'active' : '' }}">Features</a></li>
                            <li class="nav-item"><a href="{{ route('frontend.how-it-works') }}" class="nav-link {{ request()->routeIs('frontend.how-it-works') ? 'active' : '' }}">How it works</a></li>
                            <li class="nav-item"><a href="{{ route('frontend.reviews') }}" class="nav-link {{ request()->routeIs('frontend.reviews') ? 'active' : '' }}">Reviews</a></li>
                            <li class="nav-item"><a href="{{ route('frontend.subscribe') }}" class="nav-link {{ request()->routeIs('frontend.subscribe') ? 'active' : '' }}">Subscribe</a></li>
                            <li class="nav-item"><a href="{{ route('frontend.contact-us') }}" class="nav-link {{ request()->routeIs('frontend.contact-us') ? 'active' : '' }}">Contact us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto col-auto xs-ps-0">
                    <div class="header-icon">
                        <div class="header-button">
                            <a href="https://wa.me/919611956627" target="_blank" rel="noopener noreferrer"
                                class="btn btn-small btn-rounded with-rounded btn-box-shadow btn-dark-gray text-uppercase-inherit">Chat
                                now<span class="bg-licorice-blue text-white"><i
                                        class="feather icon-feather-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end navigation -->
    </header>
    <!-- end header -->

    @yield('content')

    <!-- start footer -->
    <footer class="footer-dark bg-dark-gray pb-0 cover-background background-position-left-top"
        style="background-image: url('{{ asset('frontend/images/demo-application-footer-bg.jpg') }}')">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-5 row-cols-md-3 justify-content-center border-bottom border-color-transparent-white-light pb-5 sm-pb-35px">
                <!-- start footer column - Brand & Description -->
                <div class="col-lg-3 col-md-4 col-sm-6 text-center text-sm-start md-mb-30px last-paragraph-no-margin">
                    <a href="{{ route('frontend.index') }}" class="footer-logo mb-15px d-inline-block">
                        <img src="{{ asset('frontend/images/careerguard-logo.png') }}" data-at2x="{{ asset('frontend/images/careerguard-logo.png') }}" alt="CareerGuard" class="default-logo">
                    </a>
                    <p class="w-90 sm-w-100 fs-14 lh-24 text-medium-gray mb-15px">Protecting Indian professionals during career transitions with membership support, job resources, and financial backing.</p>
                    <div class="d-flex align-items-center justify-content-center justify-content-sm-start">
                        <div class="me-10px">
                            <i class="fa-solid fa-shield-halved text-base-color fs-24"></i>
                        </div>
                        <div class="text-start">
                            <div class="text-golden-yellow fs-12">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <span class="d-block fs-14 text-white lh-20 fw-500">Trusted by members</span>
                        </div>
                    </div>
                </div>
                <!-- end footer column -->

                <!-- start footer column - Quick Links -->
                <div class="col-lg-2 col-md-3 col-sm-6 md-mb-30px">
                    <span class="d-block text-white fw-600 mb-10px">Quick Links</span>
                    <ul>
                        <li><a href="{{ route('frontend.index') }}">Home</a></li>
                        <li><a href="{{ route('frontend.about') }}">About</a></li>
                        <li><a href="{{ route('frontend.features') }}">Features</a></li>
                        <li><a href="{{ route('frontend.how-it-works') }}">How it works</a></li>
                        <li><a href="{{ route('frontend.reviews') }}">Reviews</a></li>
                        <li><a href="{{ route('frontend.contact-us') }}">Contact us</a></li>
                    </ul>
                </div>
                <!-- end footer column -->

                <!-- start footer column - Legal -->
                <div class="col-lg-2 col-md-3 col-sm-6 md-mb-30px">
                    <span class="d-block text-white fw-600 mb-10px">Legal</span>
                    <ul>
                        <li><a href="{{ route('frontend.terms') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('frontend.privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('frontend.refund-policy') }}">Refund Policy</a></li>
                    </ul>
                </div>
                <!-- end footer column -->

                <!-- start footer column - Contact -->
                <div class="col-lg-3 col-md-12 col-sm-6 text-md-center text-lg-start">
                    <span class="d-block text-white fw-600 mb-10px">Get in touch</span>
                    <div class="mb-10px">
                        <span class="d-block fs-14">Email us</span>
                        <a href="mailto:support@careerguard.in" target="_blank" rel="noopener noreferrer"
                            class="text-white fw-600 d-inline-block">support@careerguard.in</a>
                    </div>
                    <div class="mb-10px">
                        <span class="d-block fs-14">WhatsApp</span>
                        <a href="https://wa.me/919611956627" target="_blank" rel="noopener noreferrer"
                            class="text-white fw-600 d-inline-block"><i class="fa-brands fa-whatsapp me-5px"></i>+91 8123190776</a>
                    </div>
                    <div class="mb-10px">
                        <span class="d-block fs-14">Website</span>
                        <a href="https://www.careerguard.in" target="_blank" rel="noopener noreferrer"
                            class="text-white fw-600 d-inline-block">www.careerguard.in</a>
                    </div>
                    <div class="mb-15px">
                        <span class="d-block fs-14">Address</span>
                        <span class="text-white fw-600 d-inline-block">#73, 1st floor, Sumatha Wood Layout, Bhogadi - Gadige main road Mysuru - 570026</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-lg-start justify-content-md-center">
                        <i class="line-icon-Handshake align-middle icon-medium me-10px"></i>
                        <span class="fs-14">Protecting your privacy</span>
                    </div>
                </div>
                <!-- end footer column -->
            </div>

            <div class="row justify-content-center align-items-center pt-5 md-pt-30px">
                <div class="col-12">
                    <div class="divider-style-03 divider-style-03-01 border-color-transparent-white-light"></div>
                </div>
                <div class="col-xl-10 col-lg-11 pt-30px pb-30px fs-14 lh-26 last-paragraph-no-margin text-center">
                    <p class="mb-0">CareerGuard, developed by <a href="https://dixitglobaltech.com" target="_blank"
                            rel="noopener noreferrer"><strong class="text-white fw-600">Dixit Global Tech IT Solutions
                                Private Limited</strong></a>, is an innovative career support and financial preparedness
                        platform designed for India's growing workforce.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    <!-- start scroll progress -->
    <div class="scroll-progress d-none d-xxl-block">
        <a href="#" class="scroll-top" aria-label="scroll">
            <span class="scroll-text">Scroll</span><span class="scroll-line"><span class="scroll-point"></span></span>
        </a>
    </div>
    <!-- end scroll progress -->

    <!-- javascript libraries -->
    <script type="text/javascript" src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/vendors.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
