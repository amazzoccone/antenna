<?php

namespace Bondacom\antenna\Providers;

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
            return new AntennaBuilder();
        });

        $this->app->singleton('SignalApp', function ($app) use ($config) {
            $appConfig = $config['apps'][$config['default_app']];
            return new AntennaModel($appConfig['id'], $appConfig['key']);
        });

        $this->app->bind(ConsumerInterface::class, function ($app) use ($config) {
            $consumer = app(OneSignalConsumer::class);
            $consumer->setUserKey($config['userKey']);
            return $consumer;
        });
    }
}