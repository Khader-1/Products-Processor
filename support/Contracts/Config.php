<?php

namespace Support\Contracts;

interface Config
{
    public function get(string $key, $default = null);
}
