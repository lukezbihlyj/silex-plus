<?php

namespace LukeZbihlyj\SilexPlus\Console;

use Symfony\Component\Console\Command\Command as BaseCommand;

/**
 * @package LukeZbihlyj\SilexPlus\Console\ConsoleCommand
 */
class ConsoleCommand extends BaseCommand
{
    /**
     * @return Application
     */
    public function getSilexApp()
    {
        return $this->getApplication()->getApplication();
    }

    /**
     * @return string
     */
    public function getRootDirectory()
    {
        return $this->getApplication()->getRootDirectory();
    }
}
