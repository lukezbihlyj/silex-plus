<?php

namespace LukeZbihlyj\SilexPlus;

/**
 * @package LukeZbihlyj\SilexPlus\ModuleInterface
 */
interface ModuleInterface
{
    /**
     * @return string
     */
    abstract public function getConfigFile();

    /**
     * @param Application $app
     * @return void
     */
    abstract public function init(Application $app);
}
