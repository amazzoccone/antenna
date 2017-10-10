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

Register the service provider in `config/app.php`

```
    'providers' => [
        /*
         * Application Service Providers...
         */
        Bondacom\antenna\Providers\ResponsesServiceProvider::class,
    ]
```

# Usage

### AntennaBuilder

1. ...

2. ...

3. ...
