<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

/**
 * @copyright Sumedia 2020 <kontakt@sumedia-webdesign.de>
 * @author Sven Ullmann <kontakt@sumedia-webdesign.de>
 */

namespace BricksFramework\Bootstrap;

use BricksFramework\Environment\EnvironmentInterface;
use BricksFramework\Container\PsrContainerInterface;

interface BootstrapInterface
{
    public function getContainer() : PsrContainerInterface;
    public function getEnvironment() : EnvironmentInterface;
    public function getInstance(string $class, array $parameters = []) : object;
    public function getBootstrapConfig() : BootstrapConfigInterface;
    public function setService(string $name, object $service) : void;
    public function getService(string $name) : ?object;
    public function getServices() : array;
    public function bootstrap() : void;
}
