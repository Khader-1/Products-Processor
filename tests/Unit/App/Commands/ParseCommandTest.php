<?php

namespace Tests\Unit\App\Commands;

use App\Commands\ParseCommand;
use App\Repositories\ProductRepository;
use Tests\TestCase;

class ParseCommandTest extends TestCase
{
    public function test_handle_missing_file()
    {
        $mockRepository = $this->createMock(ProductRepository::class);
        $command = new ParseCommand($mockRepository);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error: The --file option is required.');

        $command->handle([]);
    }

    public function test_handle_file_not_found()
    {
        $mockRepository = $this->createMock(ProductRepository::class);
        $command = new ParseCommand($mockRepository);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error: File not found: /non/existent/file.csv');

        $command->handle(['file' => '/non/existent/file.csv']);
    }

    public function test_handle_valid_file()
    {
        $mockRepository = $this->createMock(ProductRepository::class);
        $mockRepository->expects($this->once())->method('setSourceFile');
        $mockRepository->expects($this->once())->method('setConsumerFile');
        $mockRepository->expects($this->once())->method('generateCombinations');

        $command = new ParseCommand($mockRepository);

        $this->expectOutputString("Processing complete. Unique combinations saved to: output.csv\n");

        $command->handle(['file' => 'products_comma_separated.csv', 'unique-combinations' => 'output.csv']);
    }
}
