<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    Barryvdh\DomPDF\ServiceProvider::class,
    App\Providers\AuditServiceProvider::class,
];
