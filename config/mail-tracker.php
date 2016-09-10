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
	 * 'name' => 'layouts.app' for Deafult emailTraking use 'emailTrakingViews::layouts.app'
	 * 'section' => 'content' for Deafult emailTraking use 'content'
	 * 'styles_section' => 'styles' for Deafult emailTraking use 'styles'
     */
    'admin-template' => [
        'name' => 'emailTrakingViews::layouts.app',
        'section' => 'content',
        'styles_section' => 'styles',
    ],

    /**
     * Date Format
     */
    'date-format' => 'd/m/Y',

];
