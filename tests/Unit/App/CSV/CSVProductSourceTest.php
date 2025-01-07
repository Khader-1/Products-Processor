<?php

namespace Tests\Unit\App\CSV;

use App\CSV\CSVProductSource;
use Tests\TestCase;

class CSVProductSourceTest extends TestCase
{
    protected string $filePath;

    protected function setUp(): void
    {
        $this->filePath = __DIR__.'/products.csv';
        file_put_contents($this->filePath, "name,category\nProduct 1,Category 1\nProduct 2,Category 2");
    }

    protected function tearDown(): void
    {
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function test_read_from_csv()
    {
        $source = new CSVProductSource;
        $source->setFile($this->filePath);

        $products = iterator_to_array($source->next());

        $this->assertCount(2, $products);
        $this->assertEquals(['name' => 'Product 1', 'category' => 'Category 1'], $products[0]);
        $this->assertEquals(['name' => 'Product 2', 'category' => 'Category 2'], $products[1]);
    }
}
