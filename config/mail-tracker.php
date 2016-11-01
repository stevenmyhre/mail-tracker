<?php

return [
	/*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | The application name for use in mail template
    |
    */

	/**
	 * Your Name Application.
	 */
    'name' => 'Mail Tracker',

	/**
	 * To disable the pixel injection, set this to false.
	 */
	'inject-pixel'=>true,

	/**
	 * To disable injecting tracking links, set this to false.
	 */
	'track-links'=>true,

	/**
	 * Optionally expire old emails, set to 0 to keep forever.
	 */
	'expire-days'=>60,

	/**
	 * Where should the pingback URL route be?
	 */
    'route' => [
        'prefix' => 'email',
        'middleware' => [],
    ],

    /**
     * Where should the admin route be?
     */
    'admin-route' => [
        'prefix' => 'email-manager',
        'middleware' => 'super',
    ],

    /**
     * Admin Tamplate
	 * example
	 * 'name' => 'layouts.app' for Default emailTraking use 'emailTrakingViews::layouts.app'
	 * 'section' => 'content' for Default emailTraking use 'content'
     */
    'admin-template' => [
        'name' => 'emailTrakingViews::layouts.app',
        'section' => 'content',
    ],

    /**
     * Number of emails per page in the admin view
     */
    'emails-per-page'=>30,

    /**
     * Date Format
     */
    'date-format' => 'm/d/Y g:i a',

];
