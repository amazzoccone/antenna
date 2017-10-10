<?php

namespace Bondacom\antenna\Providers;

use Illuminate\Support\ServiceProvider;

class antennaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Hashids', function ($app) {
            $salt = env('HASHIDS_SALT', 'Bondacom');
            $minLength = 12;
            return new Hashids($salt, $minLength);
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}