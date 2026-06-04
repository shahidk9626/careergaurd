<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role_id === 0) {
            // CASE 1: Profile Incomplete
            if (
                $user->profile_completed === 0 &&
                !$request->routeIs('customer.registration') &&
                !$request->routeIs('customer.store-profile') &&
                !$request->routeIs('customer.plan-preview') &&
                !$request->routeIs('customer.plan.show') &&
                !$request->routeIs('customer.plan.purchase') &&
                !$request->routeIs('customer.payment.callback') &&
                !$request->routeIs('logout') &&
                !$request->routeIs('verification.*')
            ) {
                return redirect()->route('customer.registration');
            }

            // CASE 2: Profile Completed but NOT Verified
            if (
                $user->profile_completed === 1 &&
                $user->verification_status !== 'verified' &&
                !$request->routeIs('customer.dashboard') &&
                !$request->routeIs('customer.plan-preview') &&
                !$request->routeIs('customer.plan.show') &&
                !$request->routeIs('customer.plan.purchase') &&
                !$request->routeIs('customer.payment.callback') &&
                !$request->routeIs('logout') &&
                !$request->routeIs('verification.*')
            ) {
                return redirect()->route('customer.dashboard');
            }
        }

        return $next($request);
    }
}
