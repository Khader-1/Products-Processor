<?php

namespace Support\Providers;

use Support\Contracts\ServiceProviderInterface;
use Support\Core\Application;

abstract class BaseServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app): void {}

    public function boot(Application $app): void {}
}
