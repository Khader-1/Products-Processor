<?php

namespace Tests\Unit\Support\Core;

use PHPUnit\Framework\TestCase;
use Support\Core\Container;

class ContainerTest extends TestCase
{
    public function test_bind_and_resolve()
    {
        $container = new Container;

        $container->bind('test', function () {
            return 'resolved value';
        });

        $resolved = $container->resolve('test');
        $this->assertEquals('resolved value', $resolved);
    }

    public function test_resolve_with_dependencies()
    {
        $container = new Container;

        $resolved = $container->resolve(SampleClass::class);
        $this->assertInstanceOf(SampleClass::class, $resolved);
    }
}

class SampleClass
{
    // Example class to resolve in the container
}
