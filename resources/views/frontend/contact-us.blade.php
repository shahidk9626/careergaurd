@extends('frontend.layouts.app')

@section('title', 'Contact Us – CareerGuard')
@section('meta_description', 'Need help? Contact the CareerGuard support team for assistance with plans, membership, and career support services.')

@section('content')
    <style>
        .contact-form .form-control {
            border: 1px solid #e4e4e4;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 15px;
            background: #f9f9fa;
            transition: all 0.3s ease;
            height: 55px;
        }

        textarea.form-control {
            height: auto !important;
        }

        .contact-form .form-control:focus {
            border-color: #e754a4;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(231, 84, 164, 0.08);
        }

        .contact-form label {
            font-weight: 600;
            color: #232323;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .contact-info-card {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .contact-info-card:hover {
            transform: translateY(-5px);
        }

        .contact-info-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e754a4, #ff6472);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn-callback {
            background: linear-gradient(135deg, #e754a4, #ff6472);
            color: #fff;
            border: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
            box-shadow: 0 10px 30px rgba(231, 84, 164, 0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-callback i {
            margin-left: 10px;
        }

        .btn-callback:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(231, 84, 164, 0.4);
            color: #fff;
        }

        .phone-input-wrap {
            display: flex;
            gap: 8px;
            align-items: stretch;
            position: relative;
        }

        .country-picker {
            position: relative;
            flex: 0 0 auto;
        }

        .country-trigger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 55px;
            padding: 0 12px;
            background: #f9f9fa;
            border: 1px solid #e4e4e4;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            color: #232323;
            transition: all 0.25s ease;
            white-space: nowrap;
            min-width: 100px;
        }

        .country-trigger:hover { background: #fff; }

        .country-trigger.open, .country-trigger:focus {
            outline: none;
            border-color: #e754a4;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(231, 84, 164, 0.08);
        }

        .country-trigger img {
            width: 22px;
            height: auto;
            border-radius: 2px;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
        }

        .country-trigger .arrow {
            margin-left: auto;
            font-size: 10px;
            color: #888;
            transition: transform 0.25s;
        }

        .country-trigger.open .arrow { transform: rotate(180deg); }

        .country-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            min-width: 280px;
            max-width: 320px;
            max-height: 320px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #e4e4e4;
            border-radius: 10px;
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12);
            z-index: 1000;
            padding: 6px 0;
            display: none;
        }

        .country-dropdown.open {
            display: block;
            animation: dropdownIn 0.18s ease-out;
        }

        @keyframes dropdownIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .country-search {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 8px 10px;
            border-bottom: 1px solid #f0f0f0;
            z-index: 2;
        }

        .country-search input {
            width: 100%;
            height: 38px;
            border: 1px solid #e4e4e4;
            border-radius: 6px;
            padding: 0 12px;
            font-size: 14px;
            font-family: inherit;
            background: #f9f9fa;
            outline: none;
        }

        .country-search input:focus {
            border-color: #e754a4;
            background: #fff;
        }

        .country-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            cursor: pointer;
            transition: background 0.15s;
            font-size: 14px;
            color: #232323;
        }

        .country-option:hover, .country-option.highlight { background: #f7f7f9; }

        .country-option img {
            width: 24px;
            height: auto;
            border-radius: 2px;
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
        }

        .country-option .name {
            flex: 1 1 auto;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .country-option .code {
            color: #888;
            font-size: 13px;
            font-weight: 500;
            flex-shrink: 0;
        }

        .country-empty {
            padding: 14px;
            text-align: center;
            color: #999;
            font-size: 13px;
            font-style: italic;
        }

        .phone-number-input {
            flex: 1 1 auto;
            min-width: 0;
        }

        @media (max-width: 480px) {
            .country-trigger {
                min-width: 92px;
                padding: 0 10px;
                font-size: 14px;
                gap: 5px;
            }

            .country-trigger img { width: 20px; }
            .country-dropdown { min-width: 260px; max-width: calc(100vw - 60px); }
        }
    </style>

    <section class="p-0 cover-background position-relative d-flex align-items-center"
        style="background-image: url('{{ asset('frontend/images/demo-application-home-banner.jpg') }}'); min-height: 60vh;">
        <div id="particles-style-01" class="h-100 position-absolute left-0px top-0 w-100" data-particle="true"
            data-particle-options='{"particles": {"number": {"value": 12,"density": {"enable": true,"value_area": 2000}},"color": {"value": ["#8f76f5", "#a65cef", "#c74ad2", "#e754a4", "#ff6472"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"line_linked":{"enable":false,"distance":0,"color":"#ffffff","opacity":0.4,"width":1},"move": {"enable": true,"speed":1,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'>
        </div>
        <div class="container position-relative z-index-9 pt-5 mt-5">
            <div class="row justify-content-center text-center">
                <div class="col-xl-7 col-lg-9"
                    data-anime='{ "opacity": [0, 1], "translateY": [30, 0], "duration": 600, "easing": "easeOutCirc" }'>
                    <span class="text-gradient-pink-orange text-uppercase fw-700 ls-1px fs-12 d-block mb-15px">We're here for you</span>
                    <h1 class="text-dark-gray fw-800 ls-minus-2px fs-55 xl-fs-45 mb-20px">Need Help? Contact Our Support Team.</h1>
                    <p class="fs-18 text-medium-gray w-85 mx-auto">Have questions about our plans or need assistance with your account? Our team is ready to help you every step of the way.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 py-lg-6">
        <div class="container">
            <div class="row justify-content-center g-4"
                data-anime='{ "el": "childs", "translateY": [40, 0], "opacity": [0,1], "duration": 800, "delay": 150, "staggervalue": 100, "easing": "easeOutQuad" }'>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-card text-center">
                        <div class="contact-info-icon mx-auto"><i class="fa-solid fa-envelope"></i></div>
                        <h5 class="fw-700 text-dark-gray mb-10px">Email Us</h5>
                        <p class="text-medium-gray mb-10px">Drop us a line, we'll get back to you soon.</p>
                        <a href="mailto:support@careerguard.in" class="text-dark-gray fw-600 fs-15">support@careerguard.in</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-card text-center">
                        <div class="contact-info-icon mx-auto" style="background: linear-gradient(135deg, #25D366, #128C7E);">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <h5 class="fw-700 text-dark-gray mb-10px">WhatsApp Us</h5>
                        <p class="text-medium-gray mb-10px">Chat with our team for quick support.</p>
                        <a href="https://wa.me/919611956627" target="_blank" rel="noopener noreferrer" class="text-dark-gray fw-600 fs-15">+91 8123190776</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-info-card text-center">
                        <div class="contact-info-icon mx-auto" style="background: linear-gradient(135deg, #8f76f5, #a65cef);">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h5 class="fw-700 text-dark-gray mb-10px">Visit Website</h5>
                        <p class="text-medium-gray mb-10px">Learn more about CareerGuard online.</p>
                        <a href="https://www.careerguard.in" class="text-dark-gray fw-600 fs-15">www.careerguard.in</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 py-lg-6 bg-very-light-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-10">
                    <div class="bg-white border-radius-10px box-shadow-quadruple-large p-7 lg-p-5 sm-p-4">
                        <div class="row justify-content-center mb-40px">
                            <div class="col-lg-9 text-center"
                                data-anime='{ "opacity": [0, 1], "translateY": [30, 0], "duration": 600, "easing": "easeOutCirc" }'>
                                <span class="text-gradient-pink-orange text-uppercase fw-700 ls-1px fs-12 d-block mb-10px">Request a callback</span>
                                <h2 class="text-dark-gray fw-800 ls-minus-1px fs-35 mb-15px">Let's get in touch</h2>
                                <p class="text-medium-gray">Fill in the form below and our support team will contact you shortly.</p>
                            </div>
                        </div>

                        <form action="https://formsubmit.co/support@careerguard.in" method="POST" class="contact-form row g-4">
                            <input type="hidden" name="_subject" value="New Callback Request - CareerGuard">
                            <input type="hidden" name="_captcha" value="false">

                            <div class="col-md-6">
                                <label for="contactName">Name <span class="text-danger">*</span></label>
                                <input type="text" id="contactName" name="name" class="form-control required" placeholder="Enter your full name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="contactMobile">Mobile Number <span class="text-danger">*</span></label>
                                <div class="phone-input-wrap">
                                    <div class="country-picker" id="countryPicker">
                                        <button type="button" class="country-trigger" id="countryTrigger" aria-label="Select country code">
                                            <img id="triggerFlag" src="https://flagcdn.com/w40/in.png" alt="">
                                            <span id="triggerCode">+91</span>
                                            <i class="arrow fa-solid fa-chevron-down"></i>
                                        </button>
                                        <div class="country-dropdown" id="countryDropdown" role="listbox">
                                            <div class="country-search">
                                                <input type="text" id="countrySearch" placeholder="Search country..." autocomplete="off">
                                            </div>
                                            <div id="countryList"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="countryCode" name="country_code" value="+91">
                                    <input type="tel" id="contactMobile" name="mobile"
                                        class="form-control phone-number-input required" placeholder="Mobile number"
                                        required oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        maxlength="15">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="contactEmail">Email <span class="text-danger">*</span></label>
                                <input type="email" id="contactEmail" name="email" class="form-control required" placeholder="you@example.com" required>
                            </div>

                            <div class="col-md-6">
                                <label for="contactCity">City <span class="text-danger">*</span></label>
                                <input type="text" id="contactCity" name="city" class="form-control required" placeholder="Your city" required>
                            </div>

                            <div class="col-12">
                                <label for="contactMessage">Message <span class="text-danger">*</span></label>
                                <textarea id="contactMessage" name="message" rows="5" class="form-control required" placeholder="Tell us how we can help you..." required></textarea>
                            </div>

                            <div class="col-12 text-center mt-30px">
                                <button type="submit" class="btn-callback">
                                    Request Call Back <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <div class="col-12 text-center mt-20px">
                                <p class="fs-13 text-medium-gray mb-0">
                                    <i class="fa-solid fa-lock me-5px"></i>
                                    Your information is safe with us. We respect your privacy.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        var COUNTRIES = [
            ['in', '+91', 'India'],
            ['us', '+1', 'United States'],
            ['gb', '+44', 'United Kingdom'],
            ['ae', '+971', 'United Arab Emirates'],
            ['sg', '+65', 'Singapore'],
            ['au', '+61', 'Australia'],
            ['ca', '+1', 'Canada'],
            ['fr', '+33', 'France'],
            ['de', '+49', 'Germany'],
            ['jp', '+81', 'Japan'],
            ['cn', '+86', 'China'],
            ['pk', '+92', 'Pakistan'],
            ['bd', '+880', 'Bangladesh'],
            ['lk', '+94', 'Sri Lanka'],
            ['np', '+977', 'Nepal'],
            ['sa', '+966', 'Saudi Arabia'],
            ['qa', '+974', 'Qatar'],
            ['om', '+968', 'Oman'],
            ['kw', '+965', 'Kuwait'],
            ['bh', '+973', 'Bahrain'],
            ['my', '+60', 'Malaysia'],
            ['th', '+66', 'Thailand'],
            ['id', '+62', 'Indonesia'],
            ['ph', '+63', 'Philippines'],
            ['vn', '+84', 'Vietnam'],
            ['nz', '+64', 'New Zealand'],
            ['za', '+27', 'South Africa'],
            ['ng', '+234', 'Nigeria'],
            ['ke', '+254', 'Kenya'],
            ['eg', '+20', 'Egypt'],
            ['it', '+39', 'Italy'],
            ['es', '+34', 'Spain'],
            ['nl', '+31', 'Netherlands'],
            ['se', '+46', 'Sweden'],
            ['ch', '+41', 'Switzerland'],
            ['ie', '+353', 'Ireland'],
            ['br', '+55', 'Brazil'],
            ['mx', '+52', 'Mexico'],
            ['ru', '+7', 'Russia'],
            ['tr', '+90', 'Turkey']
        ];

        var trigger = document.getElementById('countryTrigger');
        var dropdown = document.getElementById('countryDropdown');
        var list = document.getElementById('countryList');
        var search = document.getElementById('countrySearch');
        var triggerFlag = document.getElementById('triggerFlag');
        var triggerCode = document.getElementById('triggerCode');
        var hiddenCode = document.getElementById('countryCode');
        var mobileInput = document.getElementById('contactMobile');

        if (!trigger) return;

        function flagUrl(iso) { return 'https://flagcdn.com/w40/' + iso + '.png'; }

        function renderList(filter) {
            filter = (filter || '').toLowerCase().trim();
            var html = '';
            var shown = 0;
            COUNTRIES.forEach(function (c) {
                var iso = c[0], code = c[1], name = c[2];
                if (filter && name.toLowerCase().indexOf(filter) === -1 && code.indexOf(filter) === -1) return;
                html += '<div class="country-option" data-iso="' + iso + '" data-code="' + code + '" data-name="' + name + '">'
                    + '<img src="' + flagUrl(iso) + '" alt="">'
                    + '<span class="name">' + name + '</span>'
                    + '<span class="code">' + code + '</span>'
                    + '</div>';
                shown++;
            });
            if (shown === 0) html = '<div class="country-empty">No countries found</div>';
            list.innerHTML = html;
        }

        function openDropdown() {
            dropdown.classList.add('open');
            trigger.classList.add('open');
            renderList('');
            setTimeout(function () { search.focus(); }, 50);
        }

        function closeDropdown() {
            dropdown.classList.remove('open');
            trigger.classList.remove('open');
            search.value = '';
        }

        function selectCountry(iso, code, name) {
            triggerFlag.src = flagUrl(iso);
            triggerFlag.alt = name;
            triggerCode.textContent = code;
            hiddenCode.value = code;
            closeDropdown();
            if (mobileInput) mobileInput.focus();
        }

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            if (dropdown.classList.contains('open')) {
                closeDropdown();
            } else {
                openDropdown();
            }
        });

        list.addEventListener('click', function (e) {
            var opt = e.target.closest('.country-option');
            if (!opt) return;
            selectCountry(opt.dataset.iso, opt.dataset.code, opt.dataset.name);
        });

        search.addEventListener('input', function () {
            renderList(search.value);
        });

        search.addEventListener('click', function (e) { e.stopPropagation(); });

        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
                closeDropdown();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && dropdown.classList.contains('open')) {
                closeDropdown();
            }
        });

        var form = document.querySelector('.contact-form');
        if (form) {
            form.addEventListener('submit', function () {
                var fullNumber = hiddenCode.value + mobileInput.value;
                var hf = document.createElement('input');
                hf.type = 'hidden';
                hf.name = 'mobile_full';
                hf.value = fullNumber;
                form.appendChild(hf);
            });
        }
    })();
</script>
@endpush
