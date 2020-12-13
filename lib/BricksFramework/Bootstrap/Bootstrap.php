<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

declare(strict_types=1);

namespace BricksFramework\Bootstrap;

use BricksFramework\Container\PsrContainerInterface;
use BricksFramework\Environment\EnvironmentInterface;
use Composer\Autoload\ClassLoader;

class Bootstrap implements BootstrapInterface
{
    /** @var ClassLoader */
    protected $autoloader;

    /** @var BootstrapConfig */
    protected $bootstrapConfig;

    /** @var EnvironmentInterface */
    protected $environment;

    /** @var PsrContainerInterface */
    protected $container;

    /** @var \BricksFramework\Bootstrap\Module\ModuleInterface */
    protected $modules;

    /** @var \BricksFramework\Bootstrap\Initializer\InitializerInterface */
    protected $initializers;

    protected $services = [];

    public function __construct(
        array $bootConfig,
        EnvironmentInterface $environment,
        string $applicationExecutionCallbackName = 'run'
    ) {
        set_error_handler([new ErrorHandler(), 'handle']);

        $this->bootstrapConfig = new BootstrapConfig($bootConfig, $environment->getCurrentEnvironment());
        $this->setPhpIni($this->getBootstrapConfig()->getPhpIni());
        $this->environment = $environment;
        $this->container = $this->getInstance('BricksFramework\\Container\\PsrContainer');
        $this->modules = $this->getInstance('BricksFramework\\Bootstrap\\Modules');
        $this->autoloaders = $this->getInstance('BricksFramework\\Bootstrap\\Autoloaders');
        $this->initializers = $this->getInstance('BricksFramework\\Bootstrap\\Initializers');
        $this->container->set('bricks/bootstrap', $this);
    }

    protected function setPhpIni(array $iniSettings) : void
    {
        foreach ($iniSettings as $key => $value) {
            ini_set($key, "$value");
        }
    }

    public function getEnvironment() : EnvironmentInterface
    {
        return $this->environment;
    }

    public function getContainer() : PsrContainerInterface
    {
        return $this->container;
    }

    public function getBootstrapConfig() : BootstrapConfigInterface
    {
        return $this->bootstrapConfig;
    }

    public function getInstance(string $class, array $arguments = []) : object
    {
        $class = $this->getBootstrapConfig()->getAliasClass($class);
        return new $class(...array_values($arguments));
    }

    protected function initializeModules() : void
    {
        foreach ($this->getBootstrapConfig()->getModules() as $moduleClass) {
            /** @var \BricksFramework\Bootstrap\Initializer\InitializerInterface $module */
            $module = new $moduleClass;
            $priority = $module->getPriority();
            $this->modules->push($module, $priority);
        }
    }

    public function setService(string $containerName, object $service) : void
    {
        if (!in_array($containerName, $this->services)) {
            $this->getContainer()->set($containerName, $service);
            $this->services[] = $containerName;
        }
    }

    public function getService(string $containerName) : ?object
    {
        if (in_array($containerName, $this->services)) {
            return $this->getContainer()->get($containerName);
        }
        return null;
    }

    public function getServices() : array
    {
        return $this->services;
    }

    protected function initializeAutoloaders() : void
    {
        foreach ($this->modules as $module) {
            $autoloaderClasses = $module->getAutoloaderClasses();
            if (!empty($autoloaderClasses)) {
                foreach ($autoloaderClasses as $autoloaderClass) {
                    /** @var \BricksFramework\Bootstrap\Autoloader\AutoloaderInterface $autoloader */
                    $autoloader = new $autoloaderClass;
                    $priority = $autoloader->getPriority();
                    $this->autoloaders->push($autoloader, $priority);
                }
            }
        }
    }

    protected function initializeInitializers() : void
    {
        foreach ($this->modules as $module) {
            $classes = $module->getInitializerClasses();
            if (!empty($classes)) {
                foreach ($classes as $class) {
                    /** @var \BricksFramework\Bootstrap\Module\ModuleInterface $initializer */
                    $initializer = new $class;
                    $priority = $initializer->getPriority();
                    $this->initializers->push($initializer, $priority);
                }
            }
        }
    }

    protected function autoloaderConfigure() : void
    {
        foreach ($this->autoloaders as $autoloader) {
            $autoloader->load($this, $this->environment->getAutoloader());
        }
    }

    protected function initialize() : void
    {
        foreach ($this->initializers as $initializer) {
            $initializer->initialize($this);
        }
    }

    public function bootstrap() : void
    {
        $this->initializeModules();
        $this->initializeAutoloaders();
        $this->initializeInitializers();
        $this->autoloaderConfigure();
        $this->initialize();

        foreach ($this->modules as $module) {
            $module->preBootstrap($this);
        }

        foreach ($this->modules as $module) {
            $module->bootstrap($this);
        }

        foreach ($this->modules as $module) {
            $module->postBootstrap($this);
        }
    }
}
