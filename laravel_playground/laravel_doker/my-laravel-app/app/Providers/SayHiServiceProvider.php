<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SayHiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'sayhi',
            'App\Services\MyFacade',
            false);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
