<?php

use App\Commands\ParseCommand;

$app = require __DIR__.'/bootstrap/app.php';
$command = $app->get(ParseCommand::class);

$command->run(array_slice($argv, 1));
