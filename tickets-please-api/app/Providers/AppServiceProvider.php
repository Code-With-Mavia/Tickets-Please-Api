<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Traits\ApiResponse;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind("", function () {

        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
