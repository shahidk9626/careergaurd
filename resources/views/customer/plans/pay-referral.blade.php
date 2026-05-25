<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    <title>Securing Payment Session - Career Guard</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Main Styling -->
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5') }}" rel="stylesheet" />
</head>
<body class="m-0 font-sans antialiased font-normal bg-gray-50 text-start text-base leading-default text-slate-500">
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center -mx-3">
            <div class="w-full max-w-full px-3 shrink-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                <div class="relative flex flex-col min-w-0 mt-32 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
                    
                    @if(isset($error))
                        <!-- Error / Expiry State -->
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-700">Link Inactive</h4>
                            <p class="mt-2 text-sm text-slate-500">{{ $error }}</p>
                            
                            <div class="mt-6 border-t pt-4">
                                <span class="text-xs text-slate-400">Order ID: {{ $referral->cashfree_order_id }}</span>
                            </div>
                        </div>
                    @else
                        <!-- Active Loading / Redirecting State -->
                        <div class="p-6 text-center" id="loadingState">
                            <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                <i class="fas fa-credit-card text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-700">Securing Payment Session</h4>
                            <p class="mt-2 text-sm text-slate-500">Please wait while we connect you to Cashfree hosted checkout.</p>
                            
                            <div class="flex justify-center mt-6">
                                <div class="w-6 h-6 border-4 border-purple-600 border-t-transparent rounded-full animate-spin"></div>
                            </div>

                            <div class="mt-6 border-t pt-4 text-left">
                                <div class="text-xs text-slate-400 mb-1">Customer: <b class="text-slate-600">{{ $referral->customer->name }}</b></div>
                                <div class="text-xs text-slate-400 mb-1">Plan: <b class="text-slate-600">{{ $referral->plan->name }}</b></div>
                                <div class="text-xs text-slate-400">Amount: <b class="text-slate-600">₹{{ number_format($referral->plan->premium_amount, 2) }}</b></div>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

    @if(!isset($error))
        <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                try {
                    const cashfree = Cashfree({
                        mode: "{{ $environment === 'sandbox' ? 'sandbox' : 'production' }}"
                    });
                    
                    cashfree.checkout({
                        paymentSessionId: "{{ $paymentSessionId }}"
                    }).then((result) => {
                        console.log("Cashfree referral checkout page loaded");
                    }).catch(err => {
                        console.error("Cashfree Checkout error:", err);
                        document.getElementById('loadingState').innerHTML = `
                            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-times-circle text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-700">Checkout Error</h4>
                            <p class="mt-2 text-sm text-slate-500">Failed to load the Cashfree checkout gateway: ${err.message || err}</p>
                        `;
                    });
                } catch(e) {
                    console.error("Cashfree setup error:", e);
                }
            });
        </script>
    @endif
</body>
</html>
