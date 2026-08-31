@extends('frontend.layouts.app')

@section('title', 'CareerGuard – Career Support & Membership Platform')
@section('meta_description', 'CareerGuard is a membership-based career support platform providing job resources, resume templates, interview preparation, business opportunities, and eligibility-based financial assistance support for working professionals.')

@section('content')
    <style>
        @media (max-width: 991px) {
            .cg-hero {
                padding-top: 110px !important;
            }
        }

        @media (max-width: 575px) {
            .cg-hero {
                padding-top: 120px !important;
            }
        }
    </style>

    <section
        class="cg-hero p-0 cover-background full-screen ipad-top-space-margin md-h-auto position-relative md-pb-70px"
        style="background-image: url('{{ asset('frontend/images/demo-application-home-banner.jpg') }}')">

        <div id="particles-style-01" class="h-100 position-absolute left-0px top-0 w-100" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 12,"density": {"enable": true,"value_area": 2000}},"color": {"value": ["#8f76f5", "#a65cef", "#c74ad2", "#e754a4", "#ff6472"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.3,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"line_linked":{"enable":false,"distance":0,"color":"#ffffff","opacity":0.4,"width":1},"move": {"enable": true,"speed":1,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'>
        </div>

        <div class="container h-100 position-relative z-index-9">
            <div class="row align-items-center h-100 justify-content-center">

                <!-- Image column: left on desktop, below content on mobile -->
                <div class="col-lg-5 col-md-10 text-center position-relative md-mt-50px order-2 order-lg-1"
                    data-anime='{ "el": "childs", "opacity": [0, 1], "translateY": [80, 0], "staggervalue": 200, "duration": 900, "easing": "easeOutCirc" }'>
                    <div class="d-inline-block">
                        <div class="text-end ms-auto animation-float">
                            <img src="{{ asset('frontend/images/cg-home.png') }}" alt="Main Application Mockup" class="w-100"
                                style="max-width: 120%;">
                        </div>
                    </div>
                </div>

                <!-- Content column: right on desktop, above image on mobile -->
                <div class="col-xl-6 offset-xl-1 col-lg-7 col-md-10 position-relative text-center text-lg-start order-1 order-lg-2"
                    data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 100, "staggervalue": 150, "easing": "easeOutQuad" }'>

                    <h1 class="fs-75 xl-fs-65 lg-fs-55 md-fs-45 lh-sm fw-400 text-dark-gray ls-minus-2px mb-25px">
                        Protect Your Career <span class="fw-800 d-block d-sm-inline">with Confidence.</span>
                    </h1>

                    <p class="fs-18 w-95 xs-w-100 lh-30 mb-35px text-medium-gray mx-auto mx-lg-0">
                        Membership-based support platform designed for working professionals during unexpected career
                        challenges.
                    </p>

                    <div class="row g-3 pe-lg-5">

                        <div class="col-sm-6 col-12">
                            <a href="{{ route('register') }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-dark w-100 py-3 box-shadow-medium-bottom border-radius-4px fw-700 text-uppercase ls-05px"
                                style="color: #fff;" onmouseover="this.style.color='#000'"
                                onmouseout="this.style.color='#fff'">
                                Join Membership
                            </a>
                        </div>

                        <div class="col-sm-6 col-12">
                            <a href="{{ route('frontend.features') }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-outline-dark w-100 py-3 box-shadow-medium-bottom border-radius-4px fw-700 text-uppercase ls-05px"
                                style="color: #000;" onmouseover="this.style.color='#000'"
                                onmouseout="this.style.color='#000'">
                                View Plans
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div
            class="marquees-text fw-800 fs-250 md-fs-180 ls-minus-10px text-dark-gray text-nowrap position-absolute bottom-50px opacity-1 text-center z-index-1">
            career guard career guard
        </div>

    </section>

    <style>
        .enhanced-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            border: 1px solid #f0f0f0;
            border-top: 4px solid transparent;
        }

        .enhanced-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08) !important;
            border-top-color: #a8a8a8;
        }
    </style>

    <section class="bg-light position-relative overflow-hidden py-5">
        <div class="container-fluid position-absolute h-100 top-0 left-0 pe-none">
            <img src="{{ asset('frontend/images/demo-application-about-bg-left.png') }}"
                class="position-absolute top-50 left-minus-50px translate-middle-y opacity-5" alt="">
            <img src="{{ asset('frontend/images/demo-application-about-bg-right.png') }}"
                class="position-absolute bottom-minus-50px right-minus-50px opacity-5" alt="">
        </div>

        <div class="container position-relative z-index-1">
            <div class="row align-items-center justify-content-between">

                <div class="col-lg-4 col-md-10 text-center text-lg-start md-mb-50px"
                    data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "easing": "easeOutQuad" }'>
                    <div
                        class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                        Membership Benefits</div>
                    <h3 class="text-dark-gray fw-700 ls-minus-1px mb-20px">What CareerGuard Offers</h3>
                    <p class="text-muted mb-40px md-w-80 sm-w-100 mx-auto mx-lg-0">Supporting professionals with career
                        resources, opportunities, and membership benefits designed to help them stay prepared and
                        confident throughout their career journey.</p>

                    <div
                        class="bg-white box-shadow-medium border-radius-4px p-15px d-inline-block border border-color-extra-light-gray">
                        <div
                            class="bg-dark-gray fw-800 text-white text-uppercase border-radius-30px ps-15px pe-15px fs-10 me-10px d-inline-block align-middle">
                            TRUSTED</div>
                        <span class="text-dark-gray fs-14 fw-600 align-middle">Join thousands of professionals building
                            a stronger future with CareerGuard.</span>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row row-cols-1 row-cols-sm-2 g-4"
                        data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 200, "easing": "easeOutQuad" }'>

                        <div class="col mt-lg-5">
                            <div class="enhanced-card bg-white box-shadow-extra-large border-radius-8px p-40px h-100">
                                <span class="d-block alt-font fs-19 fw-700 text-dark-gray mb-10px">Financial Assistance
                                    Support</span>
                                <p class="mb-0 fs-15 lh-sm text-muted">Eligibility-based support for verified active
                                    members during unexpected employment situations.</p>
                            </div>
                        </div>

                        <div class="col">
                            <div class="enhanced-card bg-white box-shadow-extra-large border-radius-8px p-40px h-100">
                                <span class="d-block alt-font fs-19 fw-700 text-dark-gray mb-10px">Affordable Membership
                                    Plans</span>
                                <p class="mb-0 fs-15 lh-sm text-muted">Flexible monthly plans designed for working
                                    professionals across multiple industries.</p>
                            </div>
                        </div>

                        <div class="col mt-lg-5">
                            <div class="enhanced-card bg-white box-shadow-extra-large border-radius-8px p-40px h-100">
                                <span class="d-block alt-font fs-19 fw-700 text-dark-gray mb-10px">Career
                                    Resources</span>
                                <p class="mb-0 fs-15 lh-sm text-muted">Access job updates, resume templates, interview
                                    questions & answers, and career preparation tools.</p>
                            </div>
                        </div>

                        <div class="col">
                            <div class="enhanced-card bg-white box-shadow-extra-large border-radius-8px p-40px h-100">
                                <span class="d-block alt-font fs-19 fw-700 text-dark-gray mb-10px">Smart Member
                                    Dashboard</span>
                                <p class="mb-0 fs-15 lh-sm text-muted">Track membership status, payment history, renewal
                                    dates, notifications, and support requests.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- start section -->
    <section class="pb-0 half-section lg-pt-0">
        <div class="container">

            <div class="row"
                data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay": 300, "staggervalue": 250, "easing": "easeOutQuad" }'>
                <div class="col text-center">
                    <span class="fs-19 alt-font mb-35px d-inline-block text-dark-gray fw-600 ls-minus-05px">
                        Supporting Professionals Through Career Growth & Opportunities.
                    </span>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-lg-5 row-cols-md-3 row-cols-sm-2 clients-style-06 justify-content-center"
                data-anime='{ "el": "childs", "translateX": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 250, "easing": "easeOutQuad" }'>

                <div class="col client-box text-center mb-35px">
                    <a href="#">
                        <img src="{{ asset('frontend/images/cg-cafe.png') }}" class="client-logo" alt="">
                    </a>
                </div>

                <div class="col client-box text-center mb-35px">
                    <a href="#">
                        <img src="{{ asset('frontend/images/cg-theater.png') }}" class="client-logo" alt="">
                    </a>
                </div>

                <div class="col client-box text-center mb-35px">
                    <a href="#">
                        <img src="{{ asset('frontend/images/cg-real-estate.png') }}" class="client-logo" alt="">
                    </a>
                </div>

                <div class="col client-box text-center mb-35px">
                    <a href="#">
                        <img src="{{ asset('frontend/images/cg-hotel.png') }}" class="client-logo" alt="">
                    </a>
                </div>

                <div class="col client-box text-center mb-35px">
                    <a href="#">
                        <img src="{{ asset('frontend/images/cg-event.png') }}" class="client-logo" alt="">
                    </a>
                </div>

            </div>
        </div>
    </section>

    <style>
        .client-logo {
            height: 150px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            filter: grayscale(100%) brightness(0.7);
            transition: all 0.3s ease;
            opacity: 0.8;
        }

        .client-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.05);
        }

        @media (max-width: 575px) {
            .client-logo {
                height: 110px;
            }
        }

        .bo-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 100000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .bo-modal-overlay.bo-active {
            display: flex;
            opacity: 1;
        }

        .bo-modal {
            background: #fff;
            width: 100%;
            max-width: 640px;
            max-height: 90vh;
            border-radius: 20px;
            box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.35);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: translateY(20px) scale(0.97);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .bo-modal-overlay.bo-active .bo-modal {
            transform: translateY(0) scale(1);
        }

        .bo-modal-header {
            background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%);
            color: #fff;
            padding: 28px 32px 26px;
            position: relative;
            flex-shrink: 0;
        }

        .bo-modal-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
            display: block;
        }

        .bo-modal-title {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin: 0;
            letter-spacing: -0.01em;
            line-height: 1.25;
            padding-right: 40px;
        }

        .bo-modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 36px;
            height: 36px;
            border: none;
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .bo-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .bo-modal-body {
            padding: 28px 32px;
            overflow-y: auto;
            flex: 1;
        }

        .bo-modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .bo-modal-body::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 999px;
        }

        .bo-section {
            margin-bottom: 24px;
        }

        .bo-section:last-child {
            margin-bottom: 0;
        }

        .bo-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #7e22ce;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bo-section-label::before {
            content: '';
            width: 14px;
            height: 2px;
            background: #7e22ce;
            border-radius: 2px;
        }

        .bo-section-text {
            font-size: 14.5px;
            line-height: 1.65;
            color: #475569;
            margin: 0;
        }

        .bo-features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 10px;
        }

        .bo-features-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            color: #334155;
            line-height: 1.5;
            padding: 0;
        }

        .bo-note-callout {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 16px 18px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .bo-note-icon {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            background: #f59e0b;
            color: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .bo-note-content {
            flex: 1;
        }

        .bo-note-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #92400e;
            margin-bottom: 4px;
        }

        .bo-note-text {
            font-size: 13px;
            line-height: 1.6;
            color: #78350f;
            margin: 0;
        }

        .bo-modal-footer {
            padding: 18px 32px;
            border-top: 1px solid #f1f5f9;
            background: #fafbfc;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            flex-shrink: 0;
        }

        .bo-btn {
            height: 42px;
            padding: 0 22px;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: inherit;
        }

        .bo-btn-secondary {
            background: #fff;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .bo-btn-secondary:hover {
            background: #f8fafc;
            color: #1e293b;
        }

        .bo-btn-primary {
            background: linear-gradient(135deg, #7e22ce 0%, #db2777 100%);
            color: #fff;
            box-shadow: 0 6px 14px -4px rgba(126, 34, 206, 0.4);
        }

        .bo-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px -6px rgba(126, 34, 206, 0.5);
            color: #fff;
        }

        @media (max-width: 640px) {
            .bo-modal-overlay {
                padding: 12px;
                align-items: flex-end;
            }

            .bo-modal {
                max-height: 92vh;
                border-radius: 20px 20px 16px 16px;
            }

            .bo-modal-header {
                padding: 22px 22px 20px;
            }

            .bo-modal-title {
                font-size: 19px;
                padding-right: 36px;
            }

            .bo-modal-close {
                top: 16px;
                right: 16px;
                width: 32px;
                height: 32px;
                font-size: 16px;
            }

            .bo-modal-body {
                padding: 22px;
            }

            .bo-modal-footer {
                padding: 14px 22px;
                flex-direction: column-reverse;
            }

            .bo-modal-footer .bo-btn {
                width: 100%;
            }

            .bo-section {
                margin-bottom: 20px;
            }

            .bo-features-list li {
                font-size: 13.5px;
            }
        }

        .stack-box .stack-item-04,
        .stack-box .stack-item-05 {
            position: sticky;
            top: 0;
            width: 100%;
            overflow: hidden;
        }

        .stack-box .stack-item-04 {
            z-index: 4;
        }

        .stack-box .stack-item-05 {
            z-index: 5;
        }

        @media (max-width: 1199px) {

            .stack-box .stack-item-04,
            .stack-box .stack-item-05 {
                position: relative;
                height: auto !important;
            }
        }
    </style>

    <!-- Business Opportunities Section -->
    <section class="pb-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center mb-6 sm-mb-12"
                data-anime='{ "el": "childs", "translateY": [0, 0], "perspective": [1200,1200], "scale": [1.1, 1], "rotateX": [50, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>

                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div class="feature-box d-flex flex-column bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover position-relative">
                        <div class="feature-box-content d-flex flex-column flex-grow-1 last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Low-Investment Business Ideas</span>
                            <p class="mb-3">Explore affordable business opportunities with future growth potential.</p>
                            <a href="javascript:void(0)" onclick="openBoModal('low-investment')"
                                class="btn btn-link btn-hover-animation-switch btn-extra-large text-dark-gray fw-700 text-uppercase-inherit mt-auto pt-15px">
                                <span>
                                    <span class="btn-text">Learn more</span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div class="feature-box d-flex flex-column bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover position-relative">
                        <div class="feature-box-content d-flex flex-column flex-grow-1 last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Franchise Opportunities</span>
                            <p class="mb-3">Discover franchise models across multiple industries and business categories.</p>
                            <a href="javascript:void(0)" onclick="openBoModal('franchise')"
                                class="btn btn-link btn-hover-animation-switch btn-extra-large text-dark-gray fw-700 text-uppercase-inherit mt-auto pt-15px">
                                <span>
                                    <span class="btn-text">Learn more</span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                </span>
                            </a>
                        </div>
                        <span class="position-absolute top-25px right-25px bg-dark-gray border-radius-18px text-white fs-11 fw-700 text-uppercase ps-15px pe-15px lh-26">New</span>
                    </div>
                </div>

                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div class="feature-box d-flex flex-column bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover position-relative">
                        <div class="feature-box-content d-flex flex-column flex-grow-1 last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Online & Self-Employment</span>
                            <p class="mb-3">Find flexible online business and self-employment opportunities.</p>
                            <a href="javascript:void(0)" onclick="openBoModal('online')"
                                class="btn btn-link btn-hover-animation-switch btn-extra-large text-dark-gray fw-700 text-uppercase-inherit mt-auto pt-15px">
                                <span>
                                    <span class="btn-text">Learn more</span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div class="feature-box d-flex flex-column bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover position-relative">
                        <div class="feature-box-content d-flex flex-column flex-grow-1 last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Business Opportunities</span>
                            <p class="mb-3">Explore cafes, private theatres, event management, holiday packages, real estate, and interior designing opportunities.</p>
                            <a href="javascript:void(0)" onclick="openBoModal('business')"
                                class="btn btn-link btn-hover-animation-switch btn-extra-large text-dark-gray fw-700 text-uppercase-inherit mt-auto pt-15px">
                                <span>
                                    <span class="btn-text">Learn more</span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div class="feature-box d-flex flex-column bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover position-relative">
                        <div class="feature-box-content d-flex flex-column flex-grow-1 last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Additional Income Opportunities</span>
                            <p class="mb-3">Discover side businesses and extra income opportunities to support your financial goals.</p>
                            <a href="javascript:void(0)" onclick="openBoModal('additional-income')"
                                class="btn btn-link btn-hover-animation-switch btn-extra-large text-dark-gray fw-700 text-uppercase-inherit mt-auto pt-15px">
                                <span>
                                    <span class="btn-text">Learn more</span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div class="feature-box d-flex flex-column bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover position-relative">
                        <div class="feature-box-content d-flex flex-column flex-grow-1 last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Entrepreneur Growth Support</span>
                            <p class="mb-3">Access business resources, guidance, and growth opportunities for aspiring entrepreneurs.</p>
                            <a href="javascript:void(0)" onclick="openBoModal('entrepreneur')"
                                class="btn btn-link btn-hover-animation-switch btn-extra-large text-dark-gray fw-700 text-uppercase-inherit mt-auto pt-15px">
                                <span>
                                    <span class="btn-text">Learn more</span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                    <span class="btn-icon"><i class="fa-solid fa-arrow-right icon-very-small"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center align-items-center"
                data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 250, "easing": "easeOutQuad" }'>
                <div class="col-12 text-center align-items-center">
                    <div class="bg-white border border-1 border-color-extra-medium-gray box-shadow-extra-large fw-800 text-dark-gray text-uppercase border-radius-30px ps-20px pe-20px fs-12 me-10px sm-m-10px d-inline-block align-middle">hurray</div>
                    <div class="text-dark-gray d-block d-sm-inline-block align-middle fs-18 fw-600 ls-minus-05px">Join Now for<a href="{{ route('frontend.subscribe') }}" class="fw-800 text-decoration-line-bottom text-dark-gray"> Career Guidance</a> & Special Offers</div>
                </div>
            </div>
        </div>
    </section>

    <!-- POPUP MODAL -->
    <div class="bo-modal-overlay" id="boModalOverlay" onclick="closeBoModal(event)">
        <div class="bo-modal" onclick="event.stopPropagation()">
            <div class="bo-modal-header">
                <span class="bo-modal-eyebrow" id="boModalEyebrow">Business Service</span>
                <h3 class="bo-modal-title" id="boModalTitle">Title</h3>
                <button type="button" class="bo-modal-close" onclick="closeBoModal()" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="bo-modal-body">
                <div class="bo-section">
                    <div class="bo-section-label">About This Service</div>
                    <p class="bo-section-text" id="boModalAbout"></p>
                </div>

                <div class="bo-section">
                    <div class="bo-section-label">What You Will Get</div>
                    <ul class="bo-features-list" id="boModalFeatures"></ul>
                </div>

                <div class="bo-section">
                    <div class="bo-note-callout">
                        <div class="bo-note-icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <div class="bo-note-content">
                            <div class="bo-note-title">Important Note</div>
                            <p class="bo-note-text" id="boModalNote"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bo-modal-footer">
                <button type="button" class="bo-btn bo-btn-secondary" onclick="closeBoModal()">Close</button>
                <a href="{{ route('frontend.subscribe') }}" class="bo-btn bo-btn-primary">
                    Join Now <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Industries section -->
    <section class="position-relative half-section">
        <div class="container-fluid">
            <div class="row">
                <div class="p-0 overlap-section position-absolute right-0px text-end w-auto xs-w-200px z-index-minus-1"
                    data-bottom-top="transform: translateY(-150px)" data-top-bottom="transform: translateY(150px)">
                    <img src="{{ asset('frontend/images/demo-application-home-bg-right.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="position-absolute left-0px bottom-minus-100px w-auto xs-w-180px z-index-minus-1"
            data-bottom-top="transform: translateY(-100px)" data-top-bottom="transform: translateY(100px)">
            <img src="{{ asset('frontend/images/demo-application-home-bg-left.png') }}" alt="">
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-7 position-relative md-mb-20px"
                    data-anime='{ "effect": "slide", "color": "#ffffff", "direction":"lr", "easing": "easeOutQuad", "delay":50}'>
                    <figure>
                        <div class="atropos" data-atropos>
                            <div class="atropos-scale">
                                <div class="atropos-rotate">
                                    <div class="atropos-inner">
                                        <img src="{{ asset('frontend/images/cg-random.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-5 col-md-8 col-sm-10 text-center text-lg-start">
                    <div class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12"
                        data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        How it works</div>
                    <h3 class="fw-700 mb-45px text-dark-gray ls-minus-1px"
                        data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        INDUSTRIES WE SUPPORT</h3>
                    <div class="row row-cols-1"
                        data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div class="col-12 process-step-style-05 position-relative hover-box">
                            <div class="process-step-item d-flex">
                                <div class="process-step-icon-wrap position-relative">
                                    <div class="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-55px w-55px bg-linen fs-15 fw-700 position-relative">
                                        <span class="number position-relative z-index-1 text-dark-gray">01</span>
                                        <div class="box-overlay bg-base-color rounded-circle"></div>
                                    </div>
                                    <span class="progress-step-separator bg-dark-gray opacity-1"></span>
                                </div>
                                <div class="process-content ps-35px last-paragraph-no-margin mb-30px">
                                    <span class="d-block fw-700 text-dark-gray mb-5px fs-18">IT, BPO & Corporate Professionals</span>
                                    <p class="w-70 lg-w-90 sm-w-100">Designed for employees working in fast-paced private-sector industries.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 process-step-style-05 position-relative hover-box">
                            <div class="process-step-item d-flex">
                                <div class="process-step-icon-wrap position-relative">
                                    <div class="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-55px w-55px bg-linen fs-15 fw-700 fw-600 position-relative">
                                        <span class="number position-relative z-index-1 text-dark-gray">02</span>
                                        <div class="box-overlay bg-base-color rounded-circle"></div>
                                    </div>
                                    <span class="progress-step-separator bg-dark-gray opacity-1"></span>
                                </div>
                                <div class="process-content ps-35px last-paragraph-no-margin mb-30px">
                                    <span class="d-block fw-700 text-dark-gray mb-5px fs-18">Sales, Marketing, Finance & Operations Experts</span>
                                    <p class="w-70 lg-w-90 sm-w-100">Career preparedness support for professionals across key business functions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 process-step-style-05 position-relative hover-box">
                            <div class="process-step-item d-flex">
                                <div class="process-step-icon-wrap position-relative">
                                    <div class="process-step-icon d-flex justify-content-center align-items-center mx-auto rounded-circle h-55px w-55px bg-linen fs-15 fw-700 fw-600 position-relative">
                                        <span class="number position-relative z-index-1 text-dark-gray">03</span>
                                        <div class="box-overlay bg-base-color rounded-circle"></div>
                                    </div>
                                </div>
                                <div class="process-content ps-35px last-paragraph-no-margin">
                                    <span class="d-block fw-700 text-dark-gray mb-5px fs-18">Young & Mid-Level Salaried Professionals</span>
                                    <p class="w-70 lg-w-90 sm-w-100">Affordable membership solutions for professionals seeking career security and financial preparedness.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Review / Stats Box -->
    <section class="p-0">
        <div class="container">
            <div class="row m-0 align-items-center p-55px lg-p-35px md-p-50px xs-pt-40px xs-pb-40px xs-ps-15px xs-pe-15px justify-content-center bg-floral-white border-radius-6px"
                data-bottom-top="transform: translate3d(30px, 0px, 0px);"
                data-top-bottom="transform: translate3d(-30px, 0px, 0px);">
                <div class="col-lg-6 text-dark-gray md-mb-50px sm-mb-40px">
                    <div class="row align-items-center justify-content-center justify-content-lg-start">
                        <div class="col-5 col-sm-4 md-mb-20px"><img src="{{ asset('frontend/images/linkedin.png') }}" class="rounded-circle w-100" alt=""></div>
                        <div class="col-lg-8 text-center text-lg-start">
                            <div class="fs-19 lh-30 mb-3 w-90 md-w-75 sm-w-100 mx-auto mx-lg-0">CareerGuard makes one modest. You see what a tiny place your favorite occupy in the world.</div>
                            <div>
                                <div class="text-dark-gray fw-700 fs-19 d-inline-block me-10px">Samaksh Soni</div>
                                <div class="review-star-icon position-relative d-inline-block top-0px fs-18">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-5 text-dark-gray border-start border-color-transparent-dark-very-light md-border-start-0 text-center text-lg-start ps-6 pe-6">
                    <h3 class="mb-0 fw-800 ls-minus-1px lh-38">4.93</h3>
                    <span class="fs-17 fw-600">User reviews</span>
                    <div class="review-star-icon fs-18">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        <span class="fs-12 lh-16 d-block text-medium-gray">Rating on app store</span>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-5 text-dark-gray border-start border-color-transparent-dark-very-light text-center text-lg-start ps-6 pe-6">
                    <h3 class="mb-0 fw-800 ls-minus-1px lh-38">500+</h3>
                    <span class="fs-17 fw-600">Installations</span>
                    <div class="review-star-icon fs-18">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        <span class="fs-12 lh-16 d-block text-medium-gray">Rating on app store</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stack Cards Section -->
    <section class="stack-box py-0">
        <div class="stack-box-contain">

            <div class="stack-item stack-item-01 bg-white lg-pt-8 lg-pb-8 xs-pt-50px xs-pb-50px">
                <div class="stack-item-wrapper">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-5 col-md-6 sm-mb-40px text-center text-md-start">
                                <div class="d-inline-block mb-20px bg-base-color fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">Career Guard Opportunity</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Job Opportunities</h3>
                                <p class="lg-w-85 md-w-95 sm-w-100">Access curated job opportunities and career openings relevant to your industry and experience level.</p>
                                <img src="{{ asset('frontend/images/common.png') }}" class="mt-10px" alt="">
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-6 position-relative atropos" data-atropos>
                                <div class="atropos-scale">
                                    <div class="atropos-rotate">
                                        <div class="atropos-inner text-center">
                                            <div data-atropos-offset="-5" class="position-absolute left-0px right-0px">
                                                <img src="{{ asset('frontend/images/demo-application-home-manage-data-bg.webp') }}" alt="">
                                            </div>
                                            <img data-atropos-offset="5" class="position-relative z-index-9" src="{{ asset('frontend/images/cg-jobs.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stack-item stack-item-02 bg-linen lg-pt-8 lg-pb-8 xs-pt-50px xs-pb-50px">
                <div class="stack-item-wrapper">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-5 col-md-6 sm-mb-40px text-center text-md-start">
                                <div class="d-inline-block mb-20px bg-base-color fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">Data dashboard</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Resume Templates</h3>
                                <p class="lg-w-85 md-w-95 sm-w-100">Download professional resume templates designed to improve your profile presentation and hiring chances.</p>
                                <img src="{{ asset('frontend/images/common.png') }}" class="mt-10px" alt="">
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-6 position-relative atropos transform-3d" data-atropos>
                                <div class="atropos-scale">
                                    <div class="atropos-rotate">
                                        <div class="atropos-inner text-center">
                                            <div data-atropos-offset="-5" class="position-absolute left-0px right-0px">
                                                <img src="{{ asset('frontend/images/demo-application-home-free-support-bg.webp') }}" alt="">
                                            </div>
                                            <img data-atropos-offset="5" class="position-relative z-index-9" src="{{ asset('frontend/images/cg-resume.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stack-item stack-item-03 bg-white lg-pt-8 lg-pb-8 xs-pt-50px xs-pb-50px">
                <div class="stack-item-wrapper">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-5 col-md-6 sm-mb-40px text-center text-md-start">
                                <div class="d-inline-block mb-20px bg-base-color fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">Data dashboard</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Interview Questions &amp; Answers</h3>
                                <p class="lg-w-85 md-w-95 sm-w-100">Prepare confidently with commonly asked interview questions, answers, and career guidance resources.</p>
                                <img src="{{ asset('frontend/images/common.png') }}" class="mt-10px" alt="">
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-6 position-relative atropos transform-3d" data-atropos>
                                <div class="atropos-scale">
                                    <div class="atropos-rotate">
                                        <div class="atropos-inner text-center">
                                            <div data-atropos-offset="-5" class="position-absolute left-0px right-0px">
                                                <img src="{{ asset('frontend/images/demo-application-home-easy-payment-bg.webp') }}" alt="">
                                            </div>
                                            <img data-atropos-offset="5" class="position-relative z-index-9" src="{{ asset('frontend/images/cg-interview.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stack-item stack-item-04 bg-linen lg-pt-8 lg-pb-8 xs-pt-50px xs-pb-50px">
                <div class="stack-item-wrapper">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-5 col-md-6 sm-mb-40px text-center text-md-start">
                                <div class="d-inline-block mb-20px bg-base-color fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">Data dashboard</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Career Support Resources</h3>
                                <p class="lg-w-85 md-w-95 sm-w-100">Get access to valuable career development materials, professional tips, and growth-focused resources.</p>
                                <img src="{{ asset('frontend/images/common.png') }}" class="mt-10px" alt="">
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-6 position-relative atropos" data-atropos>
                                <div class="atropos-scale">
                                    <div class="atropos-rotate">
                                        <div class="atropos-inner text-center">
                                            <div data-atropos-offset="-5" class="position-absolute left-0px right-0px">
                                                <img src="{{ asset('frontend/images/demo-application-home-manage-data-bg.webp') }}" alt="">
                                            </div>
                                            <img data-atropos-offset="5" class="position-relative z-index-9" src="{{ asset('frontend/images/cg-dashboard.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="stack-item stack-item-05 bg-white lg-pt-8 xs-pt-50px xs-pb-20px">
                <div class="stack-item-wrapper">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-xl-4 col-lg-5 col-md-6 sm-mb-40px text-center text-md-start">
                                <div class="d-inline-block mb-20px bg-base-color fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">Data dashboard</div>
                                <h3 class="fw-700 text-dark-gray ls-minus-1px">Exclusive Member Access</h3>
                                <p class="lg-w-85 md-w-95 sm-w-100">All career resources are available for active CareerGuard members through the secure member dashboard.</p>
                                <img src="{{ asset('frontend/images/common.png') }}" class="mt-10px" alt="">
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-6 position-relative atropos transform-3d" data-atropos>
                                <div class="atropos-scale">
                                    <div class="atropos-rotate">
                                        <div class="atropos-inner text-center">
                                            <div data-atropos-offset="-5" class="position-absolute left-0px right-0px">
                                                <img src="{{ asset('frontend/images/demo-application-home-free-support-bg.webp') }}" alt="">
                                            </div>
                                            <img data-atropos-offset="5" class="position-relative z-index-9" src="{{ asset('frontend/images/cg-membership.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="pt-0 position-relative">
        <div class="container-fluid">
            <div class="row">
                <div class="p-0 overlap-section position-absolute top-100px left-0px text-end w-auto"
                    data-bottom-top="transform: translateY(-100px)" data-top-bottom="transform: translateY(100px)">
                    <img src="{{ asset('frontend/images/demo-application-about-bg-left.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center"
                data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-12">
                    <div class="bg-linen p-9 md-p-7 border-radius-6px overflow-hidden position-relative">
                        <div class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">Basic information</div>
                        <h3 class="fw-700 text-dark-gray ls-minus-1px">Frequently asked questions</h3>
                        <div class="accordion accordion-style-02" id="accordion-style-02"
                            data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                            <div class="accordion-item active-accordion">
                                <div class="accordion-header border-bottom border-color-transparent-dark-very-light">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-01"
                                        aria-expanded="true" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                            <i class="feather icon-feather-minus fs-20"></i><span class="fs-17 fw-600">When does eligibility start?</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-01" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent-dark-very-light">
                                        <p class="w-90 sm-w-95 xs-w-100">Eligibility begins after completing the required active membership period as per your selected membership plan and terms.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header border-bottom border-color-transparent-dark-very-light">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-02"
                                        aria-expanded="false" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                            <i class="feather icon-feather-plus fs-20"></i><span class="fs-17 fw-600">How membership works?</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-02" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent-dark-very-light">
                                        <p class="w-90 sm-w-95 xs-w-100">CareerGuard works through a simple monthly membership model. Members choose a suitable plan, maintain active monthly payments, complete the eligibility period, and can access support and career resources during eligible situations.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header border-bottom border-color-transparent">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-03"
                                        aria-expanded="false" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                            <i class="feather icon-feather-plus fs-20"></i><span class="fs-17 fw-600">What documents are required?</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-03" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                        <p class="w-90 sm-w-95 xs-w-100">Basic documents may include identity proof, employment proof, salary slips, bank details, and job-related verification documents depending on the support request process.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header border-bottom border-color-transparent">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-05"
                                        aria-expanded="false" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                            <i class="feather icon-feather-plus fs-20"></i><span class="fs-17 fw-600">How renewal works?</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-05" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                        <p class="w-90 sm-w-95 xs-w-100">Membership renewal is simple and can be continued through monthly plan payments to keep your membership active and maintain eligibility benefits.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header border-bottom border-color-transparent">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-06"
                                        aria-expanded="false" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                            <i class="feather icon-feather-plus fs-20"></i><span class="fs-17 fw-600">How to contact support?</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-06" class="accordion-collapse collapse"
                                    data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                        <p class="w-90 sm-w-95 xs-w-100">You can contact the CareerGuard support team through the app, official website contact form, email support, or customer assistance channels for membership and eligibility guidance.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-6">
                <div class="col-auto icon-with-text-style-08 sm-mb-15px xs-mb-15px"
                    data-anime='{ "translateX": [-50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="feature-box feature-box-left-icon-middle xs-lh-28">
                        <div class="feature-box-icon me-10px">
                            <i class="bi bi-envelope icon-extra-medium text-base-color"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="alt-font fs-18 xs-fs-17 fw-600 text-dark-gray">Looking for help? <a href="mailto:support@careerguard.in" class="text-decoration-line-bottom text-dark-gray">support@careerguard.in</a></span>
                        </div>
                    </div>
                </div>
                <div class="col-auto icon-with-text-style-08"
                    data-anime='{ "translateX": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="feature-box feature-box-left-icon-middle xs-lh-28">
                        <div class="feature-box-icon me-10px">
                            <i class="bi bi-chat-dots icon-extra-medium text-base-color"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="alt-font fs-18 xs-fs-17 fw-600 text-dark-gray">Keep in Touch. <a href="https://wa.me/919611956627" target="_blank" rel="noopener noreferrer" class="text-decoration-line-bottom text-dark-gray">+91 8123190776</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- App Download CTA Section -->
    <section class="overflow-hidden position-relative bg-gradient-very-light-gray py-0 lg-pt-8 lg-pb-8">
        <div id="particles-style-02" class="h-100 position-absolute left-0px top-0 w-100" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 18,"density": {"enable": true,"value_area": 2000}},"color": {"value": ["#8f76f5", "#a65cef", "#c74ad2", "#e754a4", "#ff6472"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.3,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"line_linked":{"enable":false,"distance":0,"color":"#ffffff","opacity":0.4,"width":1},"move": {"enable": true,"speed":1,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'>
        </div>
        <div class="container">
            <div class="row align-items-center ps-50px pe-50px lg-px-0 position-relative z-index-1 justify-content-md-center">
                <div class="col-lg-6 md-mb-50px">
                    <div class="row">
                        <div class="col-sm-6 xs-mb-30px">
                            <img src="{{ asset('frontend/images/demo-application-home-06.webp') }}"
                                class="w-100 box-shadow-quadruple-large border-radius-10px"
                                data-bottom-top="transform: translateY(-250px)"
                                data-top-bottom="transform: translateY(200px)" alt="">
                        </div>
                        <div class="col-sm-6">
                            <img src="{{ asset('frontend/images/last-1.png') }}" class="w-100 box-shadow-quadruple-large border-radius-10px"
                                data-bottom-top="transform: translateY(200px)"
                                data-top-bottom="transform: translateY(-300px)" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-8 text-center text-lg-start">
                    <h3 class="fw-800 text-dark-gray ls-minus-1px">Download the CareerGuard app now!</h3>
                    <span class="fs-18 w-80 xl-w-100 d-block mb-35px">Your ultimate career partner. Carries the information you need while career guard.</span>
                    <div class="row pe-20px xl-pe-0 justify-content-center justify-content-lg-start">
                        <a href="#" class="col-6 col-lg-6 col-sm-5">
                            <img src="{{ asset('frontend/images/app-store-white.svg') }}" class="box-shadow-medium-bottom border-radius-6px" alt="">
                        </a>
                        <a href="#" class="col-6 col-lg-6 col-sm-5">
                            <img src="{{ asset('frontend/images/play-store-white.svg') }}" class="box-shadow-medium-bottom border-radius-6px" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const boModalData = {
        'low-investment': {
            eyebrow: 'Category 01',
            title: 'Low-Investment Business Ideas',
            about: 'Discover business ideas that can be started with a small investment and have good growth potential. These opportunities are suitable for beginners, students, employees, homemakers, and aspiring entrepreneurs.',
            features: [
                'Business idea suggestions',
                'Estimated investment details',
                'Basic earning potential information',
                'Market demand insights',
                'Startup guidance resources'
            ],
            note: 'The information provided is for awareness and educational purposes. Detailed business planning, project reports, vendor sourcing, registration support, and one-to-one consultation services may be available at additional charges.'
        },
        'franchise': {
            eyebrow: 'Category 02',
            title: 'Franchise Opportunities',
            about: 'Explore franchise opportunities across various industries such as education, retail, events, hospitality, gold trading, and service sectors.',
            features: [
                'Franchise opportunity listings',
                'Investment requirements',
                'Franchise model information',
                'Business overview',
                'Contact details (where applicable)'
            ],
            note: 'Franchise acquisition costs, documentation support, business setup assistance, legal consultation, training programs, and franchise negotiation services may be chargeable separately.'
        },
        'online': {
            eyebrow: 'Category 03',
            title: 'Online & Self-Employment',
            about: 'Learn about online earning opportunities and self-employment options that can be started from home or with minimal infrastructure.',
            features: [
                'Freelancing opportunities',
                'Digital business ideas',
                'Online income resources',
                'Skill-based earning options',
                'Self-employment guidance'
            ],
            note: 'Training programs, software tools, website creation, digital marketing support, and personalized business mentoring may involve separate service charges.'
        },
        'business': {
            eyebrow: 'Category 04',
            title: 'Business Opportunities',
            about: 'Explore various business opportunities across multiple industries including retail, hospitality, events, travel, real estate, education, and service sectors.',
            features: [
                'Business opportunity listings',
                'Industry information',
                'Basic investment estimates',
                'Market insights',
                'Growth potential overview'
            ],
            note: 'Business setup support, registrations, licensing assistance, location sourcing, vendor connections, and project implementation services may be offered separately on a paid basis.'
        },
        'additional-income': {
            eyebrow: 'Category 05',
            title: 'Additional Income Opportunities',
            about: 'Discover side-income and supplementary earning opportunities that can help increase your monthly income and financial stability.',
            features: [
                'Part-time opportunities',
                'Referral income programs',
                'Commission-based earning options',
                'Flexible work opportunities',
                'Income enhancement ideas'
            ],
            note: 'Income levels vary based on effort, skills, location, and market conditions. Training, onboarding assistance, and premium opportunity programs may be available at additional charges.'
        },
        'entrepreneur': {
            eyebrow: 'Category 06',
            title: 'Entrepreneur Growth Support',
            about: 'Access resources, guidance, and information designed to help entrepreneurs start, manage, and grow their businesses effectively.',
            features: [
                'Business guidance resources',
                'Startup support information',
                'Growth strategy insights',
                'Registration guidance',
                'Business development resources'
            ],
            note: 'Professional consulting, company registration, GST registration, trademark registration, legal documentation, funding assistance, marketing services, and business expansion support may be chargeable separately.'
        }
    };

    function openBoModal(key) {
        const data = boModalData[key];
        if (!data) return;

        document.getElementById('boModalEyebrow').textContent = data.eyebrow;
        document.getElementById('boModalTitle').textContent = data.title;
        document.getElementById('boModalAbout').textContent = data.about;
        document.getElementById('boModalNote').textContent = data.note;

        const featuresList = document.getElementById('boModalFeatures');
        featuresList.innerHTML = data.features.map(f => `<li>${f}</li>`).join('');

        const overlay = document.getElementById('boModalOverlay');
        overlay.classList.add('bo-active');
        document.body.style.overflow = 'hidden';
        overlay.querySelector('.bo-modal-body').scrollTop = 0;
    }

    function closeBoModal(event) {
        if (event && event.target.id !== 'boModalOverlay' && event.currentTarget !== event.target) return;
        const overlay = document.getElementById('boModalOverlay');
        overlay.classList.remove('bo-active');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const overlay = document.getElementById('boModalOverlay');
            if (overlay && overlay.classList.contains('bo-active')) closeBoModal();
        }
    });

    (function () {
        function fitStackItems() {
            var stackBox = document.querySelector('.stack-box');
            if (!stackBox) return;
            var items = stackBox.querySelectorAll('.stack-item');
            if (!items.length) return;
            var viewportHeight = window.innerHeight;
            var totalHeight = 0;

            items.forEach(function (item) {
                var wrapper = item.querySelector('.stack-item-wrapper');
                if (!wrapper) return;
                item.style.setProperty('height', 'auto', 'important');
                var contentHeight = wrapper.offsetHeight + 100;
                var finalHeight = Math.max(contentHeight, viewportHeight);
                item.style.setProperty('height', finalHeight + 'px', 'important');
                totalHeight += finalHeight;
            });
            stackBox.style.setProperty('height', totalHeight + 'px', 'important');
        }

        function runFit() {
            fitStackItems();
            setTimeout(fitStackItems, 500);
            setTimeout(fitStackItems, 1500);
        }

        if (document.readyState === 'complete') {
            runFit();
        } else {
            window.addEventListener('load', runFit);
        }

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(fitStackItems, 250);
        });
    })();
</script>
@endpush
