<?php

namespace Bondacom\Antenna\Providers;

use Bondacom\Antenna\Antenna;
use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Drivers\OneSignal\Driver;
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
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/antenna.php', 'antenna'
        );

        $config = config('antenna');

        $this->app->bind('Antenna', function ($app) use ($config) {
            return new Antenna($config);
        });

        $this->app->bind(DriverInterface::class, function ($app) use ($config) {
            return new Driver($config['userKey']);
        });
    }
}