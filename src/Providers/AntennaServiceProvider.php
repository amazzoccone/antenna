<?php

namespace Bondacom\Antenna\Providers;

use Bondacom\Antenna\Antenna;
use Bondacom\Antenna\ConsumerInterface;
use Bondacom\Antenna\OneSignalConsumer;
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

        $this->app->bind(ConsumerInterface::class, function ($app) use ($config) {
            $consumer = app(OneSignalConsumer::class);
            $consumer->setUserKey($config['userKey']);
            return $consumer;
        });
    }
}