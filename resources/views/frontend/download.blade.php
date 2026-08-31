@extends('frontend.layouts.app')

@section('title', 'Download CareerGuard App')
@section('meta_description', 'Download the CareerGuard app for Android and iOS. Access membership resources, track status, and stay career-ready on the go.')

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
                    <h2 class="mb-10px fw-500">Join the CareerGuard application</h2>
                    <h1 class="mb-0 text-dark-gray fw-700 ls-minus-2px">Download app</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- end page title -->

    <!-- start section -->
    <section class="pt-0">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10 text-center position-relative animation-float md-mb-30px"
                    data-anime='{ "effect": "slide", "color": "#ffffff", "direction":"lr", "easing": "easeOutQuad", "delay":50}'>
                    <img src="{{ asset('frontend/images/cg-home.png') }}" alt="CareerGuard Mobile App" class="w-100" style="max-width: 80%;">
                </div>
                <div class="col-xl-5 offset-xl-1 col-lg-6 col-md-9 position-relative text-center text-lg-start"
                    data-anime='{ "el": "childs", "opacity": [0, 1], "rotateY": [-90, 0], "rotateZ": [-10, 0], "translateY": [80, 0], "translateZ": [50, 0], "staggervalue": 200, "duration": 900, "easing": "easeOutCirc" }'>
                    <div
                        class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                        Make your journey best</div>
                    <h3 class="fw-700 text-dark-gray w-90 xl-w-100 ls-minus-1px">Get the application for your career security.</h3>
                    <p class="w-85 xs-w-100 mx-auto mx-lg-0">CareerGuard gives you access to career guidance, resume templates, interview Q&A, and membership tracking right at your fingertips.</p>
                    <div
                        class="row mb-35px pe-10 md-ps-25px md-pe-25px sm-px-0 justify-content-center justify-content-lg-start">
                        <div class="col-6 col-lg-6 col-sm-5">
                            <a href="#" class="d-block transition-inner-all">
                                <img src="{{ asset('frontend/images/app-store-black.svg') }}" class="box-shadow-double-large-hover" alt="App Store">
                            </a>
                        </div>
                        <div class="col-6 col-lg-6 col-sm-5">
                            <a href="#" class="d-block transition-inner-all">
                                <img src="{{ asset('frontend/images/play-store-black.svg') }}" class="box-shadow-double-large-hover" alt="Play Store">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
