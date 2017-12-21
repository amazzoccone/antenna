<?php

namespace Bondacom\antenna\Providers;

use Bondacom\antenna\Antenna;
use Bondacom\antenna\AntennaBuilder;
use Bondacom\antenna\AntennaModel;
use Bondacom\antenna\ConsumerInterface;
use Bondacom\antenna\OneSignalConsumer;
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
        $config = config('antenna');

        $this->app->bind(Antenna::class, function ($app) use ($config) {
            return new Antenna($config);
        });

        $this->app->bind(ConsumerInterface::class, function ($app) use ($config) {
            $consumer = app(OneSignalConsumer::class);
            $consumer->setUserKey($config['userKey']);
            return $consumer;
        });
    }
}