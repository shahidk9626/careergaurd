@extends('frontend.layouts.app')

@section('title', 'Reviews – CareerGuard Community')
@section('meta_description', 'Read what working professionals say about CareerGuard career support, membership benefits, and financial preparedness.')

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
                    <h2 class="mb-10px fw-500">Our users love this app</h2>
                    <h1 class="mb-0 text-dark-gray fw-700 ls-minus-2px">User reviews</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 text-center position-relative md-mb-30px"
                    data-anime='{ "effect": "slide", "color": "#ffffff", "direction":"lr", "easing": "easeOutQuad", "delay":50}'>
                    <figure>
                        <div class="atropos" data-atropos>
                            <div class="atropos-scale">
                                <div class="atropos-rotate">
                                    <div class="atropos-inner">
                                        <img data-atropos-offset="5" src="{{ asset('frontend/images/demo-application-reviews-01.webp') }}"
                                            alt="" class="sm-w-95 xs-w-85">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </figure>
                </div>
                <div class="col-lg-5 offset-lg-1 sm-mb-30px"
                    data-anime='{ "el": "childs", "opacity": [0, 1], "rotateY": [-90, 0], "rotateZ": [-10, 0], "translateY": [80, 0], "translateZ": [50, 0], "staggervalue": 200, "duration": 900, "easing": "easeOutCirc" }'>
                    <div
                        class="bg-base-color d-inline-block mb-25px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                        Everyone likes</div>
                    <h3 class="fw-700 text-dark-gray w-95 xl-w-100 ls-minus-1px">Stay secure with CareerGuard.</h3>
                    <p class="w-85 xl-w-100 mb-35px sm-25px">Professionals across industries share their trusted CareerGuard experience.</p>
                    <div class="row align-items-center g-0">
                        <div class="col-auto text-center">
                            <h3 class="text-dark-gray fs-65 fw-700 ls-minus-3px mb-0">4.8</h3>
                        </div>
                        <div class="col border-start border-color-extra-medium-gray ms-30px ps-30px text-sm-start">
                            <div class="review-star-icon fs-18 lh-20 mb-10px">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-half"></i>
                            </div>
                            <span class="d-block text-dark-gray lh-20 fw-600">2,488 Genuine rating</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Grid -->
    <section class="pt-0 position-relative">
        <div class="container">
            <div class="row justify-content-center position-relative mb-3">
                <div class="col-xl-6 col-lg-8 col-md-10 text-center"
                    data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div
                        class="d-inline-block bg-base-color fs-12 fw-600 ls-05px text-white text-uppercase border-radius-30px mb-15px ps-20px pe-20px">
                        User Reviews</div>
                    <h3 class="fw-700 text-dark-gray ls-minus-1px">What CareerGuard community are saying.</h3>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center mb-8 position-relative">
                <div class="col transition-inner-all review-style-07 mb-30px">
                    <div class="d-flex h-100 flex-column border-radius-6px p-12 box-shadow-quadruple-large bg-white">
                        <div class="mb-20px">
                            <div class="d-inline-block align-middle">
                                <div class="text-dark-gray fw-700 fs-18">Rajesh Sharma</div>
                                <div class="lh-26 fs-15 fw-500">IT Professional</div>
                            </div>
                        </div>
                        <p class="mb-15px">CareerGuard provided great guidance and peace of mind during a crucial transition period in my IT career.</p>
                        <div class="d-flex align-items-center">
                            <div class="d-inline-block me-auto">
                                <div class="text-dark-gray float-start me-10px fw-700">5.0</div>
                                <div class="review-star-icon float-start">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col transition-inner-all review-style-07 mb-30px">
                    <div class="d-flex h-100 flex-column border-radius-6px p-12 box-shadow-quadruple-large bg-white">
                        <div class="mb-20px">
                            <div class="d-inline-block align-middle">
                                <div class="text-dark-gray fw-700 fs-18">Priya Verma</div>
                                <div class="lh-26 fs-15 fw-500">Corporate Executive</div>
                            </div>
                        </div>
                        <p class="mb-15px">The resume templates and interview preparation resources helped me land my next role quickly and with confidence.</p>
                        <div class="d-flex align-items-center">
                            <div class="d-inline-block me-auto">
                                <div class="text-dark-gray float-start me-10px fw-700">4.8</div>
                                <div class="review-star-icon float-start">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col transition-inner-all review-style-07 mb-30px">
                    <div class="d-flex h-100 flex-column border-radius-6px p-12 box-shadow-quadruple-large bg-white">
                        <div class="mb-20px">
                            <div class="d-inline-block align-middle">
                                <div class="text-dark-gray fw-700 fs-18">Amit Kumar</div>
                                <div class="lh-26 fs-15 fw-500">Sales Lead</div>
                            </div>
                        </div>
                        <p class="mb-15px">Very affordable monthly plan. Knowing there is a backup plan gives immense relief for my family.</p>
                        <div class="d-flex align-items-center">
                            <div class="d-inline-block me-auto">
                                <div class="text-dark-gray float-start me-10px fw-700">5.0</div>
                                <div class="review-star-icon float-start">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
