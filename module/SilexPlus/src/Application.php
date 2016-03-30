<?php

namespace LukeZbihlyj\SilexPlus;

use Silex\Application as SilexApplication;
use Silex\Application\UrlGeneratorTrait;
use Symfony\Component\HttpFoundation\Request;
use Igorw\Silex\ConfigServiceProvider;
use Whoops\Provider\Silex\WhoopsServiceProvider;

/**
 * @package LukeZbihlyj\SilexPlus\Application
 */
class Application extends SilexApplication
{
    use UrlGeneratorTrait;

    /**
     * @var string
     */
    protected $modulesConfigFile;

    /**
     * @var string
     */
    protected $localConfigFile;

    /**
     * Initialise the application's dependencies, providers and services. This
     * will read from known configuration files within the module and then the
     * environment configurations.
     *
     * @return void
     */
    public function init()
    {
        // Initialise the configuration files.
        $this->register(new ConfigServiceProvider(__DIR__ . '/../config/module.php'));

        // Load modules config too.
        if ($this->modulesConfigFile) {
            $this->register(new ConfigServiceProvider($this->modulesConfigFile));
        }

        // Load extra module configs.
        foreach ($this['modules'] as $module) {
            $moduleClass = $module . '\\Module';
            $module = new $moduleClass();

            $this->register(new ConfigServiceProvider($module->getConfigFile()));
        }

        // Load local config too.
        if ($this->localConfigFile) {
            $this->register(new ConfigServiceProvider($this->localConfigFile));
        }

        // Check if we should enable Whoops.
        if ($this->getDebug()) {
            $this->register(new WhoopsServiceProvider());
        }

        // Initialise the modules.
        foreach ($this['modules'] as $module) {
            $moduleClass = $module . '\\Module';
            $module = new $moduleClass();

            $module->init($this);
        }

        // Load custom services.
        $this->registerServices();

        // Initialise the console component.
        $this->setConsole($this->share(function() {
            $console = new Console\ConsoleApplication($this);

            $this->getDispatcher()->dispatch(Console\ConsoleEvents::INIT, new Console\ConsoleEvent($console));

            return $console;
        }));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request = null)
    {
        if (php_sapi_name() === 'cli') {
            return $this->getConsole()->run();
        }

        return parent::run($request);
    }

    /**
     * Set the location of the modules configuration file.
     *
     * @param string $file
     * @return self
     */
    public function setModulesConfig($file)
    {
        $this->modulesConfigFile = $file;

        return $this;
    }

    /**
     * Set the location of the local configuration file.
     *
     * @param string $file
     * @return self
     */
    public function setLocalConfig($file)
    {
        $this->localConfigFile = $file;

        return $this;
    }

    /**
     * Fetch a known service from our list of services, initialising the shared
     * closure with the application as an argument.
     *
     * @param string $name
     * @return mixed
     */
    public function getService($name)
    {
        if (isset($this['services'][$name])) {
            return $this['services'][$name]($this);
        }

        return null;
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, array $args)
    {
        $prefix = substr($method, 0, 3);
        $suffix = isset($method[3]) ? lcfirst(substr($method, 3)) : null;

        if ($prefix === 'get') {
            return $this[$suffix];
        } elseif ($prefix === 'set') {
            $this[$suffix] = isset($args[0]) ? $args[0] : null;
        }
    }

    /**
     * Register the custom services for the application, which are defined in the
     * configuration as closures.
     *
     * @return void
     */
    protected function registerServices()
    {
        $services = [];

        foreach ($this['services'] as $service => $closure) {
            $services[$service] = $this->share($closure);
        }

        $this->setServices($services);
    }
}
