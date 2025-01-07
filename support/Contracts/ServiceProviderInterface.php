<?php

namespace Support\Contracts;

use Support\Core\Application;

interface ServiceProviderInterface
{
    public function register(Application $app): void;

    public function boot(Application $app): void;
}
