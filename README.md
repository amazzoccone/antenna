# Antenna

###### [FAQ](#faq) | [Contributing](https://github.com/bondacom/Antenna/blob/master/CONTRIBUTING.md)

> Antenna is a [Bondacom](https://bondacom.com) library which provides high-level functionalities to control [OneSignal](https://onesignal.com).

###### What can I do?

Most things that you can do manually from the One Signal Panel can be done using Antenna! Here are a few examples to get you started:

* Client name, logo, Android keys and iOS certificates, 
* Send individual push
* Send massive push with segmentations

## Getting Started

### Installation

> *Note: Antenna requires at least PHP v7.1.*

To use Antenna in your Laravel project, run:
```
composer require bondacom/antenna
```

> **Note**: For Lumen or Laravel less than 5.5remember to register manually the service provider!

### Configuration
Copy the config file into your project. For Laravel projects run:
```
php artisan vendor:publish --provider="Bondacom\Antenna\Providers\AntennaServiceProvider"
```

### Usage

It's really simple!

**Example** - create an App:

```
$app = Antenna::create([
    'name' => 'Testing One Signal Application',
    'gcm_key' => env('ANDROID_PUSH_API_KEY'),
    'apns_env' => env('IOS_PUSH_ENVIRONMENT', ''),
    'apns_p12' => base64_encode(file_get_contents($iosCertificatePath)),
    'apns_p12_password' => env('IOS_P12_PASSWORD', ''),
    'chrome_web_origin' => 'https://example.com',
    'chrome_web_default_notification_icon' =>
]);
```

**Example** - Get an app based on default config

```
$app = Antenna::app();
```

**Example** - Get an app based on config by name

```
$app = Antenna::app('myapp');
```

**Example** - Get an app from custom creds

```
$app = Antenna::app([
    'id' => {yourId},
    'key' => {yourKey}
]);
```

**Example** - Get all apps

```
$apps = Antenna::apps();
```

**Example** - Update an app

```
$app = Antenna::app();
$app->name = 'New Name';
$app->save();
```

**Example** - Create a notification from an app

```
$app = Antenna::app();
$notification = $app->notification()->create([
    "included_segments" => [
        "All",
    ],
    "contents" => [
        "es" => "Spanish Message",
        "en" => "English message",
    ],
]);
```

**Example** - Find a notification from an app

```
$app = Antenna::app();
$notification = $app->notification()->find({yourId});
```

**Example** - Get all notifications from an app

```
$notifications = Antenna::apps()->notification()->all();
```

**Example** - Cancel a notification from an app

```
$app = Antenna::app();
$notification = $app->notification()->find({yourId});
$notification->delete();
```


## Contributing to Antenna

Check out [contributing guide](https://github.com/bondacom/Antenna/blob/master/CONTRIBUTING.md) to get an overview of Antenna development.

## FAQ

#### Q: Which PHP and Laravel version does Antenna use?

Look for [composer.json](https://github.com/bondacom/Antenna/blob/master/composer.json).

As PHP, Laravel and One Signal improve over time, Antenna will be updated to depend on newer versions.

## License

Antenna is an open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)