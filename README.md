# Tracking (actions, activity & traffic)

[![Packagist PHP support](https://img.shields.io/packagist/php-v/sfneal/tracking)](https://packagist.org/packages/sfneal/tracking)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfneal/tracking.svg?style=flat-square)](https://packagist.org/packages/sfneal/tracking)
[![Build Status](https://travis-ci.com/sfneal/tracking.svg?branch=master&style=flat-square)](https://travis-ci.com/sfneal/tracking)
[![Quality Score](https://img.shields.io/scrutinizer/g/sfneal/tracking.svg?style=flat-square)](https://scrutinizer-ci.com/g/sfneal/tracking)
[![Total Downloads](https://img.shields.io/packagist/dt/sfneal/tracking.svg?style=flat-square)](https://packagist.org/packages/sfneal/tracking)

Add persistent traffic, action & activity tracking to a Laravel Application through middleware & events/listeners.

## Installation

You can install the package via composer:

```bash
composer require sfneal/tracking
```

To make use of database migration, publish the Service Provider.

``` php
php artisan vendor:publish --provider="Sfneal\Tracking\Providers\TrackingServiceProvider"
```

## Usage

``` php
// Usage description here
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email stephen.neal14@gmail.com instead of using the issue tracker.

## Credits

- [Stephen Neal](https://github.com/sfneal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
