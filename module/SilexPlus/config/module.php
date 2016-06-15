<?php

/**
 * Specify application-specific configuration. These settings can be over-ridden
 * by the local environmental settings, so it's safe to specify default values
 * here.
 */
return [
    /**
     * Define a list of providers that should be iniitalised. Some of these require
     * arguments so those can be defined too.
     */
    'services' => [],

    /**
     * Define a list of modules that should be initialised when the application
     * launches.
     */
    'modules' => [],

    /**
     * Define the name of the application to be shown when running the help command.
     */
    'console.name' => 'App',

    /**
     * Define the version of the application that should be shown when running the
     * help command.
     */
    'console.version' => '1.0.0',

    /**
     * Define the root directory for the project, which should be set in the application
     * bootstrap process or in module configuration.
     */
    'console.root_directory' => null,

    /**
     * Define a list of commands that should be added to the console on initialisation.
     */
    'console.commands' => [],

    /*
     * Define the session cookie name.
     */
    'session.cookie_name' => 'app-session',

    /**
     * Define the session cookie lifetime (default ~1 year).
     */
    'session.lifetime' => 31536000,

    /**
     * Define the session storage handler class - if left blank then it will default
     * to PHP's configured session handler (file based).
     */
    'session.storage_handler' => null,

    /**
     * Optional: Define the Redis server's connection information for sessions, only used
     * when the session_handler is set to RedisStorageHandler.
     */
    'session.redis' => '127.0.0.1:6379',

    /**
     * Define the default locale to fall back to in case the user hasn't selected
     * one yet.
     */
    'i18n.default_locale' => 'en_US.utf8',

    /**
     * Define the path to our locale files, which should confirm to the gettext structure
     * which uses subdirectories containing LC_MESSAGES folders.
     */
    'i18n.locale_path' => __DIR__ . '/../locale',
];
