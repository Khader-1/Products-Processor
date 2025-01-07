<?php

namespace Tests\Unit\Support\Contracts;

use PHPUnit\Framework\TestCase;
use Support\Contracts\Command;

class CommandTest extends TestCase
{
    public function test_parse_options()
    {
        $command = new class extends Command
        {
            public function getName(): string
            {
                return 'test-command';
            }

            public function getDescription(): string
            {
                return 'A test command.';
            }

            public function handle(array $options): void
            {
                // No-op
            }
        };

        $argv = [
            '--file=/path/to/file.csv',
            '--unique-combinations=/path/to/output.csv',
        ];

        $expected = [
            'file' => '/path/to/file.csv',
            'unique-combinations' => '/path/to/output.csv',
        ];

        $this->assertEquals($expected, $command->parseOptions($argv));
    }
}
