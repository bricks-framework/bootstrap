<?php

/** @copyright Sven Ullmann <kontakt@sumedia-webdesign.de> **/

declare(strict_types=1);

namespace BricksFramework\Bootstrap;

class BootstrapConfig implements BootstrapConfigInterface
{
    protected $config = [];

    public function __construct(array $bootConfig, string $env)
    {
        $this->config = array_merge(
            $bootConfig['default'] ?? [],
            $bootConfig[$env] ?? []
        );
    }

    public function getConfig() : array
    {
        return $this->config;
    }

    public function getPhpIni() : array
    {
        return $this->config['php'] ?? [];
    }

    public function getModules() : array
    {
        return $this->config['modules'] ?? [];
    }

    public function getAliases() : array
    {
        return $this->config['aliases'] ?? [];
    }

    public function getAliasClass(string $class) : string
    {
        return $this->config['aliases'][$class] ?? $class;
    }

    public function getModuleConfig(string $module) : array
    {
        $return = [];
        if (isset($this->config[$module])) {
            return $this->config[$module];
        }
        return $return;
    }
}
