@extends('frontend.layouts.app')

@section('title', 'About Us – CareerGuard Support Platform')
@section('meta_description', 'Learn about CareerGuard mission to build a reliable support platform that helps employees stay financially and professionally prepared during unexpected career challenges.')

@section('content')
    <!-- start page title -->
    <section
        class="page-title-big-typography ipad-top-space-margin cover-background background-position-center-bottom position-relative half-section sm-py-0"
        style="background-image: url('{{ asset('frontend/images/demo-application-page-title-bg.jpg') }}')">
        <div id="particles-style-01" class="h-100 position-absolute left-0px top-0 w-100" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 12,"density": {"enable": true,"value_area": 2000}},"color": {"value": ["#8f76f5", "#a65cef", "#c74ad2", "#e754a4", "#ff6472"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"line_linked":{"enable":false,"distance":0,"color":"#ffffff","opacity":0.4,"width":1},"move": {"enable": true,"speed":1,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'>
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center extra-very-small-screen">
                <div class="col-lg-6 col-md-8 position-relative text-center page-title-extra-large"
                    data-anime='{ "el": "childs", "opacity": [0, 1], "rotateY": [-90, 0], "rotateZ": [-10, 0], "translateY": [80, 0], "translateZ": [50, 0], "staggervalue": 200, "duration": 900, "easing": "easeOutCirc" }'>
                    <h2 class="mb-10px fw-500">Application for every career lover</h2>
                    <h1 class="mb-0 text-dark-gray fw-700 ls-minus-2px">About app</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- end page title -->

    <!-- start section -->
    <section class="p-0 overflow-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-7 position-relative text-center md-mb-30px"
                    data-anime='{ "effect": "slide", "color": "#ffffff", "direction":"lr", "easing": "easeOutQuad", "delay":50}'>
                    <figure>
                        <div class="atropos" data-atropos>
                            <div class="atropos-scale">
                                <div class="atropos-rotate">
                                    <div class="atropos-inner">
                                        <img data-atropos-offset="5" src="{{ asset('frontend/images/cg-about.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-5 text-center text-lg-start ps-40px lg-ps-15px"
                    data-anime='{ "el": "childs", "opacity": [0, 1], "rotateY": [-90, 0], "rotateZ": [-10, 0], "translateY": [80, 0], "translateZ": [50, 0], "staggervalue": 200, "duration": 900, "easing": "easeOutCirc" }'>
                    <div
                        class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                        About CareerGuard</div>
                    <h3 class="fw-700 text-dark-gray ls-minus-1px w-90 xl-w-100">Secure Careers. Stronger Futures.</h3>
                    <p class="w-90 xs-w-100 mx-auto mx-lg-0">Our mission is to build a reliable support platform that
                        helps employees stay financially and professionally prepared during unexpected career
                        challenges.</p>
                    <div
                        class="row row-cols-2 row-cols-2 counter-style-04 mb-40px md-mb-30px mt-20px justify-content-center justify-content-lg-start">
                        <div class="col-auto col-sm-4">
                            <h2 class="vertical-counter d-inline-flex alt-font text-dark-gray fw-800 mb-0 ls-minus-3px"
                                data-to="120"></h2>
                            <span class="d-block alt-font fw-600 lh-18 text-dark-gray">User reviews</span>
                        </div>
                        <div class="col-auto col-lg-auto col-sm-4">
                            <h2 class="vertical-counter d-inline-flex alt-font text-dark-gray fw-800 mb-0 ls-minus-3px"
                                data-to="10"></h2>
                            <span class="d-block alt-font fw-600 lh-18 text-dark-gray">Awards winning</span>
                        </div>
                    </div>
                    <a href="{{ route('frontend.download') }}"
                        class="btn btn-large btn-rounded btn-dark-gray btn-box-shadow">Download now</a>
                </div>
            </div>
            <div class="row justify-content-center align-items-center mt-1 md-mt-7 sm-mt-10 mb-8"
                data-anime='{ "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 250, "easing": "easeOutQuad" }'>
                <div class="col-12 text-center align-items-center">
                    <div
                        class="bg-white border border-1 border-color-extra-medium-gray box-shadow-extra-large fw-800 text-dark-gray text-uppercase border-radius-30px ps-20px pe-15px fs-12 me-10px xs-m-10px d-inline-block align-middle">
                        hurray</div>
                    <div class="text-dark-gray d-block d-sm-inline-block align-middle fs-18 fw-600 ls-minus-05px">Join
                        the <span class="fw-800 text-decoration-line-bottom">1000+</span> people trusting CareerGuard.
                    </div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center mb-9 lg-mb-7"
                data-anime='{ "el": "childs", "translateY": [0, 0], "perspective": [1200,1200], "scale": [1.1, 1], "rotateX": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                    <div
                        class="feature-box bg-white text-center h-100 justify-content-start border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-icon mb-40px lg-mb-30px">
                            <svg class="h-70px" style="width: 70px; height: 70px;" viewBox="0 0 64 64" fill="none"
                                stroke="#ff7369" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="12" y="16" width="40" height="28" rx="2" />
                                <line x1="12" y1="22" x2="52" y2="22" />
                                <circle cx="42" cy="19" r="1" stroke-width="1" />
                                <circle cx="47" cy="19" r="1" stroke-width="1" />
                                <path d="M32 54 C32 54 22 40 22 30 A 10 10 0 0 1 42 30 C42 40 32 54 32 54 Z"
                                    fill="#ffffff" />
                                <circle cx="32" cy="30" r="3" />
                            </svg>
                        </div>
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Career Security</span>
                            <p>Support for job uncertainty and career transitions.</p>
                        </div>
                    </div>
                </div>
                <div class="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                    <div
                        class="feature-box bg-white text-center h-100 justify-content-start border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-icon mb-40px lg-mb-30px">
                            <svg class="h-70px" style="width: 70px; height: 70px;" viewBox="0 0 64 64" fill="none"
                                stroke="#ff7369" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M22 34 Q 32 24 42 34" stroke-dasharray="2 4" />
                                <line x1="20" y1="44" x2="44" y2="44" stroke-dasharray="2 4" />

                                <circle cx="32" cy="18" r="5" fill="#ffffff" />
                                <path d="M24 30 C24 26 40 26 40 30" fill="#ffffff" />

                                <circle cx="18" cy="38" r="5" fill="#ffffff" />
                                <path d="M10 50 C10 46 26 46 26 50" fill="#ffffff" />

                                <circle cx="46" cy="38" r="5" fill="#ffffff" />
                                <path d="M38 50 C38 46 54 46 54 50" fill="#ffffff" />
                            </svg>
                        </div>
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Financial Preparedness</span>
                            <p>Eligibility-based assistance during employment challenges.</p>
                        </div>
                    </div>
                </div>
                <div class="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                    <div
                        class="feature-box bg-white text-center h-100 justify-content-start border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-icon mb-40px lg-mb-30px">
                            <svg class="h-70px" style="width: 70px; height: 70px;" viewBox="0 0 64 64" fill="none"
                                stroke="#ff7369" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="14" y="16" width="36" height="34" rx="3" />
                                <line x1="22" y1="12" x2="22" y2="20" />
                                <line x1="42" y1="12" x2="42" y2="20" />
                                <line x1="14" y1="26" x2="50" y2="26" />
                                <rect x="20" y="32" width="3" height="3" />
                                <rect x="28" y="32" width="3" height="3" />
                                <rect x="36" y="32" width="3" height="3" />
                                <rect x="20" y="40" width="3" height="3" />
                                <rect x="28" y="40" width="3" height="3" />

                                <circle cx="46" cy="46" r="9" fill="#ffffff" />
                                <path d="M41 46 l3 3 l6 -6" />
                            </svg>
                        </div>
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">For Working Professionals</span>
                            <p>Designed for IT, corporate, BPO, sales, and private-sector employees.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->

    <section class="position-relative pt-0">
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="p-0 position-absolute left-0px top-100px text-end w-auto xs-w-150px"
                    data-bottom-top="transform: translateY(-100px)" data-top-bottom="transform: translateY(100px)">
                    <img src="{{ asset('frontend/images/demo-application-about-bg-left.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center position-relative z-index-1">
                <div class="col-xl-4 col-lg-5 col-md-6 sm-mb-40px text-center text-md-start">
                    <div class="swiper slider-one-slide text-slider-style-01 magic-cursor"
                        data-slider-options='{ "slidesPerView": 1, "loop": true, "pagination": { "el": ".slider-one-slide-pagination", "clickable": true }, "autoplay": { "delay": 4500, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                        <div class="swiper-wrapper mb-20px lg-mb-10px">

                            <div class="swiper-slide">
                                <div
                                    class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                                    Step 01</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Choose Your Membership Plan</h3>
                                <p class="md-w-90 md-w-100 mx-auto mx-md-0">Select a membership plan that aligns
                                    perfectly with your financial preparedness goals and career level.</p>
                                <div
                                    class="pt-20px pb-20px ps-30px pe-30px bg-linen border-radius-6px mt-30px mb-15px icon-with-text-style-08">
                                    <div class="feature-box feature-box-left-icon-middle d-inline-flex align-top">
                                        <div class="feature-box-icon me-10px">
                                            <i class="bi bi-list-check icon-medium text-base-color"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span class="fw-600 text-dark-gray d-block lh-26">Career experts guide you.</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="fs-13">Start your journey toward <span
                                        class="fw-600 text-dark-gray text-decoration-line-bottom">financial security</span> and peace of mind.</p>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                                    Step 02</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Activate Monthly Membership</h3>
                                <p class="md-w-90 md-w-100 mx-auto mx-md-0">Maintain an active membership through
                                    affordable monthly payments to ensure your safeguard remains valid.</p>
                                <div
                                    class="pt-20px pb-20px ps-30px pe-30px bg-linen border-radius-6px mt-30px mb-15px icon-with-text-style-08">
                                    <div class="feature-box feature-box-left-icon-middle d-inline-flex align-top">
                                        <div class="feature-box-icon me-10px">
                                            <i class="bi bi-credit-card icon-medium text-base-color"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span class="fw-600 text-dark-gray d-block lh-26">Affordable protection, support.</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="fs-13">Consistent payments provide <span
                                        class="fw-600 text-dark-gray text-decoration-line-bottom">continuous career support</span> when needed.</p>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                                    Step 03</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Complete Eligibility Period</h3>
                                <p class="md-w-90 md-w-100 mx-auto mx-md-0">Simply continue your active membership for
                                    the required eligibility duration to unlock full assistance benefits.</p>
                                <div
                                    class="pt-20px pb-20px ps-30px pe-30px bg-linen border-radius-6px mt-30px mb-15px icon-with-text-style-08">
                                    <div class="feature-box feature-box-left-icon-middle d-inline-flex align-top">
                                        <div class="feature-box-icon me-10px">
                                            <i class="bi bi-clock-history icon-medium text-base-color"></i>
                                        </div>
                                        <div class="feature-box-content">
                                            <span class="fw-600 text-dark-gray d-block lh-26">Stay eligible for full support.</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="fs-13">Eligibility is the foundation of <span
                                        class="fw-600 text-dark-gray text-decoration-line-bottom">comprehensive assistance</span>.</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <div
                            class="slider-one-slide-prev-1 icon-very-medium text-dark-gray swiper-button-prev slider-navigation-style-04 border border-1 border-color-extra-medium-gray bg-white">
                            <i class="bi bi-arrow-left-short"></i>
                        </div>
                        <div
                            class="slider-one-slide-next-1 icon-very-medium text-dark-gray swiper-button-next slider-navigation-style-04 border border-1 border-color-extra-medium-gray bg-white">
                            <i class="bi bi-arrow-right-short"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-6 position-relative atropos" data-atropos>
                    <div class="atropos-scale">
                        <div class="atropos-rotate">
                            <div class="atropos-inner text-center">
                                <div data-atropos-offset="-5" class="position-absolute left-80px lg-left-20px">
                                    <img src="{{ asset('frontend/images/demo-application-home-easy-payment-bg.webp') }}" alt="">
                                </div>
                                <img data-atropos-offset="5"
                                    class="position-relative z-index-9 right-minus-50px lg-right-minus-20px xs-right-0px"
                                    src="{{ asset('frontend/images/cg-about-2.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid overflow-hidden">
            <div class="row">
                <div class="p-0 overlap-section position-absolute right-0px top-minus-100px text-end w-auto xs-w-180px"
                    data-bottom-top="transform: translateY(100px)" data-top-bottom="transform: translateY(-100px)">
                    <img src="{{ asset('frontend/images/demo-application-about-bg-right.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
