@extends('frontend.layouts.app')

@section('title', 'How It Works – CareerGuard Membership')
@section('meta_description', 'Simple steps to protect your future. Learn how CareerGuard membership works from choosing a plan to maintaining active support.')

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
                    <h2 class="mb-10px fw-500">Simple steps to protect your future</h2>
                    <h1 class="mb-0 text-dark-gray fw-700 ls-minus-2px">How it works</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-5 row-cols-sm-2 justify-content-center g-0"
                data-anime='{ "el": "childs", "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

                <div class="col process-step-style-06 text-center last-paragraph-no-margin hover-box md-mb-50px">
                    <h5 class="d-block text-dark-gray mb-0 fw-700 ls-minus-2px">01</h5>
                    <div class="process-step-icon-box position-relative mt-25px mb-25px">
                        <span class="progress-step-separator bg-dark-gray w-100 separator-line-1px opacity-1"></span>
                        <div
                            class="step-box d-flex align-items-center justify-content-center bg-linen border-radius-100 mx-auto w-30px h-30px">
                            <span class="w-8px h-8px bg-base-color border-radius-100"></span>
                        </div>
                    </div>
                    <span class="d-inline-block alt-font fw-700 text-dark-gray fs-16 mb-5px">Choose Membership Plan</span>
                    <p class="w-85 d-inline-block fs-14">Select the coverage level that aligns with your active career path.</p>
                </div>

                <div class="col process-step-style-06 text-center last-paragraph-no-margin hover-box md-mb-50px">
                    <h5 class="d-block text-dark-gray mb-0 fw-700 ls-minus-2px">02</h5>
                    <div class="process-step-icon-box position-relative mt-25px mb-25px">
                        <span class="progress-step-separator bg-dark-gray w-100 separator-line-1px opacity-1"></span>
                        <div
                            class="step-box d-flex align-items-center justify-content-center bg-linen border-radius-100 mx-auto w-30px h-30px">
                            <span class="w-8px h-8px bg-base-color border-radius-100"></span>
                        </div>
                    </div>
                    <span class="d-inline-block alt-font fw-700 text-dark-gray fs-16 mb-5px">Pay Monthly Membership</span>
                    <p class="w-85 d-inline-block fs-14">Keep your subscription modern, predictable, and fully automated.</p>
                </div>

                <div class="col process-step-style-06 text-center last-paragraph-no-margin hover-box md-mb-50px">
                    <h5 class="d-block text-dark-gray mb-0 fw-700 ls-minus-2px">03</h5>
                    <div class="process-step-icon-box position-relative mt-25px mb-25px">
                        <span class="progress-step-separator bg-dark-gray w-100 separator-line-1px opacity-1"></span>
                        <div
                            class="step-box d-flex align-items-center justify-content-center bg-linen border-radius-100 mx-auto w-30px h-30px">
                            <span class="w-8px h-8px bg-base-color border-radius-100"></span>
                        </div>
                    </div>
                    <span class="d-inline-block alt-font fw-700 text-dark-gray fs-16 mb-5px">Maintain Active Membership</span>
                    <p class="w-85 d-inline-block fs-14">Continuous protection builds stability and secures long-term privileges.</p>
                </div>

                <div class="col process-step-style-06 text-center last-paragraph-no-margin hover-box xs-mb-50px">
                    <h5 class="d-block text-dark-gray mb-0 fw-700 ls-minus-2px">04</h5>
                    <div class="process-step-icon-box position-relative mt-25px mb-25px">
                        <span class="progress-step-separator bg-dark-gray w-100 separator-line-1px opacity-1"></span>
                        <div
                            class="step-box d-flex align-items-center justify-content-center bg-linen border-radius-100 mx-auto w-30px h-30px">
                            <span class="w-8px h-8px bg-base-color border-radius-100"></span>
                        </div>
                    </div>
                    <span class="d-inline-block alt-font fw-700 text-dark-gray fs-16 mb-5px">Submit Request</span>
                    <p class="w-85 d-inline-block fs-14">File a claim smoothly if an eligible career milestone challenge occurs.</p>
                </div>

                <div class="col process-step-style-06 text-center last-paragraph-no-margin hover-box">
                    <h5 class="d-block text-dark-gray mb-0 fw-700 ls-minus-2px">05</h5>
                    <div class="process-step-icon-box position-relative mt-25px mb-25px">
                        <span
                            class="progress-step-separator bg-dark-gray w-100 separator-line-1px opacity-1 d-lg-none"></span>
                        <div
                            class="step-box d-flex align-items-center justify-content-center bg-linen border-radius-100 mx-auto w-30px h-30px">
                            <span class="w-8px h-8px bg-base-color border-radius-100"></span>
                        </div>
                    </div>
                    <span class="d-inline-block alt-font fw-700 text-dark-gray fs-16 mb-5px">Review & Support Process</span>
                    <p class="w-85 d-inline-block fs-14">Our professional team handles advisory tracking and legal support.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- App presentation section -->
    <section class="pt-0 overflow-hidden sm-pb-17 xs-pb-25">
        <div class="container-fluid ps-10 xxl-ps-6 sm-ps-30px sm-pe-30px">
            <div class="row justify-content-center">
                <div class="col-12 cover-background overflow-visible ps-8 pe-8 xxl-ps-6 xxl-pe-6 lg-ps-4 lg-pe-4 pt-8 xxl-pt-6 lg-pt-4 xl-pb-2 md-p-8 md-pb-3 border-radius-top-left sm-border-radius-all"
                    style="background-image: url('{{ asset('frontend/images/demo-application-how-it-works-bg-01.jpg') }}')">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 position-relative mt-40px xxl-mt-10px lg-mt-40px md-mt-0 md-mb-50px text-center text-lg-start"
                            data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                            <div
                                class="bg-white-transparent-very-light d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                                App presentation</div>
                            <h3 class="fw-600 text-white w-90 xl-w-100 ls-minus-1px">How to working Career Guard Application.</h3>
                            <p class="w-85 xl-w-100 mb-40px md-mb-35px">CareerGuard helps professionals stay prepared, confident, and supported during uncertain career situations.</p>
                            <a href="{{ route('frontend.download') }}"
                                class="btn btn-large btn-rounded btn-base-color btn-box-shadow">Download now</a>
                        </div>
                        <div class="col-xl-8 col-lg-7"
                            data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                            <div
                                class="outside-box-right-10 md-outside-box-right-20 sm-outside-box-right-0 margin-minus-95px-bottom md-margin-minus-60px-bottom">
                                <div class="swiper slider-one-slide magic-cursor drag-cursor"
                                    data-slider-options='{ "slidesPerView": 1, "spaceBetween": 20, "loop": true, "autoplay": { "delay": 4000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 3, "spaceBetween": 60 }, "992": { "slidesPerView": 2, "spaceBetween": 40 }, "768": { "slidesPerView": 3, "spaceBetween": 25 }, "576": { "slidesPerView": 2 } }, "effect": "slide" }'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide text-center">
                                            <img src="{{ asset('frontend/images/how_we_working-01.png') }}" class="w-100" alt="">
                                        </div>
                                        <div class="swiper-slide text-center">
                                            <img src="{{ asset('frontend/images/how_we_working-02.png') }}" class="w-100" alt="">
                                        </div>
                                        <div class="swiper-slide text-center">
                                            <img src="{{ asset('frontend/images/how_we_working-03.png') }}" class="w-100" alt="">
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

    <!-- FAQ Help section -->
    <section class="bg-white position-relative">
        <div class="container">
            <div class="row justify-content-center position-relative mb-2">
                <div class="col-md-8 text-center"
                    data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div
                        class="bg-base-color d-inline-block mb-15px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                        Frequently Asked Questions</div>
                    <h3 class="text-dark-gray fw-700 ls-minus-1px">How can we help?</h3>
                </div>
            </div>
            <div class="row justify-content-center position-relative">
                <div class="col-xl-10 col-lg-11">
                    <div class="row row-cols-1 row-cols-md-2 justify-content-center"
                        data-anime='{ "el": "childs", "perspective": [1200,1200], "translateY": [30, 0], "scale": [1.05, 1], "rotateX": [30, 0], "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <div class="col mb-30px">
                            <div
                                class="text-start box-shadow-extra-large bg-white h-100 border-radius-4px p-10 overflow-hidden last-paragraph-no-margin">
                                <span class="d-inline-block alt-font fs-18 fw-700 ls-minus-05px text-dark-gray mb-5px">Eligibility & Support Assistance</span>
                                <p>Need clarity about eligibility requirements or support requests? Our team is here to guide you through the process.</p>
                            </div>
                        </div>
                        <div class="col mb-30px">
                            <div
                                class="text-start box-shadow-extra-large bg-white h-100 border-radius-4px p-10 overflow-hidden last-paragraph-no-margin">
                                <span class="d-inline-block alt-font fs-18 fw-700 ls-minus-05px text-dark-gray mb-5px">Account & Dashboard Support</span>
                                <p>Receive help with membership tracking, payment history, resource access, notifications, and dashboard management.</p>
                            </div>
                        </div>
                        <div class="col sm-mb-30px">
                            <div
                                class="text-start box-shadow-extra-large bg-white h-100 border-radius-4px p-10 overflow-hidden last-paragraph-no-margin">
                                <span class="d-inline-block alt-font fs-18 fw-700 ls-minus-05px text-dark-gray mb-5px">Career Transition Support</span>
                                <p>Facing employment uncertainty? We help professionals stay prepared with structured guidance and member-focused support.</p>
                            </div>
                        </div>
                        <div class="col">
                            <div
                                class="text-start box-shadow-extra-large bg-white h-100 border-radius-4px p-10 overflow-hidden last-paragraph-no-margin">
                                <span class="d-inline-block alt-font fs-18 fw-700 ls-minus-05px text-dark-gray mb-5px">Business & Franchise Opportunities</span>
                                <p>Explore self-employment ideas, business opportunities, and franchise-related guidance for additional career growth options.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
