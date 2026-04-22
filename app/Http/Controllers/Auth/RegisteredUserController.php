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

        event(new Registered($user));

        return redirect(route('register'))->with('status', 'Registration successful. A verification email has been sent to your registered email address. Please click the registration link in your email to complete your profile.');
    }
}
