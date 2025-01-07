<?php

namespace Tests\Unit\App\Models;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_constructor_and_to_array()
    {
        $attributes = ['name' => 'Product 1', 'category' => 'Category 1'];
        $product = new Product($attributes);

        $this->assertEquals($attributes, $product->toArray());
    }

    public function test_get_key()
    {
        $attributes = ['name' => 'Product 1', 'category' => 'Category 1'];
        $product = new Product($attributes);

        $expectedKey = 'name: Product 1-category: Category 1-';
        $this->assertEquals($expectedKey, $product->getKey());
    }

    public function test_magic_get_and_set()
    {
        $product = new Product(['name' => 'Product 1']);

        // Test __get
        $this->assertEquals('Product 1', $product->name);

        // Test __set
        $product->category = 'Category 1';
        $this->assertEquals('Category 1', $product->category);
    }

    public function test_magic_isset_and_unset()
    {
        $product = new Product(['name' => 'Product 1']);

        // Test __isset
        $this->assertTrue(isset($product->name));
        $this->assertFalse(isset($product->category));

        // Test __unset
        unset($product->name);
        $this->assertFalse(isset($product->name));
    }

    public function test_to_string()
    {
        $attributes = ['name' => 'Product 1', 'category' => 'Category 1'];
        $product = new Product($attributes);

        $expectedString = "name: Product 1\ncategory: Category 1\n";
        $this->assertEquals($expectedString, (string) $product);
    }
}
