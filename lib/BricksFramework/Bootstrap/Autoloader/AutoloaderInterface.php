<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Bootstrap\Autoloader;

use BricksFramework\Bootstrap\BootstrapInterface;

interface AutoloaderInterface
{
    public function load(BootstrapInterface $bootstrap) : void;

    public function getPriority() : int;
}
