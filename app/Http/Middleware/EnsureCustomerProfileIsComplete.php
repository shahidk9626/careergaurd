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
            if (
                $user->profile_completed === 0 &&
                !$request->routeIs('customer.registration') &&
                !$request->routeIs('customer.plan-preview') &&
                !$request->routeIs('logout') &&
                !$request->routeIs('verification.*')
            ) {
                return redirect()->route('customer.registration');
            }
        }

        return $next($request);
    }
}
