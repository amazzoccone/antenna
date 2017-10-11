# Antenna
Antenna is a Laravel Wrapper developed by [Bondacom](https://bondacom.com) for [OneSignal](https://onesignal.com) integration in laravel.

Antenna provides two basic helpers: **Constructor** and **Signal**.

[Laravel-notification-channels](http://laravel-notification-channels.com/) provides actually OneSignal support to [Laravel Notifications](https://laravel.com/docs/master/notifications), if you just need send notifications, we strongly recomends use it.
 
 If you need mannage you OneSignal apps, track your notifications or make other changes into OneSignal, then Antenna will cover your requirements.

Antenna have two core features:
### AntennaBuilder
**AntennaBuilder** provides tools required to create or update you OneSignal APPs.

Require a [User Auth Key](https://documentation.onesignal.com/docs/accounts-and-keys#section-user-auth-key)

### Signal
**Signal** helps you to manage notifications, devices, sessions, purchased, etc. 

Require a [App's REST API Key](https://documentation.onesignal.com/docs/accounts-and-keys#section-keys-ids)

# Installation

Add this to your project's `composer.json` file

```json
{
    "config":{
        "secure-http":false
    },
    "repositories": [
        {
            "type": "composer",
            "url": "http://packages.internal.bondacom.com"
        }
    ]
}
```

Then execute `composer require Bondacom/antenna=~1.0` command.

***If you are using Laravel 5.5+ edit you config/app.php file will not be required! Composer.json will load it automatically***

Register the service provider in `config/app.php`

```
    'providers' => [
        /*
         * Application Service Providers...
         */
        Bondacom\antenna\Providers\ResponsesServiceProvider::class,
    ]
```

Add Aliases in your `config/app.php`

```
    'aliases' => [
        ...
        'AntennaBuilder' => Bondacom\antenna\Facades\AntennaBuilder::class,
        'Signal' => Bondacom\antenna\Facades\Signal::class,
    ]
```

Then publish the config file with `php artisan vendor:publish --tag=config`. 

This will add the file app/config/antenna.php. This config have a default app, and will get the OneSignal data from your .env file. Anyway, you can check it in order to add others apps, for example.


# Usage

### AntennaBuilder

1. ...

2. ...

3. ...
