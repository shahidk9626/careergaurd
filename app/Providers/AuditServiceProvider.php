<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Services\AuditService;

class AuditServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('audit.request_id', function () {
            return (string) \Illuminate\Support\Str::uuid();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 1. Login Event
        Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            $user = $event->user;
            AuditService::log(
                'Authentication',
                'authentication',
                'LOGIN',
                $user->id,
                null,
                null,
                null,
                "User logged in successfully.",
                $user->email,
                $user
            );
        });

        // 2. Logout Event
        Event::listen(\Illuminate\Auth\Events\Logout::class, function ($event) {
            $user = $event->user;
            if ($user) {
                AuditService::log(
                    'Authentication',
                    'authentication',
                    'LOGOUT',
                    $user->id,
                    null,
                    null,
                    null,
                    "User logged out successfully.",
                    $user->email,
                    $user
                );
            }
        });

        // 3. Failed Login Event
        Event::listen(\Illuminate\Auth\Events\Failed::class, function ($event) {
            $credentials = $event->credentials;
            $email = $credentials['email'] ?? 'unknown';
            $user = \App\Models\User::where('email', $email)->first();
            
            AuditService::log(
                'Authentication',
                'authentication',
                'FAILED_LOGIN',
                $user ? $user->id : null,
                null,
                null,
                null,
                "Failed login attempt for email: {$email}",
                $email,
                $user
            );
        });

        // 4. Password Reset Event
        Event::listen(\Illuminate\Auth\Events\PasswordReset::class, function ($event) {
            $user = $event->user;
            AuditService::log(
                'Authentication',
                'authentication',
                'PASSWORD_RESET',
                $user->id,
                null,
                null,
                null,
                "Password reset completed successfully.",
                $user->email,
                $user
            );
        });

        // 5. Verified Event (Email Verification)
        Event::listen(\Illuminate\Auth\Events\Verified::class, function ($event) {
            $user = $event->user;
            AuditService::log(
                'Authentication',
                'authentication',
                'EMAIL_VERIFY',
                $user->id,
                null,
                null,
                null,
                "Email verification completed successfully.",
                $user->email,
                $user
            );
        });
    }
}
