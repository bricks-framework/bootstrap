<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Bootstrap\Autoloader;

use BricksFramework\Bootstrap\BootstrapInterface;

abstract class AbstractAutoloader implements AutoloaderInterface
{

    public function load(BootstrapInterface $bootstrap): void
    {
    }

    public function getPriority(): int
    {
        return 0;
    }
}