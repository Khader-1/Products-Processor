<?php

namespace Support\Core;

use ReflectionClass;
use ReflectionException;

class Container
{
    private array $bindings = [];

    public function bind(string $abstract, callable $factory)
    {
        $this->bindings[$abstract] = $factory;
    }

    public function resolve(string $abstract)
    {
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]($this);
        }

        if (! class_exists($abstract)) {
            throw new ReflectionException("Class {$abstract} does not exist");
        }

        $reflection = new ReflectionClass($abstract);

        $constructor = $reflection->getConstructor();
        if (! $constructor) {
            return new $abstract;
        }

        $parameters = $constructor->getParameters();
        $dependencies = array_map(function ($parameter) {
            $type = $parameter->getType();
            if ($type && ! $type->isBuiltin()) {
                return $this->resolve($type->getName());
            }
            throw new ReflectionException("Cannot resolve parameter {$parameter->getName()}");
        }, $parameters);

        return $reflection->newInstanceArgs($dependencies);
    }
}
