<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // إجبار النظام على استخدام HTTPS دائماً بغض النظر عن البيئة
        URL::forceScheme('https');
    }
}
