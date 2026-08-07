<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\AI\Contracts\AIProvider;
use App\Core\AI\Providers\OpenRouterProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    $this->app->singleton(
        AIProvider::class,
        OpenRouterProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
