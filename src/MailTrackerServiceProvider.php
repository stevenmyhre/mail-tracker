<?php

namespace jdavidbakr\MailTracker;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Events\Dispatcher;

class MailTrackerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, Router $router)
    {
        // Publish pieces
        $this->publishes([
            __DIR__.'/../config/mail-tracker.php' => config_path('mail-tracker.php')
        ], 'config');
        $this->publishes([
            __DIR__.'/../migrations/2016_03_01_193027_create_sent_emails_table.php' => database_path('migrations/2016_03_01_193027_create_sent_emails_table.php')
        ], 'config');

        // Hook into the mailer
        $this->app['mailer']->getSwiftMailer()->registerPlugin(new MailTracker());

        // Install the routes
        $config = $this->app['config']->get('mail-tracker.route', []);
        $config['namespace'] = 'jdavidbakr\MailTracker';

        $router->group($config, function($router)
        {
            $router->controller('/', 'MailTrackerController');
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}