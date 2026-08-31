@extends('frontend.layouts.app')

@section('title', 'Terms & Conditions – CareerGuard')
@section('meta_description', 'Terms & Conditions of CareerGuard. Read our policies regarding membership, claims, payments, and platform usage.')

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
                    <h1 class="fw-700 text-dark-gray ls-minus-2px mb-20px">Terms &amp; Conditions</h1>
                    <p class="text-medium-gray fs-18 w-85 mx-auto mb-20px">Please read these Terms &amp; Conditions carefully before registering, making a payment, or using CareerGuard services.</p>
                    <div
                        class="d-inline-block bg-white border border-1 border-color-extra-medium-gray fw-600 text-dark-gray border-radius-30px ps-20px pe-20px fs-13 lh-32 box-shadow-large">
                        <i class="feather icon-feather-calendar me-5px text-base-color"></i> Effective Date: 14 May 2026
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- start terms content section -->
    <section class="position-relative z-index-2">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-4 md-mb-50px">
                    <div class="bg-linen border-radius-6px p-6 sm-p-5 sticky-top" style="top: 100px;">
                        <div
                            class="bg-base-color d-inline-block mb-20px fw-600 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-12">
                            On this page</div>
                        <ul class="p-0 list-style-02">
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-1" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">01.</span>About CareerGuard</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-2" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">02.</span>Membership Eligibility</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-3" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">03.</span>Membership Plans</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-4" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">04.</span>Duration & Renewal</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-5" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">05.</span>Eligibility Period</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-6" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">06.</span>Financial Assistance</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-7" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">07.</span>Claim Documents</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-8" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">08.</span>Member Responsibilities</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-9" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">09.</span>Job & Career Content</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-10" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">10.</span>Business Opportunities</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-11" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">11.</span>Payment Terms</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-12" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">12.</span>Refund Policy</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-13" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">13.</span>Website Usage</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-14" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">14.</span>Limitation of Liability</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-15" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">15.</span>Privacy & Data</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-16" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">16.</span>Modification of Terms</a></li>
                            <li class="pt-10px pb-10px border-bottom border-color-transparent-dark-very-light"><a href="#section-17" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">17.</span>Termination</a></li>
                            <li class="pt-10px pb-10px"><a href="#section-18" class="text-dark-gray fw-600 fs-14"><span class="text-base-color fw-700 me-10px">18.</span>Contact Information</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="box-shadow-quadruple-large border-radius-6px bg-white p-7 md-p-6 sm-p-5">
                        <div class="pb-30px mb-30px border-bottom border-color-extra-medium-gray">
                            <p class="text-dark-gray fs-16 lh-30 mb-0">Welcome to <strong class="fw-700">CareerGuard</strong>. These Terms &amp; Conditions govern your access to and use of CareerGuard's membership platform, services, and resources.</p>
                        </div>

                        <div class="mb-40px" id="section-1" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">01. About CareerGuard</h4>
                            <p class="lh-30 mb-0">CareerGuard is a membership-based support platform for working professionals. CareerGuard is not an insurance company and does not sell insurance policies.</p>
                        </div>

                        <div class="mb-40px" id="section-2" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">02. Membership Eligibility</h4>
                            <p class="lh-30 mb-0">Membership requires accurate information and plan selection. CareerGuard reserves the right to approve or decline applications.</p>
                        </div>

                        <div class="mb-40px" id="section-3" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">03. Membership Plans</h4>
                            <p class="lh-30 mb-0">Plans vary by tier and features. Plan details and pricing are available on the website.</p>
                        </div>

                        <div class="mb-40px" id="section-4" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">04. Duration & Renewal</h4>
                            <p class="lh-30 mb-0">Subscriptions require timely renewal to maintain continuous support services and benefits.</p>
                        </div>

                        <div class="mb-40px" id="section-5" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">05. Eligibility Period</h4>
                            <p class="lh-30 mb-0">Minimum active membership duration is required prior to submitting financial assistance claims.</p>
                        </div>

                        <div class="mb-40px" id="section-6" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">06. Financial Assistance Support</h4>
                            <p class="lh-30 mb-0">Financial assistance is subject to eligibility verification and internal assessment. Approval is not guaranteed.</p>
                        </div>

                        <div class="mb-40px" id="section-7" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">07. Claim Documents</h4>
                            <p class="lh-30 mb-0">Valid identity and termination documents must be provided when submitting support requests.</p>
                        </div>

                        <div class="mb-40px" id="section-8" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">08. Member Responsibilities</h4>
                            <p class="lh-30 mb-0">Members must maintain account security and provide truthful documentation.</p>
                        </div>

                        <div class="mb-40px" id="section-9" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">09. Job & Career Content</h4>
                            <p class="lh-30 mb-0">Career guidance materials are for informational purposes and do not guarantee placement.</p>
                        </div>

                        <div class="mb-40px" id="section-10" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">10. Business Opportunities</h4>
                            <p class="lh-30 mb-0">Franchise or business info is informational; earnings are not guaranteed.</p>
                        </div>

                        <div class="mb-40px" id="section-11" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">11. Payment Terms</h4>
                            <p class="lh-30 mb-0">Payments must be made via authorized payment channels.</p>
                        </div>

                        <div class="mb-40px" id="section-12" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">12. Refund Policy</h4>
                            <p class="lh-30 mb-0">Fees are non-refundable once dashboard access is enabled. Refer to Refund Policy page.</p>
                        </div>

                        <div class="mb-40px" id="section-13" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">13. Website Usage Restrictions</h4>
                            <p class="lh-30 mb-0">Unauthorized system access or fraudulent uploads are strictly prohibited.</p>
                        </div>

                        <div class="mb-40px" id="section-14" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">14. Limitation of Liability</h4>
                            <p class="lh-30 mb-0">CareerGuard is not liable for indirect damages or job market changes.</p>
                        </div>

                        <div class="mb-40px" id="section-15" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">15. Privacy & Data Protection</h4>
                            <p class="lh-30 mb-0">Data collection is governed by our Privacy Policy.</p>
                        </div>

                        <div class="mb-40px" id="section-16" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">16. Modification of Terms</h4>
                            <p class="lh-30 mb-0">Terms are subject to updates, published directly on this website.</p>
                        </div>

                        <div class="mb-40px" id="section-17" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">17. Termination of Membership</h4>
                            <p class="lh-30 mb-0">Misconduct or fraud will result in immediate membership termination.</p>
                        </div>

                        <div class="mb-30px" id="section-18" style="scroll-margin-top: 100px;">
                            <h4 class="fw-700 text-dark-gray ls-minus-05px mb-15px">18. Contact Information</h4>
                            <p class="lh-30 mb-0">Support email: support@careerguard.in | Phone: +91 8123190776</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
