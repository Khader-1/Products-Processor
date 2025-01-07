<?php

namespace Tests\Unit\App\CSV;

use App\CSV\CSVCombinationsConsumer;
use App\Models\Product;
use Tests\TestCase;

class CSVCombinationsConsumerTest extends TestCase
{
    protected string $filePath;

    protected function setUp(): void
    {
        $this->filePath = __DIR__.'/output.csv';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function test_write_to_csv()
    {
        $consumer = new CSVCombinationsConsumer;
        $consumer->setFile($this->filePath);

        $product = new Product(['name' => 'Product 1', 'category' => 'Category 1']);
        $consumer->write($product, 5);

        $this->assertFileExists($this->filePath);

        $contents = file_get_contents($this->filePath);
        $this->assertStringContainsString('name,category,count', $contents);
        $this->assertStringContainsString('"Product 1","Category 1",5', $contents);
    }
}
