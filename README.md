# Laravel FCM (Firebase Cloud Messaging) Notification Channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jdpowered/laravel-fcm-channel.svg?style=flat-square)](https://packagist.org/packages/jdpowered/laravel-fcm-channel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jdpowered/laravel-fcm-channel/master.svg?style=flat-square)](https://travis-ci.org/jdpowered/laravel-fcm-channel)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/jdpowered/laravel-fcm-channel.svg?style=flat-square)](https://scrutinizer-ci.com/g/jdpowered/laravel-fcm-channel)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/jdpowered/laravel-fcm-channel/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/jdpowered/laravel-fcm-channel/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/jdpowered/laravel-fcm-channel.svg?style=flat-square)](https://packagist.org/packages/jdpowered/laravel-fcm-channel)

This package makes it easy to send notifications using [Firebase Cloud Messaging (FCM)](https://firebase.google.com/docs/cloud-messaging/) with Laravel 5.3 or above.

This package is based on [ZendService\Google\Gcm](https://github.com/zendframework/ZendService_Google_Gcm), so please read that documentation for more information.

## Contents

- [Installation](#installation)
	- [Setting up the FCM service](#setting-up-the-fcm-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

Install this package with Composer:

```bash
composer require jdpowered/laravel-fcm-channel
```

If you're running Laravel 5.3 you must install this service provider.

```php
// config/app.php

'providers' => [
    ...
    JdPowered\FcmNotificationChannel\FcmServiceProvider::class,
];
```

### Setting up the FCM service

You need to register for a *server key* for Firebase Cloud Messaging for your App in the [Firebase Console](https://console.firebase.google.com/)

Add the *server key* to your broadcasting configuration.

```php
// config/broadcasting.php

'connections' => [
  ...
  'fcm' => [
      'key' => env('FCM_KEY'),
  ],
  ...
]
```

```dotenv
// .env

FCM_KEY=c169cc12-cb26-4cb9-983f-f41cebadf402
```

## Usage

TODO

### Available Message methods

TODO

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email <hello@jd-powered.net> instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Jonas Döbertin](https://github.com/JonasDoebertin)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
