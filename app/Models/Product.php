<?php

namespace App\Models;

class Product
{
    public function __construct(public array $attributes) {}

    public function getKey()
    {
        $str = '';
        foreach ($this->attributes as $key => $value) {
            $str .= $key.': '.$value.'-';
        }

        return $str;
    }

    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, mixed $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public function __unset(string $name)
    {
        unset($this->attributes[$name]);
    }

    public function __toString(): string
    {
        $str = '';
        foreach ($this->attributes as $key => $value) {
            $str .= $key.': '.$value.PHP_EOL;
        }

        return $str;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}
