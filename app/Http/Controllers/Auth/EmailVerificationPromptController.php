<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        // If not a customer (NULL or > 0), bypass verification prompt
        if ($user->role_id === null || $user->role_id > 0 || $user->id === 1) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // For customers (role_id = 0)
        return $user->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : view('auth.verify-email');
    }
}
