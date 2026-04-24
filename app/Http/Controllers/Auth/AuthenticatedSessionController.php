<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Run logic only if customer (role_id = 0)
        if ($user->role_id === 0) {
            if (!$user->hasVerifiedEmail()) {
                // Not verified - log out and stay on login page
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $sentAt = $user->verification_sent_at ?? $user->created_at;
                $isExpired = $sentAt->diffInHours(now()) >= 24;

                if (!$isExpired) {
                    // Case 1: Under 24h
                    return back()->with('status', 'Please verify your profile using the verification link we sent to your registered email address.');
                } else {
                    // Case 2: Over 24h - auto resend
                    $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                        'verification.verify.custom',
                        now()->addMinutes(1440),
                        [
                            'id' => $user->id,
                            'hash' => sha1($user->getEmailForVerification()),
                        ]
                    );

                    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\CustomerVerificationMail($user, $verificationUrl));
                    
                    $user->update(['verification_sent_at' => now()]);

                    return back()->with('status', 'A verification email has been sent to your registered email address. Please click the link in your email to complete your registration.');
                }
            }
        }

        // Normal flow for Staff/Admin or verified Customers
        $request->session()->regenerate();

        if ($user->role_id === 0 && $user->profile_completed === 0) {
            return redirect()->route('customer.registration');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
