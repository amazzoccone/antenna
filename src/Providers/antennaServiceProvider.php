<?php

namespace Bondacom\antenna\Providers;

use Bondacom\antenna\AntennaBuilder;
use Bondacom\antenna\Signal;
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
            __DIR__.'/../config/antenna_settings.php' => config_path('antenna_settings.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $config = config('antenna_settings');

        $this->app->singleton('Bondacom\antenna\AntennaBuilder', function ($app) use ($config){
            return new AntennaBuilder($config['userKey']);
        });

        $this->app->singleton('Bondacom\antenna\Signal', function ($app) use ($config){
            $app = $config['apps'][$config['default_app']];
            return new Signal($app['id'],$app['key']);
        });
    }
}