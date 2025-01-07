<?php

namespace Tests\Unit\Support\Providers;

use PHPUnit\Framework\TestCase;
use Support\Contracts\Config;
use Support\Core\Application;
use Support\Core\Config as ConfigLoader;
use Support\Providers\ConfigServiceProvider;

class ConfigServiceProviderTest extends TestCase
{
    public function test_config_service_provider_registers_config()
    {
        $app = new Application;
        $provider = new ConfigServiceProvider;
        $provider->register($app);
        $config = $app->get(Config::class);

        $this->assertInstanceOf(ConfigLoader::class, $config);
    }
}
