# Antenna

###### [FAQ](#faq) | [Contributing](https://github.com/GoogleChrome/puppeteer/blob/master/CONTRIBUTING.md)

> Puppeteer is a Node library which provides a high-level API to control [headless](https://developers.google.com/web/updates/2017/04/headless-chrome) Chrome over the [DevTools Protocol](https://chromedevtools.github.io/devtools-protocol/). It can also be configured to use full (non-headless) Chrome.

> Antenna is a Laravel library which provides high-level functionalities to control [OneSignal](https://onesignal.com).

###### What can I do?

Most things that you can do manually from the One Signal Panel can be done using Antenna! Here are a few examples to get you started:

* Client name, logo, Android keys and iOS certificates, 
* Send individual push
* Send massive push with segmentations

## Getting Started

### Installation

> *Note: Antenna requires at least PHP v5.6.*

To use Antenna in your Laravel project, run:
```
composer require Bondacom/Antenna
```

> **Note**: For Laravel less than 5.5 remember to register manually the service provider!

### Configuration
Copy the config file into your project by running
```
php artisan vendor:publish --provider="Bondacom\antenna\Providers\AntennaServiceProvider" --tag="config"
```

### Usage

It's really simple! Use Antenna Facade
of `Browser`, open pages, and then manipulate them with [Puppeteer's API](https://github.com/GoogleChrome/puppeteer/blob/master/docs/api.md#).

**Example** - create a One Signal App:

```
$app = AntennaBuilder::create([
    'name' => 'Testing One Signal Application',
    'gcm_key' => env('ANDROID_PUSH_API_KEY'),
    'apns_env' => env('IOS_PUSH_ENVIRONMENT', ''),
    'apns_p12' => base64_encode(file_get_contents($iosCertificatePath)),
    'apns_p12_password' => env('IOS_P12_PASSWORD', ''),
    'chrome_web_origin' => 'https://example.com',
    'chrome_web_default_notification_icon' =>
]);
```

**Example** - update One Signal App

```
$app = SignalApp::get([
    'id' => {{app_id}},
    'key' => {{auth_key}}
]);

$app->chrome_web_origin = 'https://example.com';
$app->save()
```

## Contributing to Antenna

Check out [contributing guide](https://github.com/bondacom/Antenna/blob/master/CONTRIBUTING.md) to get an overview of Antenna development.

# FAQ

#### Q: Which PHP and Laravel version does Antenna use?

Look for [composer.json](https://github.com/bondacom/Antenna/blob/master/composer.json).

As PHP, Laravel and One Signal improve over time, Antenna will be updated to depend on newer versions.