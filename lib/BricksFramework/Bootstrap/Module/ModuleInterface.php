<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Bootstrap\Module;

use BricksFramework\Bootstrap\BootstrapInterface;

interface ModuleInterface
{
    public function getAutoloaderClasses() : array;

    public function getInitializerClasses() : array;

    public function getPriority() : int;

    public function preBootstrap(BootstrapInterface $bootstrap) : void;

    public function bootstrap(BootstrapInterface $bootstrap) : void;

    public function postBootstrap(BootstrapInterface $bootstrap) : void;
}