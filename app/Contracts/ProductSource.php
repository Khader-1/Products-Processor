<?php

namespace App\Contracts;

use Generator;

interface ProductSource
{
    public function setFile(string $path): void;

    public function next(): Generator;
}
