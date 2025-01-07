<?php

namespace Tests\Unit\App\Repositories;

use App\Contracts\CombinationsConsumer;
use App\Contracts\ProductSource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    private ProductRepository $repository;

    private $mockSource;

    private $mockConsumer;

    private array $mockProperties;

    protected function setUp(): void
    {
        $this->mockSource = $this->createMock(ProductSource::class);
        $this->mockConsumer = $this->createMock(CombinationsConsumer::class);

        $this->mockProperties = [
            'name' => ['required' => true],
            'category' => ['required' => false],
        ];

        $this->repository = new ProductRepository($this->mockSource, $this->mockConsumer, $this->mockProperties);
    }

    public function test_set_source_file()
    {
        $this->mockSource
            ->expects($this->once())
            ->method('setFile')
            ->with('products.csv');

        $this->repository->setSourceFile('products.csv');
    }

    public function test_set_consumer_file()
    {
        $this->mockConsumer
            ->expects($this->once())
            ->method('setFile')
            ->with('output.csv');

        $this->repository->setConsumerFile('output.csv');
    }

    public function test_generate_combinations()
    {
        $this->mockSource
            ->method('next')
            ->willReturn($this->generateProducts());

        $this->mockConsumer
            ->expects($this->exactly(2))
            ->method('write');

        $this->repository->generateCombinations();
    }

    public function test_handle_product_with_unique_and_duplicate_products()
    {
        $product1 = new Product(['name' => 'Product 1', 'category' => 'Category 1']);
        $this->repository->handleProduct($product1);

        $this->repository->handleProduct($product1);

        $product2 = new Product(['name' => 'Product 2', 'category' => 'Category 2']);
        $this->repository->handleProduct($product2);

        $combinations = (new \ReflectionClass($this->repository))->getProperty('combinations');
        $combinations->setAccessible(true);
        $result = $combinations->getValue($this->repository);

        $this->assertCount(2, $result);
        $this->assertEquals(2, $result[$product1->getKey()]['count']);
        $this->assertEquals(1, $result[$product2->getKey()]['count']);
    }

    public function test_get_required_attributes()
    {
        $requiredAttributes = $this->repository->getRequiredAttributes();
        $this->assertEquals(['name'], $requiredAttributes);
    }

    public function test_guard_required_attributes_exist_with_valid_attributes()
    {
        $this->repository->guardRequiredAttributesExist(['name' => 'Product 1']);
        $this->assertTrue(true); // No exception means the test passes
    }

    public function test_guard_required_attributes_exist_with_missing_attributes()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Attribute name is required');

        $this->repository->guardRequiredAttributesExist(['category' => 'Category 1']);
    }

    private function generateProducts(): \Generator
    {
        yield ['name' => 'Product 1', 'category' => 'Category 1'];
        yield ['name' => 'Product 1', 'category' => 'Category 1'];
        yield ['name' => 'Product 2', 'category' => 'Category 2'];
    }
}
