<?php

namespace Tests\Unit\Support\Core;

use PHPUnit\Framework\TestCase;
use Support\Core\Config;

class ConfigTest extends TestCase
{
    protected string $configDir;

    protected function setUp(): void
    {
        $this->configDir = __DIR__.'/temp_config';
        if (! is_dir($this->configDir)) {
            mkdir($this->configDir, 0777, true);
        }

        file_put_contents($this->configDir.'/app.php', "<?php return ['name' => 'TestApp', 'env' => 'testing'];");
        file_put_contents($this->configDir.'/database.php', "<?php return ['host' => '127.0.0.1', 'port' => 3306];");
    }

    protected function tearDown(): void
    {
        foreach (glob($this->configDir.'/*.php') as $file) {
            unlink($file);
        }
        rmdir($this->configDir);
    }

    public function test_config_loading()
    {
        $mockedConfig = $this->getMockBuilder(Config::class)
            ->onlyMethods(['loadConfigs'])
            ->getMock();

        $configPath = __DIR__.'/temp_config';
        $mockedConfig->expects($this->once())
            ->method('loadConfigs')
            ->willReturnCallback(function () use ($mockedConfig, $configPath) {
                foreach (glob($configPath.'/*.php') as $file) {
                    $mockedConfig->config[basename($file, '.php')] = require $file;
                }
            });
        $mockedConfig->loadConfigs();

        $this->assertEquals('TestApp', $mockedConfig->get('app.name'));
        $this->assertEquals('testing', $mockedConfig->get('app.env'));
        $this->assertEquals(3306, $mockedConfig->get('database.port'));
        $this->assertNull($mockedConfig->get('nonexistent.key'));
    }

    public function test_get_with_default()
    {
        $config = new Config;

        $this->assertEquals('default_value', $config->get('nonexistent.key', 'default_value'));
    }
}
