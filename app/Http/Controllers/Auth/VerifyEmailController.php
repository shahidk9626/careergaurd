<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirect customers to the plan-preview page
        if ($request->user()->role_id === 0 || ($request->user()->role && $request->user()->role->name === 'customer')) {
            return redirect()->route('customer.plan-preview');
        }

        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }

    /**
     * Custom manual email verification.
     */
    public function verifyCustom(Request $request, $id, $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('customer.plan-preview')->with('status', 'Your email is already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Auto-login the user after verification if not logged in
        if (!Auth::check()) {
            Auth::login($user);
        }

        return redirect()->route('customer.plan-preview')->with('status', 'Email verified successfully! You can now browse and purchase memberships.');
    }
}
