<?php

namespace LukeZbihlyj\SilexPlus\Console;

use Symfony\Component\EventDispatcher\Event;

/**
 * @package LukeZbihlyj\SilexPlus\Console\ConsoleEvent
 */
class ConsoleEvent extends Event
{
    /**
     * @var ConsoleApplication
     */
    protected $application;

    /**
     * @param ConsoleApplication $console
     */
    public function __construct(ConsoleApplication $console)
    {
        $this->console = $console;
    }

    /**
     * @return ConsoleApplication
     */
    public function getConsole()
    {
        return $this->console;
    }
}
