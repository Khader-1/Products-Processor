<?php

namespace Support\Core;

use Support\Contracts\Config as ConfigContract;

class Config implements ConfigContract
{
    public array $config = [];

    public function __construct()
    {
        $this->loadConfigs();
    }

    public function loadConfigs(): void
    {
        $configPath = __DIR__.'/../../config';
        foreach (glob($configPath.'/*.php') as $file) {
            $this->config[basename($file, '.php')] = require $file;
        }
    }

    public function get(string $key, $default = null)
    {
        $segments = explode('.', $key);
        $value = $this->config;

        foreach ($segments as $segment) {
            if (! isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}
