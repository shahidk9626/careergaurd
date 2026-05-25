<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    <title>Payment Successful - Career Guard</title>
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
                    
                    @if($referral->payment_status === 'success')
                        <!-- Success State -->
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-3xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-700">Payment Successful!</h4>
                            <p class="mt-2 text-sm text-slate-500">Thank you! Your payment has been received successfully.</p>
                            
                            <div class="mt-6 border-t border-b py-4 text-left">
                                <div class="flex justify-between mb-2">
                                    <span class="text-xs text-slate-400">Customer:</span>
                                    <span class="text-xs font-bold text-slate-700">{{ $referral->customer->name }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-xs text-slate-400">Membership Name:</span>
                                    <span class="text-xs font-bold text-slate-700">{{ $referral->plan->name }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-xs text-slate-400">Amount Paid:</span>
                                    <span class="text-xs font-bold text-slate-700">₹{{ number_format($referral->plan->premium_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs text-slate-400">Order Reference:</span>
                                    <span class="text-xs font-bold text-slate-700">{{ $referral->cashfree_order_id }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="inline-block w-full px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                                    Log In to Your Dashboard
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Failed / Verification Pending State -->
                        <div class="p-6 text-center">
                            <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                                <i class="fas fa-spinner text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-700">Processing Payment Verification</h4>
                            <p class="mt-2 text-sm text-slate-500">We are verifying the payment status with Cashfree. Please refresh this page shortly.</p>
                            
                            <div class="mt-6">
                                <a href="{{ url()->current() }}" class="inline-block w-full px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-gray-900 to-slate-800 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85">
                                    Refresh Page
                                </a>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
