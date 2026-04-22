<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

use App\Models\Role;
use App\Models\StaffDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerVerificationMail;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'referral_code' => ['nullable', 'string', 'exists:staff_details,emp_code'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find customer role
        $customerRole = Role::where('name', 'customer')->first();
        if (!$customerRole) {
            // Fallback to searching by slug or ID if necessary
            $customerRole = Role::where('slug', 'customer')->first();
        }

        // Referral logic
        $referredById = null;
        if ($request->referral_code) {
            $staff = StaffDetail::where('emp_code', $request->referral_code)->first();
            if ($staff) {
                $referredById = $staff->user_id;
            }
        }

        // Check if mail service is configured
        if (config('mail.default') === 'smtp') {
            $smtpConfig = config('mail.mailers.smtp');
            if (empty($smtpConfig['host']) || empty($smtpConfig['port']) || empty($smtpConfig['username']) || empty($smtpConfig['password']) || empty(config('mail.from.address'))) {
                return back()->withErrors(['email' => 'Mail service is not configured. Please contact administrator.'])->withInput();
            }
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'whatsapp_number' => $request->whatsapp_number,
                'password' => Hash::make($request->password),
                'role_id' => $customerRole ? $customerRole->id : null,
                'referred_by_staff_id' => $referredById,
                'status' => 'pending',
                'profile_completed' => 0,
            ]);

            // Generate secure signed verification link manually
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify.custom',
                Carbon::now()->addMinutes(1440), // 24 hours expiry
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );

            // Send custom mail manually
            Mail::to($user->email)->send(new CustomerVerificationMail($user, $verificationUrl));

            DB::commit();

            return redirect(route('register'))->with('status', 'Registration successful. A verification email has been sent to your registered email. Please click the link in your email to complete registration.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration Mail Error: ' . $e->getMessage());
            
            return back()->withErrors(['email' => 'Unable to send verification email right now. Please try again later 2.'])->withInput();
        }
    }
}
