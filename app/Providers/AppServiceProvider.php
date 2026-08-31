<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Events\MessageSending;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production' || isset($_SERVER['HTTPS']) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Event::listen(MessageSending::class, function () {
            Log::error('MAIL ATTEMPTED');
        });
    }
}