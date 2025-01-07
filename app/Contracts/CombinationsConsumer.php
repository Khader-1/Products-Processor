<?php

namespace App\Contracts;

use App\Models\Product;

interface CombinationsConsumer
{
    public function setFile(string $path): void;

    public function write(Product $product, int $count): void;
}
