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
     * @return self
     */
    public function __construct(Application $application)
    {
        $name = $application['console.name'];
        $version = $application['console.version'];

        parent::__construct($name, $version);

        $this->application = $application;
        $this->rootDirectory = $application['console.root_directory'];

        $application->boot();

        foreach ($application['console.commands'] as $command) {
            $this->add(new $command());
        }
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
