<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParserTest extends TestCase
{
    protected string $inputFile;

    protected string $outputFile;

    protected function setUp(): void
    {
        parent::setUp();

        $this->inputFile = __DIR__.'/temp_products.csv';
        file_put_contents($this->inputFile, "name,category\nProduct 1,Category 1\nProduct 1,Category 1\nProduct 2,Category 2\n");

        $this->outputFile = __DIR__.'/unique_combinations.csv';

        if (file_exists($this->outputFile)) {
            unlink($this->outputFile);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        if (file_exists($this->inputFile)) {
            unlink($this->inputFile);
        }

        if (file_exists($this->outputFile)) {
            unlink($this->outputFile);
        }
    }

    public function test_parser_passes()
    {
        $output = shell_exec("php parser.php --file={$this->inputFile} --unique-combinations={$this->outputFile}");

        $this->assertNotNull($output);

        $this->assertFileExists($this->outputFile);

        $expectedOutput = "name,category,count\n\"Product 1\",\"Category 1\",2\n\"Product 2\",\"Category 2\",1\n";
        $this->assertEquals($expectedOutput, file_get_contents($this->outputFile));
    }

    public function test_parser_fails_with_missing_input_file()
    {
        // Remove the input file
        if (file_exists($this->inputFile)) {
            unlink($this->inputFile);
        }

        $output = shell_exec("php parser.php --file={$this->inputFile} --unique-combinations={$this->outputFile} 2>&1");

        $this->assertStringContainsString("Error: File not found: {$this->inputFile}", $output);
        $this->assertFileDoesNotExist($this->outputFile);
    }

    public function test_parser_uses_default_output_path_if_not_selected()
    {
        shell_exec("php parser.php --file={$this->inputFile} 2>&1");

        $defaultOutputFile = './unique-combinations.csv';
        $this->assertFileExists($defaultOutputFile);

        if (file_exists($defaultOutputFile)) {
            unlink($defaultOutputFile);
        }
    }
}
