@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h3 class="font-bold text-slate-700">Choose Your Professional Membership</h3>
            <p class="text-slate-500">Premium bundles tailored for your career growth.</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-8">
        <div class="col-12 flex justify-center">
            <form action="{{ url()->current() }}" method="GET" class="w-full max-w-lg" id="searchForm">

                <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                    <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" 
                        placeholder="Search Memberships..." />
                </div>
            </form>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3 mt-4 justify-center">
        @forelse($plans as $plan)
            <div class="w-full max-w-full px-3 mb-6 md:w-6/12 lg:w-4/12 flex-none">
                <!-- Card content remains the same -->
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl text-center">
                        <span
                            class="px-4 py-1 mb-4 inline-block text-xxs font-bold text-center text-purple-700 uppercase align-middle transition-all bg-purple-100 rounded-lg">
                            {{ $plan->tenure_value }} {{ ucfirst($plan->tenure_type) }}
                        </span>
                        <h5 class="mb-0 font-bold text-slate-700">{{ $plan->name }}</h5>
                        <p class="mb-0 text-sm leading-normal text-slate-400">
                            {{ $plan->short_description ?? 'Premium career services' }}
                        </p>

                        <div class="my-6">
                            <h2 class="font-bold text-slate-700">
                                <span class="text-sm align-top mr-1">₹</span>{{ number_format($plan->premium_amount, 0) }}
                            </h2>
                        </div>
                    </div>

                    <div class="flex-auto p-6">
                        <ul class="flex flex-col pl-0 mb-0 list-none">
                            @php
                                $groupedServices = $plan->planServices->groupBy('service_type');
                                $serviceIcons = [
                                    'resume' => ['icon' => 'fa-file-invoice', 'color' => 'text-purple-500', 'label' => 'Resume Templates'],
                                    'job-link' => ['icon' => 'fa-link', 'color' => 'text-blue-500', 'label' => 'Job Links'],
                                    'question' => ['icon' => 'fa-question-circle', 'color' => 'text-red-500', 'label' => 'Interview Q&A'],
                                ];
                            @endphp

                            @foreach($groupedServices as $type => $services)
    @php $meta = $serviceIcons[$type] ?? ['icon' => 'fa-check', 'color' => 'text-green-500', 'label' => $type]; @endphp
    <li class="relative flex items-start py-2 border-0 rounded-t-lg text-inherit">
        <div class="flex items-center justify-center w-5 h-5 mr-3 mt-1 rounded-lg bg-gray-100 text-center flex-none">
            <i class="fas {{ $meta['icon'] }} {{ $meta['color'] }} text-xs"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-bold text-slate-700">{{ $meta['label'] }}</span>
        </div>
    </li>
@endforeach

                            

                            <li class="relative flex items-center py-2 border-0 text-inherit">
                                <div
                                    class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-green-100 text-center flex-none">
                                    <i class="fas fa-hand-holding-usd text-green-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-slate-600">Upto
                                    <b>₹{{ number_format($plan->compensation_amount, 0) }}</b> support after
                                    {{ $plan->claim_duration_days }} days</span>
                            </li>

                            @if($plan->prematurity_available)
                                <li class="relative flex items-center py-2 border-0 text-inherit">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-purple-100 text-center flex-none">
                                        <i class="fas fa-history text-purple-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">Prematurity Available: <b>Yes</b></span>
                                </li>
                            @endif

                            @if($plan->one_time_payment_applicable)
                                <li class="relative flex items-center py-2 border-0 text-inherit">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-blue-100 text-center flex-none">
                                        <i class="fas fa-coins text-blue-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">One-Time Payment: <b>Available</b></span>
                                </li>
                                <li class="relative flex items-center py-2 border-0 text-inherit">
                                    <div
                                        class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-cyan-100 text-center flex-none">
                                        <i class="fas fa-wallet text-cyan-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-slate-600">Discounted One-Time Payment: <b>₹{{ number_format($plan->discount_price ?? $plan->one_time_payment_amount, 0) }}</b></span>
                                </li>
                                @if($plan->discount_price)
                                    @php
                                        $monthlyPrice = 0;
                                        if ($plan->tenure_type === 'months' && $plan->tenure_value > 0) {
                                            $monthlyPrice = $plan->premium_amount / $plan->tenure_value;
                                        } elseif ($plan->tenure_type === 'years' && $plan->tenure_value > 0) {
                                            $monthlyPrice = $plan->premium_amount / ($plan->tenure_value * 12);
                                        }

                                        $strikeThroughPrice = $plan->one_time_payment_amount ?: $plan->premium_amount;

                                        $dailyPrice = 0;
                                        if ($plan->tenure_type === 'months' && $plan->tenure_value > 0) {
                                            $dailyPrice = $plan->premium_amount / ($plan->tenure_value * 30);
                                        } elseif ($plan->tenure_type === 'years' && $plan->tenure_value > 0) {
                                            $dailyPrice = $plan->premium_amount / ($plan->tenure_value * 365);
                                        } elseif ($plan->tenure_type === 'days' && $plan->tenure_value > 0) {
                                            $dailyPrice = $plan->premium_amount / $plan->tenure_value;
                                        }
                                    @endphp
                                    @if($monthlyPrice > 0)
                                         <li class="relative flex items-center py-2 pl-8 border-0 text-inherit">
                                             <div class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-green-100 text-center flex-none">
                                                 <i class="fas fa-calendar-alt text-green-600 text-xs"></i>
                                             </div>
                                             <span class="text-sm text-slate-600">₹{{ number_format($monthlyPrice, 0) }}/month</span>
                                         </li>
                                     @endif
                                     <li class="relative flex items-center py-2 pl-8 border-0 text-inherit">
                                         <div class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-red-100 text-center flex-none">
                                             <i class="fas fa-tags text-red-600 text-xs"></i>
                                         </div>
                                         <span class="text-sm text-slate-600">
                                             <del class="text-slate-400">₹{{ number_format($strikeThroughPrice, 0) }}</del> 
                                             <span class="font-bold text-purple-700">₹{{ number_format($plan->discount_price, 0) }}</span>/{{ $plan->tenure_value }} {{ $plan->tenure_type }}
                                         </span>
                                     </li>
                                     @if($dailyPrice > 0)
                                         <li class="relative flex items-center py-2 pl-8 border-0 text-inherit">
                                             <div class="flex items-center justify-center w-5 h-5 mr-3 rounded-lg bg-purple-100 text-center flex-none">
                                                 <i class="fas fa-calendar-day text-purple-600 text-xs"></i>
                                             </div>
                                             <span class="text-sm text-slate-600">Just ₹{{ round($dailyPrice) }} per day*</span>
                                         </li>
                                     @endif
                                @endif
                            @endif
                        </ul>
                    </div>

                    <div class="p-6 pt-0 mt-auto bg-transparent border-t-0 rounded-b-2xl">
                        @if($plan->one_time_payment_applicable)
                            <div class="mb-3 text-left">
                                <label class="block text-xxs font-bold text-slate-500 mb-1">Payment Option</label>
                                <select id="payment_type_{{ $plan->id }}" class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-slate-600 bg-white">
                                    <option value="regular">Monthly (₹{{ number_format($plan->premium_amount, 0) }})</option>
                                    <option value="one_time">Yearly (₹{{ number_format($plan->discount_price ?? $plan->one_time_payment_amount, 0) }})</option>
                                </select>
                            </div>
                        @endif

                        @if(auth()->user()->role_id == 0)
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('customer.plan.show', $plan->slug) }}"
                                    class="w-1/2 px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-slate-600 to-slate-300 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold rounded-[10px]">
                                    View Detail
                                </a>
                                <button type="button" onclick="confirmPurchase('{{ $plan->id }}', '{{ $plan->name }}')"
                                    class="w-1/2 px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold rounded-[10px] mx-2">
                                    Purchase Now
                                </button>
                            </div>
                        @else
                            <button
                                class="w-full px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer shadow-soft-md bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:scale-102 active:opacity-85 font-semibold rounded-[10px] mx-2">
                                Get Started
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="w-full text-center py-12">
                <div class="mb-4 text-slate-300">
                    <i class="fas fa-search fa-4x"></i>
                </div>
                <h5 class="text-slate-500">No memberships found.</h5>
                <p class="text-slate-400">Try adjusting your search criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Section -->
    @if($plans->hasPages())
    <div class="row mt-8">
        <div class="col-12 flex justify-center">
            <nav aria-label="Page navigation">
                <ul class="flex pl-0 list-none rounded-lg">
                    {{-- Previous Page Link --}}
                    @if ($plans->onFirstPage())
                        <li class="mx-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-300 cursor-not-allowed">
                                <i class="fas fa-angle-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="mx-1">
                            <a href="{{ $plans->previousPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($plans->getUrlRange(1, $plans->lastPage()) as $page => $url)
                        @if ($page == $plans->currentPage())
                            <li class="mx-1">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 text-white font-bold shadow-soft-md">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="mx-1">
                                <a href="{{ $url }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($plans->hasMorePages())
                        <li class="mx-1">
                            <a href="{{ $plans->nextPageUrl() }}" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 transition-all">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="mx-1">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-200 text-slate-300 cursor-not-allowed">
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    @endif

<!-- Terms and Conditions Modal -->
<div id="termsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(15, 23, 42, 0.6); z-index: 999999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background-color: #ffffff; width: 100%; max-width: 700px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); display: flex; flex-direction: column; max-height: 85vh; margin: 1.5rem;">
        
        <!-- Modal Header -->
        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(310deg, #7e22ce 0%, #db2777 100%); border-top-left-radius: 16px; border-top-right-radius: 16px;">
            <h6 style="margin: 0; font-weight: 700; color: #ffffff; font-size: 1.125rem;">Terms & Conditions</h6>
            <button type="button" onclick="closeTermsModal()" style="background: none; border: none; font-size: 1.5rem; line-height: 1; color: #ffffff; cursor: pointer; padding: 0; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.8">&times;</button>
        </div>

        <!-- Modal Body (Scrollable Terms Content) -->
        <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1; font-size: 0.875rem; color: #475569; line-height: 1.6; border-bottom: 1px solid #e2e8f0;">
            <h5 style="font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 1rem; text-align: center; font-size: 1rem;">CareerGuard & FutureGuard Membership Terms & Conditions</h5>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <strong style="color: #1e293b;">1. Membership</strong>
                    <p style="margin: 0.25rem 0 0 0;">CareerGuard and FutureGuard are membership-based support platforms providing career resources, education support programs, skill development opportunities, business guidance, and other member benefits. Membership is voluntary and available only to eligible applicants whose registration is accepted by the organization.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">2. Membership Plans</strong>
                    <p style="margin: 0.25rem 0 0 0;">Membership benefits are available only during the active membership period. Each membership plan includes benefits described on the official website. Higher membership plans may provide a higher maximum support limit in accordance with the applicable membership policy.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">3. Membership Fees</strong>
                    <p style="margin: 0.25rem 0 0 0;">All membership fees are payable in advance. Membership fees are non-refundable, non-transferable, and cannot be adjusted unless required by applicable law. Fees are collected for platform access, administration, member resources, skill development, digital content, support services, and other membership benefits.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">4. CareerGuard Benefits</strong>
                    <p style="margin: 0.25rem 0 0 0;">Job Opportunities, Resume Templates, Interview Questions & Answers, Career Resources, Business Opportunities, Member Dashboard, WhatsApp & Email Notifications, and other member benefits introduced from time to time. Availability may change without prior notice.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">5. Financial Assistance Support</strong>
                    <p style="margin: 0.25rem 0 0 0;">Financial Assistance Support is not guaranteed and is subject to active membership, eligibility verification, identity verification, employment verification, document submission, internal review, and compliance with the Membership Policy. Maximum support amounts represent the maximum eligible limit only. Final approved support, if any, is determined after assessment. Support may vary depending on layoff, company closure, workforce reduction, termination, resignation, or other employment circumstances.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">6. Claim Verification</strong>
                    <p style="margin: 0.25rem 0 0 0;">Members must provide genuine information. False information or forged documents may result in rejection of benefits and cancellation of membership.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">7. FutureGuard Kids</strong>
                    <p style="margin: 0.25rem 0 0 0;">FutureGuard Kids is a long-term membership-based education support program. Members may choose monthly or yearly membership. Education support eligibility arises only after the required membership period and successful verification. Education support is not guaranteed.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">8. Skill Development</strong>
                    <p style="margin: 0.25rem 0 0 0;">Eligible members may attend skill development programs conducted in selected cities. Where included, no additional course fee will be charged. Members bear their own travel, accommodation, food, and personal expenses unless otherwise announced.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">9. Member Responsibilities</strong>
                    <p style="margin: 0.25rem 0 0 0;">Members agree to provide accurate information, maintain updated contact details, protect login credentials, follow membership policies, and cooperate during verification.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">10. Cancellation & Suspension</strong>
                    <p style="margin: 0.25rem 0 0 0;">Membership may be suspended or terminated for false information, fraud, policy violations, or illegal activity. Benefits may be cancelled.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">11. Third-Party Services</strong>
                    <p style="margin: 0.25rem 0 0 0;">CareerGuard may provide access to third-party employers, educational resources, franchise information, and business opportunities. Members should independently verify all information.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">12. No Guarantee</strong>
                    <p style="margin: 0.25rem 0 0 0;">CareerGuard and FutureGuard do not guarantee employment, interview selection, salary, business success, educational admission, financial assistance approval, or education support approval.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">13. Modification</strong>
                    <p style="margin: 0.25rem 0 0 0;">The organization may modify, suspend, revise, or discontinue membership plans, benefits, eligibility criteria, policies, or services at any time, subject to applicable law.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">14. Limitation of Liability</strong>
                    <p style="margin: 0.25rem 0 0 0;">The organization's liability is limited to the services provided under the membership to the maximum extent permitted by applicable law.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">15. Governing Law</strong>
                    <p style="margin: 0.25rem 0 0 0;">These Terms & Conditions are governed by the laws of India. Jurisdiction shall lie with the competent courts where the organization has its registered office unless otherwise required by law.</p>
                </div>
                <div>
                    <strong style="color: #1e293b;">16. Acceptance</strong>
                    <p style="margin: 0.25rem 0 0 0;">By clicking 'I Agree', registering an account, or making payment, you confirm that you have read, understood, and accepted these Terms & Conditions, the Membership Policy, Privacy Policy, and Refund Policy.</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 1.25rem 1.5rem; background-color: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; display: flex; flex-direction: column; gap: 1rem;">
            <!-- Checkbox Option -->
            <label style="display: flex; align-items: flex-start; gap: 0.75rem; cursor: pointer; user-select: none;">
                <input type="checkbox" id="agreeTermsCheckbox" onchange="toggleAgreeButton()" style="margin-top: 0.25rem; width: 1.15rem; height: 1.15rem; border-radius: 0.25rem; border: 1px solid #cbd5e1; accent-color: #db2777; cursor: pointer;">
                <span style="font-size: 0.8rem; font-weight: 600; color: #334155;">I have read, understood, and accept the CareerGuard & FutureGuard Membership Terms & Conditions.</span>
            </label>
            
            <!-- Actions -->
            <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeTermsModal()" style="padding: 0.625rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #475569; background: white; border: 1px solid #cbd5e1; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;">Cancel</button>
                <button type="button" id="proceedPurchaseBtn" onclick="executePurchase()" disabled style="padding: 0.625rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: white; background: #94a3b8; border: none; border-radius: 0.5rem; cursor: not-allowed; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.2s;">Agree & Purchase</button>
            </div>
        </div>

    </div>
</div>

    @if(auth()->user()->role_id == 0)
        @push('scripts')
            <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    @if(session('success'))
                        @if(session('profile_incomplete'))
                            Swal.fire({
                                title: 'Membership purchased successfully.',
                                text: 'Please complete your profile to activate all customer services and ensure faster processing of future requests.',
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonColor: '#cb0c9f',
                                cancelButtonColor: '#8392ab',
                                confirmButtonText: 'Complete Your Profile',
                                cancelButtonText: 'View Membership'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('customer.registration') }}";
                                } else {
                                    window.location.href = "{{ route('customer.purchased-plans') }}";
                                }
                            });
                        @else
                            Swal.fire({
                                title: 'Success!',
                                text: "{{ session('success') }}",
                                icon: 'success',
                                confirmButtonColor: '#cb0c9f',
                            });
                        @endif
                    @endif
                    @if(session('error'))
                        Swal.fire({
                            title: 'Error!',
                            text: "{{ session('error') }}",
                            icon: 'error',
                            confirmButtonColor: '#cb0c9f',
                        });
                    @endif
                });

                let currentPlanIdToPurchase = null;

                function confirmPurchase(planId, planName) {
                    currentPlanIdToPurchase = planId;
                    document.getElementById('agreeTermsCheckbox').checked = false;
                    toggleAgreeButton();
                    document.getElementById('termsModal').style.display = 'flex';
                }

                function toggleAgreeButton() {
                    const isChecked = document.getElementById('agreeTermsCheckbox').checked;
                    const btn = document.getElementById('proceedPurchaseBtn');
                    if (isChecked) {
                        btn.disabled = false;
                        btn.style.background = 'linear-gradient(310deg, #7e22ce 0%, #db2777 100%)';
                        btn.style.cursor = 'pointer';
                    } else {
                        btn.disabled = true;
                        btn.style.background = '#94a3b8';
                        btn.style.cursor = 'not-allowed';
                    }
                }

                function closeTermsModal() {
                    document.getElementById('termsModal').style.display = 'none';
                }

                function executePurchase() {
                    const isChecked = document.getElementById('agreeTermsCheckbox').checked;
                    if (!isChecked) return;
                    closeTermsModal();
                    if (currentPlanIdToPurchase) {
                        purchasePlan(currentPlanIdToPurchase);
                    }
                }

                function purchasePlan(planId) {
                    Swal.fire({
                        title: 'Initiating Payment...',
                        text: 'Please wait while we redirect you to the payment gateway.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const paymentTypeDropdown = document.getElementById('payment_type_' + planId);
                    const paymentType = paymentTypeDropdown ? paymentTypeDropdown.value : 'regular';

                    fetch("{{ route('customer.plan.purchase') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            plan_id: planId,
                            payment_type: paymentType
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.payment_session_id) {
                                const cashfree = Cashfree({
                                    mode: data.environment === 'sandbox' ? 'sandbox' : 'production'
                                });
                                
                                cashfree.checkout({
                                    paymentSessionId: data.payment_session_id
                                }).then((result) => {
                                    console.log("Cashfree checkout page loaded");
                                });
                            } else if (data.error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.error,
                                    icon: 'error',
                                    confirmButtonColor: '#cb0c9f',
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong',
                                    icon: 'error',
                                    confirmButtonColor: '#cb0c9f',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to process purchase.',
                                icon: 'error',
                                confirmButtonColor: '#cb0c9f',
                            });
                        });
                }
                (function () {
        var form  = document.getElementById('searchForm');
        if (!form) return;
        var input = form.querySelector('input[name="search"]');
        if (!input) return;

        var timer;
        input.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                form.submit();
            }, 500);
        });

        // block Enter from instant-submitting
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') e.preventDefault();
        });

        // restore focus + cursor after the page reloads with results
        window.addEventListener('load', function () {
            if (input.value) {
                input.focus();
                var len = input.value.length;
                input.setSelectionRange(len, len);
            }
        });
    })();
            </script>
        @endpush
    @endif
@endsection