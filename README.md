# MailTracker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

MailTracker will hook into all outgoing emails from Laravel and inject a tracking code into it.  It will also store the rendered email in the database.  There is also an interface to view sent emails.

## Install

Via Composer

``` bash
$ composer require jdavidbakr/MailTracker
```

Add the following to the providers array in config/app.php:

``` php
jdavidbakr\MailTracker\MailTrackerServiceProvider::class,
```

Publish the config file and migration
``` bash
$ php artisan vendor publish
```

Run the migration
``` bash
$ php artisan migrate
```

## Usage

Once installed, all outgoing mail will be logged to the database.  The following config options are available in config/mail-tracker.php:

* **inject-pixel**: set to true to inject a tracking pixel into all outgoing html emails.
* **track-links**: set to true to rewrite all anchor href links to include a tracking link. The link will take the user back to your website which will then redirect them to the final destination after logging the click.
* **expire-days**: How long in days that an email should be retained in your database.  If you are sending a lot of mail, you probably want it to eventually expire.  Set it to zero to never purge old emails from the database.
* **route**: The route information for the tracking URLs.  Set the prefix and middlware as desired.
* **admin-route**: The route information for the admin.  Set the prefix and middleware. *Note that this is not yet built.*

## TODO

Currently this plugin is only tracking the outgoing mail. There is no view yet to explore the existing data.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email me@jdavidbaker.com instead of using the issue tracker.

## Credits

- [J David Baker][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jdavidbakr/MailTracker.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jdavidbakr/MailTracker/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jdavidbakr/MailTracker.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jdavidbakr/MailTracker.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jdavidbakr/MailTracker.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jdavidbakr/MailTracker
[link-travis]: https://travis-ci.org/jdavidbakr/MailTracker
[link-scrutinizer]: https://scrutinizer-ci.com/g/jdavidbakr/MailTracker/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/jdavidbakr/MailTracker
[link-downloads]: https://packagist.org/packages/jdavidbakr/MailTracker
[link-author]: https://github.com/jdavidbakr
[link-contributors]: ../../contributors
