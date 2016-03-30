<?php

namespace LukeZbihlyj\SilexPlus\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Silex\Application as Application;

/**
 * @package LukeZbihlyj\SilexPlus\Console\ConsoleApplication
 */
class ConsoleApplication extends BaseApplication
{
    /**
     * @var Application
     */
    protected $application;

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @param Application $application
     * @param string $rootDirectory
     * @param string $name
     * @param string $version
     */
    public function __construct(Application $application, $rootDirectory, $name = 'Application', $version = '1.0.0')
    {
        parent::__construct($name, $version);

        $this->application = $application;
        $this->rootDirectory = $rootDirectory;

        $application->boot();
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return string
     */
    public function getRootDirectory()
    {
        return $this->rootDirectory;
    }
}
