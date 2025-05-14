<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ErrorReportingServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Only modify error reporting in local environment
        if ($this->app->environment('local')) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
            ini_set('display_errors', 'On');
            ini_set('display_startup_errors', 'On');
        }
    }

    public function boot()
    {
        //
    }
} 