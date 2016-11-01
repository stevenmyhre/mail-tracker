# MailTracker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

MailTracker will hook into all outgoing emails from Laravel/Lumen and inject a tracking code into it.  It will also store the rendered email in the database.  There is also an interface to view sent emails.

## Upgrade from 1.x

First, upgrade to version 2.0 by running:

``` bash
$ composer require jdavidbakr/mail-tracker ~2.0
```

Version 2.0 contains a new model that tracks the links that were clicked on.  This requires a migration to create the table.  There are also additional changes to the config file.  For best results, make a backup copy of config/mail-tracker.php to restore any values you have customized, then delete that file and run

``` bash
$ php artisan vendor:publish
$ php artisan migrate
```

## Install (Laravel)

Via Composer

``` bash
$ composer require jdavidbakr/mail-tracker ~2.0
```

Add the following to the providers array in config/app.php:

``` php
jdavidbakr\MailTracker\MailTrackerServiceProvider::class,
```

Publish the config file and migration
``` bash
$ php artisan vendor:publish --provider='jdavidbakr\MailTracker\MailTrackerServiceProvider'
```

Run the migration
``` bash
$ php artisan migrate
```

## Install (Lumen)

Via Composer

``` bash
$ composer require jdavidbakr/mail-tracker ~2.0
```

Register the following service provider in bootstrap/app.php

``` php
jdavidbakr\MailTracker\MailTrackerServiceProvider::class
```

Copy vendor/jdavidbakr/mail-tracker/migrations/2016_03_01_193027_create_sent_emails_table.php and vendor/jdavidbakr/mail-tracker/config/mail-tracker.php to your respective migrations and config folders. You may have to create a config folder if it doesn't already exist.

Run the migration
``` bash
$ php artisan migrate
```

## Usage

Once installed, all outgoing mail will be logged to the database.  The following config options are available in config/mail-tracker.php:

* **name**: set your App Name.
* **inject-pixel**: set to true to inject a tracking pixel into all outgoing html emails.
* **track-links**: set to true to rewrite all anchor href links to include a tracking link. The link will take the user back to your website which will then redirect them to the final destination after logging the click.
* **expire-days**: How long in days that an email should be retained in your database.  If you are sending a lot of mail, you probably want it to eventually expire.  Set it to zero to never purge old emails from the database.
* **route**: The route information for the tracking URLs.  Set the prefix and middlware as desired.
* **admin-route**: The route information for the admin.  Set the prefix and middleware.
* **admin-template**: The params for the Admin Panel and Views. You can integrate your existing Admin Panel with the MailTracker admin panel.
* **date-format**: You can define the format to show dates in the Admin Panel.

## Events

When an email is viewed or a link is clicked, its tracking information is counted in the database using the jdavidbark\MailTracker\Model\SentEmail model. You may want to do additional processing on these events, so an event is fired in both cases:

* jdavidbakr\MailTracker\Events\ViewEmailEvent
* jdavidbakr\MailTracker\Events\LinkClickedEvent

To install an event listener, you will want to create a file like the following:

``` php
<?php

namespace App\Listeners;

use jdavidbakr\MailTracker\Events\ViewEmailEvent;

class EmailViewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ViewEmailEvent  $event
     * @return void
     */
    public function handle(ViewEmailEvent $event)
    {
        // Access the model using $event->sent_email...
    }
}
```

Then you must register the event in your \App\Providers\EventServiceProvider $listen array:

``` php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    'jdavidbakr\MailTracker\Events\ViewEmailEvent' => [
        'App\Listeners\EmailViewed',
    ],
];
```
## Views

When you do the php artisan vendor:publish simple views will add to your resources/views/vendor/emailTrakingViews and you can customize.

## Admin Panel

Config your admin-route in the config file. Set the prefix and middlware.
The route name is 'mailTracker_Index'. The standard admin panel route is located at /email-manager.
You can use route names to include them into your existing admin menu.
You can customize your route in the config file.
You can see all sent emails, total opens, total urls clicks, show individuals emails and show the urls clicked details.
All views (email tamplates, panel) can be customized in resources/views/vendor/emailTrakingViews.

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

[link-packagist]: https://packagist.org/packages/jdavidbakr/mail-tracker
[link-travis]: https://travis-ci.org/jdavidbakr/MailTracker
[link-scrutinizer]: https://scrutinizer-ci.com/g/jdavidbakr/MailTracker/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/jdavidbakr/MailTracker
[link-downloads]: https://packagist.org/packages/jdavidbakr/mail-tracker
[link-author]: https://github.com/jdavidbakr
[link-contributors]: ../../contributors
