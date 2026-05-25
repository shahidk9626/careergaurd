<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    <title>{{ config('app.name', 'Soft UI Dashboard Tailwind') }}</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons --> <!-- updated by ss -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Main Styling -->
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5') }}" rel="stylesheet" />
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    @include('partials.sidebar')

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
        @include('partials.header')

        <div class="w-full px-6 py-6 mx-auto">
            @yield('content')

            @include('partials.footer')
        </div>
    </main>

    <!-- plugin for charts  -->
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}" async></script>
    <!-- plugin for scrollbar  -->
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" async></script>
    <!-- github button -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- main script file  -->
    <script src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5') }}" async></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            if (typeof $.validator !== 'undefined') {
                // Name validation (only letters and spaces, min 3 chars)
                $.validator.addMethod("lettersnspaces", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
                }, "Only alphabets and spaces are allowed");

                // Indian mobile validation (starts 6-9, exactly 10 digits)
                $.validator.addMethod("indianmobile", function(value, element) {
                    return this.optional(element) || /^[6-9]\d{9}$/.test(value);
                }, "Please enter a valid 10-digit Indian mobile number starting with 6-9");

                // Aadhaar validation (exactly 12 digits, numeric)
                $.validator.addMethod("aadhar", function(value, element) {
                    return this.optional(element) || /^\d{12}$/.test(value);
                }, "Aadhaar number must be exactly 12 digits");

                // PAN validation
                $.validator.addMethod("pan", function(value, element) {
                    return this.optional(element) || /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(value.toUpperCase());
                }, "Please enter a valid PAN card number (e.g. ABCDE1234F)");

                // Pincode validation (exactly 6 digits)
                $.validator.addMethod("pincode_custom", function(value, element) {
                    return this.optional(element) || /^\d{6}$/.test(value);
                }, "Pincode must be exactly 6 digits");

                // Date of birth validation (cannot be in the future)
                $.validator.addMethod("pastdate", function(value, element) {
                    if (!value) return true;
                    let inputDate = new Date(value);
                    let today = new Date();
                    inputDate.setHours(0,0,0,0);
                    today.setHours(0,0,0,0);
                    return inputDate <= today;
                }, "Date cannot be a future date");

                // File size validation (max 2MB)
                $.validator.addMethod("filesize", function(value, element, param) {
                    if (this.optional(element)) return true;
                    if (element.files && element.files.length > 0) {
                        for (let i = 0; i < element.files.length; i++) {
                            if (element.files[i].size > param) {
                                return false;
                            }
                        }
                    }
                    return true;
                }, "File size must not exceed 2 MB.");

                // File extension validation (jpg, jpeg, png, pdf)
                $.validator.addMethod("extension_custom", function(value, element, param) {
                    if (this.optional(element)) return true;
                    let ext = value.split('.').pop().toLowerCase();
                    let allowed = param.split('|');
                    return allowed.includes(ext);
                }, "Invalid file type. Only jpg, jpeg, png, pdf are allowed.");

                // Strong password validation
                $.validator.addMethod("strong_password", function(value, element) {
                    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
                }, "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character");

                // Configure default validate options
                $.validator.setDefaults({
                    errorElement: 'p',
                    errorClass: 'text-red-500 text-xs mt-1 error-message',
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('border-red-500');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('border-red-500');
                    },
                    errorPlacement: function(error, element) {
                        let parent = element.closest('.mb-4') || element.parent();
                        parent.find('.error-message').remove();
                        error.appendTo(parent);
                    }
                });
            }
        });
    </script>
    <!-- global modal helper -->
    <script>
        window.openGlobalModal = function (id) {
            const modal = document.getElementById(id);
            const content = modal.querySelector('.modal-content') || document.getElementById(id + '-content');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');

                // Trigger animation
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    if (content) {
                        content.classList.remove('opacity-0', 'scale-95');
                        content.classList.add('opacity-100', 'scale-100');
                    }
                }, 10);
            }
        };

        window.closeGlobalModal = function (id) {
            const modal = document.getElementById(id);
            const content = modal.querySelector('.modal-content') || document.getElementById(id + '-content');
            if (modal) {
                if (content) {
                    content.classList.remove('opacity-100', 'scale-100');
                    content.classList.add('opacity-0', 'scale-95');
                }
                modal.classList.remove('opacity-100');

                // Wait for animation
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }, 300);
            }
        };

        // ESC key close
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const visibleModal = document.querySelector('[role="dialog"]:not(.hidden)');
                if (visibleModal) {
                    window.closeGlobalModal(visibleModal.id);
                }
            }
        });
    </script>
    <style>
        .overflow-hidden {
            overflow: hidden !important;
        }
    </style>

    @if(auth()->check() && auth()->user()->role_id === 0)
        <div id="callbackRequestModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
            <div style="background-color: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 90vh; margin: 1rem;">
                <form id="callbackRequestForm" action="{{ route('customer.callback-request.store') }}" method="POST" style="display: flex; flex-direction: column; height: 100%; margin: 0;">
                    @csrf
                    <input type="hidden" name="flag" id="callback_flag" value="direct">
                    <input type="hidden" name="purchased_plan_id" id="callback_purchased_plan_id" value="">
                    <input type="hidden" name="claim_id" id="callback_claim_id" value="">
                    
                    <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                        <h6 style="margin: 0; font-weight: 700; color: #334155; font-size: 1.125rem;">Request Callback</h6>
                        <button type="button" onclick="closeCallbackModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #94a3b8; cursor: pointer; padding: 0;">&times;</button>
                    </div>

                    <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1; display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569;">Enter Your Concern <span style="color: #ef4444;">*</span></label>
                            <textarea name="concern" id="callback_concern" rows="4" required style="width: 100%; padding: 0.625rem 0.75rem; font-size: 0.875rem; border: 1px solid #cbd5e1; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Briefly describe your concern..."></textarea>
                        </div>
                    </div>

                    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; justify-content: flex-end; gap: 0.75rem;">
                        <button type="button" onclick="closeCallbackModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer;">Cancel</button>
                        <button type="submit" style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border: none; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openCallbackModalLogic() {
                let modal = document.getElementById('callbackRequestModal');
                if (modal) {
                    document.body.appendChild(modal); // Escapes parent layout traps
                    modal.style.display = 'flex';     // Triggers centering
                }
            }

            function closeCallbackModal() {
                let modal = document.getElementById('callbackRequestModal');
                if (modal) {
                    modal.style.display = 'none';
                }
            }

            function openCallbackModal(flag, purchasedPlanId = '', claimId = '') {
                document.getElementById('callback_flag').value = flag;
                document.getElementById('callback_purchased_plan_id').value = purchasedPlanId;
                document.getElementById('callback_claim_id').value = claimId;
                document.getElementById('callback_concern').value = '';
                openCallbackModalLogic();
            }

            $(document).ready(function() {
                $('#callbackRequestForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    const concernVal = $('#callback_concern').val().trim();
                    if (!concernVal) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Required Field',
                            text: 'Please enter your concern before submitting.',
                        });
                        return;
                    }

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            closeCallbackModal();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Your callback request has been submitted successfully.',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Failed',
                                text: 'Unable to submit callback request. Please try again.',
                            });
                        }
                    });
                });
            });
        </script>
    @endif

    @stack('scripts')
</body>

</html>