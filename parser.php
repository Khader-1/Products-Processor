<?php

use Support\Contracts\Config;

$app = require __DIR__.'/bootstrap/app.php';
$config = $app->get(Config::class);

echo $config->get('app.name').PHP_EOL;
