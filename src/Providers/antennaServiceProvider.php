<?php

namespace Bondacom\antenna\Providers;

use Bondacom\antenna\AntennaBuilder;
use Bondacom\antenna\SignalApp;
use Illuminate\Support\ServiceProvider;

class AntennaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/antenna.php' => config_path('antenna.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $config = config('antenna');

        $this->app->singleton('AntennaBuilder', function ($app) use ($config) {
            return new AntennaBuilder($config['userKey']);
        });

        $this->app->singleton('SignalApp', function ($app) use ($config) {
            $app = $config['apps'][$config['default_app']];
            return new SignalApp($app['id'], $app['key']);
        });

    }
}