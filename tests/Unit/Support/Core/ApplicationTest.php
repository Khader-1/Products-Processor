<?php

namespace Tests\Unit\Support\Core;

use PHPUnit\Framework\TestCase;
use Support\Core\Application;
use Support\Core\Config;
use Support\Providers\ConfigServiceProvider;

class ApplicationTest extends TestCase
{
    public function test_container_binding_and_resolution()
    {
        $app = new Application;

        $app->bind('example', function () {
            return 'example value';
        });

        $resolved = $app->get('example');
        $this->assertEquals('example value', $resolved);
    }

    public function test_register_and_boot_providers()
    {
        $app = new Application;
        $provider = $this->createMock(ConfigServiceProvider::class);

        $provider->expects($this->once())->method('register')->with($app);
        $provider->expects($this->once())->method('boot')->with($app);

        $app->registerProvider($provider);
        $app->bootProviders();
    }

    public function test_config_loading()
    {
        $config = new Config;
        $appName = $config->get('app.name', 'default_name');

        $this->assertNotEmpty($appName, 'The config value should not be empty.');
    }
}
