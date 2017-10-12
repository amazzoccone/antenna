<?php

/*
|--------------------------------------------------------------------------
| Antenna ~ One Signal Wrapper for Laravel
|--------------------------------------------------------------------------
| Client configuration
|
| You can find more information in (https://github.com/bondacom/Antenna)
*/

return [
    /*
    |--------------------------------------------------------------------------
    | User's credentials
    |--------------------------------------------------------------------------
    |
    | Used to manage apps
    | You can find it on https://onesignal.com/users/me
    */
    'userKey' => env('ONESIGNAL_USER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default APP
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default APP that should be used
    | by the framework. Just store away!
    |
    | If you have just one app, then, we will get your app id and app key from
    | .env file
    |
    */
    'default_app' => 'default',


    /*
    |--------------------------------------------------------------------------
    | Apps
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many apps as you wish
    |
    */
    'apps' => [
        'default' => [
            'id' => env('ONESIGNAL_APP_ID'),
            'key' => env('ONESIGNAL_APP_KEY'),
        ]
    ]
];