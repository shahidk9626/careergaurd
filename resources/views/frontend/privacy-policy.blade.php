@extends('frontend.layouts.app')

@section('title', 'Privacy Policy – CareerGuard')
@section('meta_description', 'Privacy Policy of CareerGuard. Learn what information we collect, how we use it, and how we keep it safe.')

@section('content')
    <!-- start page title section -->
    <section class="cover-background position-relative pt-7 pb-7"
        style="background-image: url('{{ asset('frontend/images/demo-application-home-banner.jpg') }}'); min-height: 60vh;">
        <div id="particles-style-01" class="h-100 position-absolute left-0px top-0 w-100" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 12,"density": {"enable": true,"value_area": 2000}},"color": {"value": ["#8f76f5", "#a65cef", "#c74ad2", "#e754a4", "#ff6472"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"line_linked":{"enable":false,"distance":0,"color":"#ffffff","opacity":0.4,"width":1},"move": {"enable": true,"speed":1,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'>
        </div>
        <div class="container position-relative z-index-9 pt-5 mt-5">
            <div class="row justify-content-center text-center"
                data-anime='{ "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="col-lg-8">
                    <div
                        class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                        Legal Document</div>
                    <h1 class="fw-700 text-dark-gray ls-minus-2px mb-20px">Privacy Policy</h1>
                    <p class="text-medium-gray fs-18 w-85 mx-auto mb-20px">Your privacy matters. This policy explains
                        what information we collect, how we use it, and how we keep it safe at CareerGuard.</p>
                    <div
                        class="d-inline-block bg-white border border-1 border-color-extra-medium-gray fw-600 text-dark-gray border-radius-30px ps-20px pe-20px fs-13 lh-32 box-shadow-large">
                        <i class="feather icon-feather-calendar me-5px text-base-color"></i> Effective Date: 14 May 2026
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative z-index-2">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-4 md-mb-50px">
                    <div class="bg-linen border-radius-6px p-6 sm-p-5 sticky-top" style="top: 100px;">
                        <div
                            class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                            On this page</div>
                        <ul class="p-0 list-style-02">
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-1" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">01.</span>Information We Collect</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-2" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">02.</span>Purpose of Collection</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-3" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">03.</span>Document Verification</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-4" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">04.</span>Payment Information</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-5" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">05.</span>Communication Consent</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-6" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">06.</span>Data Security</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-7" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">07.</span>Membership Renewal</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-8" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">08.</span>Third Party Services</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-9" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">09.</span>Information Sharing</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-10" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">10.</span>Disclaimer</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-11" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">11.</span>Member Responsibility</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-12" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">12.</span>Website Usage</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-13" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">13.</span>Policy Updates</a></li>
                            <li class="pt-10px pb-10px"><a href="#section-14" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">14.</span>Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="box-shadow-quadruple-large border-radius-6px bg-white p-7 md-p-6 sm-p-5">

                        <div class="pb-30px mb-30px border-bottom border-color-extra-medium-gray">
                            <p class="text-dark-gray fs-16 lh-30 mb-0">At <strong class="fw-700">CareerGuard</strong>, protecting your personal information is a core part of how we operate. This Privacy Policy explains the types of information we collect, how it's used, and the steps we take to keep it secure.</p>
                        </div>

                        <div class="mb-40px" id="section-1" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">01. Information We Collect</h4>
                            <p class="lh-30 mb-15px">We may collect full name, mobile & WhatsApp number, email address, city/pincode, profession, identity proof, employment documents, payment info, and claim files.</p>
                        </div>

                        <div class="mb-40px" id="section-2" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">02. Purpose of Collection</h4>
                            <p class="lh-30 mb-15px">Used for membership registration, verification, customer support, payment processing, claim review, and sending updates.</p>
                        </div>

                        <div class="mb-40px" id="section-3" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">03. Document Verification</h4>
                            <p class="lh-30 mb-10px">Documents are used strictly for verification, eligibility review, and support purposes.</p>
                        </div>

                        <div class="mb-40px" id="section-4" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">04. Payment Information</h4>
                            <p class="lh-30 mb-15px">Processed securely through third-party payment gateways. CareerGuard does not store complete banking credentials.</p>
                        </div>

                        <div class="mb-40px" id="section-5" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">05. Communication Consent</h4>
                            <p class="lh-30 mb-15px">By registering, you agree to receive WhatsApp, SMS, email, and renewal notifications.</p>
                        </div>

                        <div class="mb-40px" id="section-6" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">06. Data Security</h4>
                            <p class="lh-30 mb-10px">We implement reasonable technical and organizational measures to safeguard user data.</p>
                        </div>

                        <div class="mb-40px" id="section-7" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">07. Membership Renewal</h4>
                            <p class="lh-30 mb-10px">Renewals ensure continuous eligibility. Failure to renew may pause access to support benefits.</p>
                        </div>

                        <div class="mb-40px" id="section-8" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">08. Third Party Services</h4>
                            <p class="lh-30 mb-10px">Third-party service providers assist in payment, notification, and hosting operations.</p>
                        </div>

                        <div class="mb-40px" id="section-9" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">09. Information Sharing</h4>
                            <p class="lh-30 mb-10px">We do not sell user data. Sharing occurs only as required by law or verification purposes.</p>
                        </div>

                        <div class="mb-40px" id="section-10" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">10. Disclaimer</h4>
                            <p class="lh-30 mb-10px">CareerGuard is a membership support platform, not an insurance company. Assistance is subject to eligibility.</p>
                        </div>

                        <div class="mb-40px" id="section-11" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">11. Member Responsibility</h4>
                            <p class="lh-30 mb-10px">Members must provide accurate info and maintain credential security.</p>
                        </div>

                        <div class="mb-40px" id="section-12" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">12. Website Usage</h4>
                            <p class="lh-30 mb-10px">Misuse or fraudulent activity will lead to immediate account suspension.</p>
                        </div>

                        <div class="mb-40px" id="section-13" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">13. Policy Updates</h4>
                            <p class="lh-30 mb-10px">Updates will be published directly on this website page.</p>
                        </div>

                        <div class="mb-30px" id="section-14" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">14. Contact Us</h4>
                            <p class="lh-30 mb-10px">Contact support@careerguard.in or +91 8123190776 for privacy queries.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
