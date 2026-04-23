<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // 2. Tambahkan kode ini agar selalu pakai HTTPS di production
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
