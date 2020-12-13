<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

namespace BricksFramework\Bootstrap;

interface BootstrapConfigInterface
{
    public function getConfig() : array;
    public function getPhpIni() : array;
    public function getModules() : array;
    public function getAliases() : array;
    public function getAliasClass(string $class) : string;
    public function getModuleConfig(string $module) : array;
}