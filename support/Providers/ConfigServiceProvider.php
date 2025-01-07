<?php

namespace Support\Providers;

use Support\Contracts\Config;
use Support\Core\Application;
use Support\Core\Config as ConfigLoader;

class ConfigServiceProvider extends BaseServiceProvider
{
    public function register(Application $app): void
    {
        $app->bind(Config::class, function () {
            return new ConfigLoader;
        });
    }
}
