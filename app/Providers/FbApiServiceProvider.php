<?php

namespace App\Providers;

use App\Services\FbApiService;
use Illuminate\Support\ServiceProvider;

class FbApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FbApiService::class, function ($app) {
            return new FbApiService();
        });
    }
}
