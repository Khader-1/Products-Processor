<?php

namespace App\Repositories;

use App\Contracts\CombinationsConsumer;
use App\Contracts\ProductSource;
use App\Models\Product;

class ProductRepository
{
    protected $combinations = [];

    public function __construct(
        protected ProductSource $source,
        protected CombinationsConsumer $consumer,
        protected array $properties
    ) {}

    public function setSourceFile(string $path): void
    {
        $this->source->setFile($path);
    }

    public function setConsumerFile(string $path): void
    {
        $this->consumer->setFile($path);
    }

    public function generateCombinations(): void
    {
        foreach ($this->source->next() as $productAttributes) {
            $this->handleProduct(new Product($productAttributes));
        }
        foreach ($this->combinations as $key => $combination) {
            $this->consumer->write($combination['product'], $combination['count']);
        }
    }

    public function handleProduct(Product $product): void
    {
        if (@$this->combinations[$product->getKey()] === null) {
            $this->combinations[$product->getKey()] = [
                'product' => $product,
                'count' => 1,
            ];
        } else {
            $this->combinations[$product->getKey()]['count']++;
        }
        print_r($product->__toString().PHP_EOL);
    }

    public function getRequiredAttributes(): array
    {
        foreach ($this->properties as $key => $options) {
            if (@$options['required']) {
                $requiredAttributes[] = $key;
            }
        }

        return $requiredAttributes;
    }

    public function guardRequiredAttributesExist(array $productAttributes): void
    {
        foreach ($this->getRequiredAttributes() as $attribute) {
            if (! array_key_exists($attribute, $productAttributes)) {
                throw new \Exception("Attribute $attribute is required");
            }
        }
    }
}
