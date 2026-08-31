@extends('frontend.layouts.app')

@section('title', 'Subscribe & Membership Plans – CareerGuard')
@section('meta_description', 'Explore CareerGuard monthly membership plans: Starter, Basic, Popular, Advanced, and Premium. Get career guidance, job resources, and financial preparedness.')

@section('content')
    <style>
        .bright-pricing-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }

        .bright-pricing-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .card-accent-gray { border-top: 4px solid #e5e7eb; }
        .card-accent-pink { border-top: 4px solid #e754a4; }

        .bright-pricing-card.popular-card {
            box-shadow: 0 15px 35px rgba(231, 84, 164, 0.08);
        }

        .bright-pricing-card.popular-card:hover {
            box-shadow: 0 25px 50px rgba(231, 84, 164, 0.15);
        }

        @media (min-width: 992px) {
            .bright-pricing-card.popular-card {
                transform: scale(1.04);
                z-index: 2;
            }

            .bright-pricing-card.popular-card:hover {
                transform: scale(1.04) translateY(-8px);
            }
        }

        .btn-pricing-standard {
            background-color: #334155;
            color: #ffffff;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-pricing-standard:hover {
            background-color: #475569;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(51, 65, 85, 0.2);
            transform: translateY(-1px);
        }

        .btn-pricing-popular {
            transition: all 0.3s ease;
        }

        .btn-pricing-popular:hover {
            box-shadow: 0 6px 15px rgba(231, 84, 164, 0.3);
            transform: translateY(-1px);
            filter: brightness(1.05);
        }
    </style>

    <!-- start page title / banner -->
    <section class="p-0 cover-background position-relative pb-5"
        style="background-image: url('{{ asset('frontend/images/demo-application-home-banner.jpg') }}'); min-height: 100vh;">

        <div id="particles-style-01" class="h-100 position-absolute left-0px top-0 w-100" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 12,"density": {"enable": true,"value_area": 2000}},"color": {"value": ["#8f76f5", "#a65cef", "#c74ad2", "#e754a4", "#ff6472"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"line_linked":{"enable":false,"distance":0,"color":"#ffffff","opacity":0.4,"width":1},"move": {"enable": true,"speed":1,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'>
        </div>

        <div class="container position-relative z-index-9" style="padding-top: 140px;">
            <div class="row justify-content-center mb-50px sm-mb-30px">
                <div class="col-xl-6 col-lg-8 text-center"
                    data-anime='{ "opacity": [0, 1], "translateY": [30, 0], "duration": 600, "easing": "easeOutCirc" }'>
                    <span class="text-gradient-pink-orange text-uppercase fw-700 ls-1px fs-12 d-block mb-10px">CareerGuard</span>
                    <h1 class="text-dark-gray fw-800 ls-minus-2px fs-50 xl-fs-45 mb-0">Membership Plans</h1>
                </div>
            </div>

            <div class="row justify-content-center g-4"
                data-anime='{ "el": "childs", "translateY": [40, 0], "opacity": [0,1], "duration": 800, "delay": 150, "staggervalue": 100, "easing": "easeOutQuad" }'>

                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="bright-pricing-card card-accent-gray h-100 p-35px text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-medium-gray fw-700 text-uppercase ls-1px fs-12 mb-10px">Starter Membership</div>
                            <div class="text-dark-gray fw-800 fs-35 mb-15px">₹1299<span class="fs-14 text-medium-gray fw-500">/mo</span></div>
                            <div class="fs-13 fw-600 text-dark-gray mb-20px">Best For: Freshers & Entry-Level Professionals</div>
                            <ul class="list-unstyled text-start fs-14 text-medium-gray lh-28 mb-30px px-10px">
                                <li>• Job Opportunity Updates</li>
                                <li>• Resume Templates Access</li>
                                <li>• Interview Questions & Answers</li>
                                <li>• Career Resources</li>
                                <li>• Member Dashboard Access</li>
                                <li>• WhatsApp & Email Notifications</li>
                                <li class="fw-700 text-dark-gray mt-10px">• Financial Assistance Support Up To 20,000*</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-pricing-standard w-100 py-3 border-radius-4px fw-700 text-uppercase ls-05px fs-13">Select Plan</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="bright-pricing-card card-accent-gray h-100 p-35px text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-medium-gray fw-700 text-uppercase ls-1px fs-12 mb-10px">Basic Membership</div>
                            <div class="text-dark-gray fw-800 fs-35 mb-15px">₹1499<span class="fs-14 text-medium-gray fw-500">/mo</span></div>
                            <div class="fs-13 fw-600 text-dark-gray mb-20px">Best For: Early Career Professionals</div>
                            <ul class="list-unstyled text-start fs-14 text-medium-gray lh-28 mb-30px px-10px">
                                <li>• Everything in Starter Plan</li>
                                <li>• Premium Job Updates</li>
                                <li>• Additional Resume Templates</li>
                                <li>• Additional Interview Resources</li>
                                <li>• Priority Notifications</li>
                                <li>• Career Guidance Resources</li>
                                <li class="fw-700 text-dark-gray mt-10px">• Financial Assistance Support Up To 30,000*</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-pricing-standard w-100 py-3 border-radius-4px fw-700 text-uppercase ls-05px fs-13">Select Plan</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="bright-pricing-card popular-card card-accent-pink h-100 p-35px text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-center mb-10px align-items-center">
                                <span class="text-dark-gray fw-800 text-uppercase ls-1px fs-12 me-2">Popular Membership</span>
                                <span class="badge bg-gradient-pink-orange text-white text-uppercase fs-9 fw-700 px-10px py-3px border-radius-2px">Best Choice</span>
                            </div>
                            <div class="text-dark-gray fw-800 fs-35 mb-15px">₹1999<span class="fs-14 text-medium-gray fw-500">/mo</span></div>
                            <div class="fs-13 fw-600 text-dark-gray mb-20px">Best For: Working Professionals</div>
                            <ul class="list-unstyled text-start fs-14 text-medium-gray lh-28 mb-30px px-10px">
                                <li>• Everything in Basic Plan</li>
                                <li>• Premium Career Resources</li>
                                <li>• Priority Support</li>
                                <li>• Advanced Resume Templates</li>
                                <li>• Premium Interview Preparation</li>
                                <li>• Faster Support Response</li>
                                <li class="fw-700 text-dark-gray mt-10px">• Financial Assistance Support Up To 60,000*</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-gradient-pink-orange btn-pricing-popular text-white w-100 py-3 border-radius-4px fw-700 text-uppercase ls-05px fs-13">Select Plan</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="bright-pricing-card card-accent-gray h-100 p-35px text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-medium-gray fw-700 text-uppercase ls-1px fs-12 mb-10px">Advanced Membership</div>
                            <div class="text-dark-gray fw-800 fs-35 mb-15px">₹1999<span class="fs-14 text-medium-gray fw-500">/mo</span></div>
                            <div class="fs-13 fw-600 text-dark-gray mb-20px">Best For: Experienced Professionals</div>
                            <ul class="list-unstyled text-start fs-14 text-medium-gray lh-28 mb-30px px-10px">
                                <li>• Everything in Popular Plan</li>
                                <li>• Advanced Career Resources</li>
                                <li>• Premium Dashboard Features</li>
                                <li>• Higher Priority Support</li>
                                <li>• Professional Growth Resources</li>
                                <li>• Priority Review Process</li>
                                <li class="fw-700 text-dark-gray mt-10px">• Financial Assistance Support Up To 1,20,000*</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-pricing-standard w-100 py-3 border-radius-4px fw-700 text-uppercase ls-05px fs-13">Select Plan</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="bright-pricing-card card-accent-gray h-100 p-35px text-center d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-medium-gray fw-700 text-uppercase ls-1px fs-12 mb-10px">Premium Membership</div>
                            <div class="text-dark-gray fw-800 fs-35 mb-15px">₹12,999<span class="fs-14 text-medium-gray fw-500">/mo</span></div>
                            <div class="fs-13 fw-600 text-dark-gray mb-20px">Best For: Senior Professionals & Managers</div>
                            <ul class="list-unstyled text-start fs-14 text-medium-gray lh-28 mb-30px px-10px">
                                <li>• Everything in Advanced Plan</li>
                                <li>• VIP Priority Support</li>
                                <li>• Dedicated Assistance</li>
                                <li>• Premium Career Resources</li>
                                <li>• Executive-Level Templates</li>
                                <li>• Fastest Review & Response</li>
                                <li class="fw-700 text-dark-gray mt-10px">• Financial Assistance Support Up To 2,00,000*</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-pricing-standard w-100 py-3 border-radius-4px fw-700 text-uppercase ls-05px fs-13">Select Plan</a>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="bg-white border-radius-8px p-4 box-shadow-small text-center">
                        <h6 class="text-dark-gray fw-700 mb-15px fs-16">Important Note</h6>
                        <p class="fs-13 text-medium-gray mb-10px">Financial Assistance Support is subject to eligibility verification, active membership status, document review, and internal assessment.</p>
                        <p class="fs-13 text-medium-gray mb-10px">The assistance amount is calculated based on the nature of employment separation, including layoff, termination, resignation, company closure, workforce reduction, or other employment-related circumstances.</p>
                        <p class="fs-13 text-medium-gray mb-10px">Each case will be reviewed individually, and the approved support amount may vary accordingly.</p>
                        <p class="fs-13 fw-600 text-dark-gray mb-0">CareerGuard is a membership-based career support platform and not an insurance company.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
