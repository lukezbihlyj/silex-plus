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
    public function getConfigFile();

    /**
     * @param Application $app
     * @return void
     */
    public function init(Application $app);
}
