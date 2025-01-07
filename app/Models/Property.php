<?php

namespace App\Models;

class Property
{
    public function __construct(public string $name, public string $type, public bool $required = false) {}
}
