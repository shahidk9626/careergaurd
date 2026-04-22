<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerVerificationMail;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Check if mail service is configured
        if (config('mail.default') === 'smtp') {
            $smtpConfig = config('mail.mailers.smtp');
            if (empty($smtpConfig['host']) || empty($smtpConfig['port']) || empty($smtpConfig['username']) || empty($smtpConfig['password']) || empty(config('mail.from.address'))) {
                return back()->withErrors(['error' => 'Mail service is not configured. Please contact administrator.']);
            }
        }

        try {
            // Generate secure signed verification link manually
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify.custom',
                Carbon::now()->addMinutes(1440), // 24 hours expiry
                [
                    'id' => $request->user()->getKey(),
                    'hash' => sha1($request->user()->getEmailForVerification()),
                ]
            );

            // Send custom mail manually
            Mail::to($request->user()->email)->send(new CustomerVerificationMail($request->user(), $verificationUrl));

            return back()->with('status', 'verification-link-sent');
        } catch (\Exception $e) {
            Log::error('Resend Verification Mail Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to send verification email right now. Please try again later 1.']);
        }
    }
}
