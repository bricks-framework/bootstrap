<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Bootstrap\Module;

use BricksFramework\Bootstrap\BootstrapInterface;

abstract class AbstractModule implements ModuleInterface
{
    public function getAutoloaderClasses() : array
    {
        return [];
    }

    public function getInitializerClasses() : array
    {
        return [];
    }

    public function getPriority() : int
    {
        return 0;
    }

    public function preBootstrap(BootstrapInterface $bootstrap) : void
    {
    }

    public function bootstrap(BootstrapInterface $bootstrap) : void
    {
    }

    public function postBootstrap(BootstrapInterface $bootstrap) : void
    {
    }
}
