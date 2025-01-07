<?php

namespace Support\Core;

use Support\Contracts\ServiceProviderInterface;

class Application
{
    protected Container $container;

    protected array $providers = [];

    public function __construct()
    {
        $this->container = new Container;
    }

    public function registerProvider(ServiceProviderInterface $provider): void
    {
        $provider->register($this);
        $this->providers[] = $provider;
    }

    public function registerProviders(array $providers): void
    {
        foreach ($providers as $provider) {
            if (is_string($provider)) {
                $provider = new $provider;
            }
            $this->registerProvider($provider);
        }
    }

    public function bootProviders(): void
    {
        foreach ($this->providers as $provider) {
            $provider->boot($this);
        }
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function get(string $abstract)
    {
        return $this->container->resolve($abstract);
    }

    public function bind(string $abstract, callable $factory)
    {
        $this->container->bind($abstract, $factory);
    }
}
