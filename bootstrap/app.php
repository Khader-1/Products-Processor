<?php

use Support\Core\Application;

require __DIR__.'/../vendor/autoload.php';

$app = new Application;

$app->registerProviders([
    Support\Providers\ConfigServiceProvider::class,
    App\Providers\AppServiceProvider::class,
]);

$app->bootProviders();

return $app;
