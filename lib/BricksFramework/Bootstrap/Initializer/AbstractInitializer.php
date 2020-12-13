<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Bootstrap\Initializer;

use BricksFramework\Bootstrap\BootstrapInterface;

abstract class AbstractInitializer implements InitializerInterface
{
    public function initialize(BootstrapInterface $bootstrap): void
    {
    }

    public function getPriority(): int
    {
        return 0;
    }
}