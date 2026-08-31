@extends('frontend.layouts.app')

@section('title', 'Features – CareerGuard Platform')
@section('meta_description', 'Everything you need to stay career-ready. CareerGuard offers membership plans, job resources, resume templates, and financial preparedness.')

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
                    <h2 class="mb-10px fw-500">Available for all platforms</h2>
                    <h1 class="mb-0 text-dark-gray fw-700 ls-minus-2px">Features</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- end page title -->

    <!-- start section -->
    <section class="position-relative pt-0">
        <div class="container position-relative z-index-1">
            <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center mb-6 sm-mb-9"
                data-anime='{ "el": "childs", "perspective": [1200,1200], "scale": [1.05, 1], "rotateY": [30, 0], "translateX": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div
                        class="feature-box bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Career Security Starts Here</span>
                            <p>Stay prepared for unexpected career challenges with professional support and financial preparedness solutions.</p>
                        </div>
                    </div>
                </div>
                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div
                        class="feature-box bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Your Career Backup Plan</span>
                            <p>Affordable membership designed for working professionals facing career uncertainty.</p>
                        </div>
                        <span
                            class="position-absolute top-25px right-25px bg-dark-gray border-radius-18px text-white fs-11 fw-700 text-uppercase ps-15px pe-15px lh-26">New</span>
                    </div>
                </div>
                <div class="col icon-with-text-style-04 transition-inner-all mb-30px">
                    <div
                        class="feature-box bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Stay Prepared. Stay Confident.</span>
                            <p>Access career resources, support tools, and structured professional guidance.</p>
                        </div>
                    </div>
                </div>
                <div class="col icon-with-text-style-04 transition-inner-all md-mb-30px">
                    <div
                        class="feature-box bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Built for Modern Professionals</span>
                            <p>Helping employees navigate layoffs, job changes, and uncertain work environments.</p>
                        </div>
                    </div>
                </div>
                <div class="col icon-with-text-style-04 transition-inner-all sm-mb-30px">
                    <div
                        class="feature-box bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">More Than a Job Platform</span>
                            <p>CareerGuard supports your professional journey with preparedness-focused solutions.</p>
                        </div>
                    </div>
                </div>
                <div class="col icon-with-text-style-04 transition-inner-all">
                    <div
                        class="feature-box bg-white text-start justify-content-start h-100 border-radius-6px p-16 lg-p-13 box-shadow-quadruple-large box-shadow-quadruple-large-hover">
                        <div class="feature-box-content last-paragraph-no-margin">
                            <span class="d-inline-block text-dark-gray fw-700 fs-18 mb-5px">Confidence During Career Uncertainty</span>
                            <p>Simple membership plans with long-term career support benefits.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center"
                    data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 250, "easing": "easeOutQuad" }'>
                    <div
                        class="bg-white border border-1 border-color-extra-medium-gray box-shadow-extra-large fw-800 text-dark-gray text-uppercase border-radius-30px ps-20px pe-20px fs-12 me-10px sm-m-10px d-inline-block align-middle">
                        hurray</div>
                    <div class="text-dark-gray d-inline-block align-middle fs-18 fw-600 ls-minus-05px">Subscribe <a
                            href="{{ route('frontend.subscribe') }}"
                            class="fw-800 text-decoration-line-bottom text-dark-gray">CareerGuard</a> and get a special
                        discount.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CareerGuard 15 Features Grid -->
    <style>
        .cg-features-section {
            background: #fafafa;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .cg-feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 35px 28px;
            height: 100%;
            border: 1px solid #f0f0f2;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .cg-feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            border-color: transparent;
        }

        .cg-feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #fff;
            margin-bottom: 22px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .cg-feature-card:nth-child(6n+1) .cg-feature-icon { background: linear-gradient(135deg, #e754a4, #ff6472); }
        .cg-feature-card:nth-child(6n+2) .cg-feature-icon { background: linear-gradient(135deg, #8f76f5, #a65cef); }
        .cg-feature-card:nth-child(6n+3) .cg-feature-icon { background: linear-gradient(135deg, #2dd4bf, #14b8a6); }
        .cg-feature-card:nth-child(6n+4) .cg-feature-icon { background: linear-gradient(135deg, #f59e0b, #f97316); }
        .cg-feature-card:nth-child(6n+5) .cg-feature-icon { background: linear-gradient(135deg, #3b82f6, #6366f1); }
        .cg-feature-card:nth-child(6n+6) .cg-feature-icon { background: linear-gradient(135deg, #10b981, #059669); }

        .cg-feature-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1d2e;
            margin-bottom: 12px;
        }

        .cg-feature-text {
            font-size: 14.5px;
            line-height: 1.65;
            color: #6b6f7e;
            margin: 0;
        }
    </style>

    <section class="cg-features-section">
        <div class="container position-relative">
            <div class="row justify-content-center mb-6 sm-mb-40px">
                <div class="col-lg-8 text-center"
                    data-anime='{ "opacity": [0, 1], "translateY": [30, 0], "duration": 600, "easing": "easeOutCirc" }'>
                    <span class="cg-section-eyebrow">Why CareerGuard</span>
                    <h2 class="cg-section-heading">Everything you need to stay career-ready.</h2>
                    <p class="cg-section-sub">A complete career and financial preparedness platform built for India's growing workforce.</p>
                </div>
            </div>

            <div class="row g-4"
                data-anime='{ "el": "childs", "translateY": [40, 0], "opacity": [0,1], "duration": 700, "delay": 0, "staggervalue": 60, "easing": "easeOutQuad" }'>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <h5 class="cg-feature-title">Career Security</h5>
                        <p class="cg-feature-text">Stay professionally prepared during unexpected job or career challenges with structured support and guidance.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-piggy-bank"></i></div>
                        <h5 class="cg-feature-title">Financial Preparedness</h5>
                        <p class="cg-feature-text">Access eligibility-based financial assistance support designed to help during employment uncertainty.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-tag"></i></div>
                        <h5 class="cg-feature-title">Affordable Membership Plans</h5>
                        <p class="cg-feature-text">Choose budget-friendly monthly membership plans created for working professionals across industries.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-circle-check"></i></div>
                        <h5 class="cg-feature-title">Eligibility-Based Support</h5>
                        <p class="cg-feature-text">Receive support after completing the required active membership period and verification process.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                        <h5 class="cg-feature-title">Career Development Resources</h5>
                        <p class="cg-feature-text">Get access to resume guidance, interview preparation materials, and professional growth resources.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-gauge-high"></i></div>
                        <h5 class="cg-feature-title">Secure Member Dashboard</h5>
                        <p class="cg-feature-text">Manage your membership, track eligibility, upload documents, and access support through a secure platform.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-briefcase"></i></div>
                        <h5 class="cg-feature-title">Job Opportunity Resources</h5>
                        <p class="cg-feature-text">Explore curated job opportunity links and career-related resources to support your professional journey.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <h5 class="cg-feature-title">Easy Membership Management</h5>
                        <p class="cg-feature-text">Simple registration, hassle-free renewals, and easy membership tracking through a user-friendly platform.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cg-feature-card">
                        <div class="cg-feature-icon"><i class="fa-solid fa-user-tie"></i></div>
                        <h5 class="cg-feature-title">Professional Guidance</h5>
                        <p class="cg-feature-text">Receive practical career guidance and preparedness-focused support for long-term career confidence.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
