<?php

namespace App\Providers;

use App\Commands\ParseCommand;
use App\Contracts\CombinationsConsumer;
use App\Contracts\ProductSource;
use App\Models\Property;
use App\Repositories\ProductRepository;
use Support\Contracts\Config;
use Support\Core\Application;
use Support\Providers\BaseServiceProvider;

class ParserServiceProvider extends BaseServiceProvider
{
    public function register(Application $app): void
    {
        $app->bind(ProductSource::class, function () use ($app) {
            return new ($app->get(Config::class)->get('parser.source'));
        });
        $app->bind(CombinationsConsumer::class, function () use ($app) {
            return new ($app->get(Config::class)->get('parser.sink'));
        });
        $app->bind(ProductRepository::class, function () use ($app) {
            return new ProductRepository(
                $app->get(ProductSource::class),
                $app->get(CombinationsConsumer::class),
                $this->loadProperties($app),
            );
        });
        $app->bind(ParseCommand::class, function () use ($app) {
            return new ParseCommand($app->get(ProductRepository::class));
        });
    }

    public function loadProperties(Application $app): array
    {
        $config = $app->get(Config::class);

        foreach ($config->get('parser.properties') as $property => $attributes) {
            $properties[] = new Property(
                name: $property,
                type: $attributes['type'],
                required: @$attributes['required'] ?? false
            );
        }

        return $properties ?? [];
    }
}
