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
];
