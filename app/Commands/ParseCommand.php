<?php

namespace App\Commands;

use App\Repositories\ProductRepository;
use Support\Contracts\Command;

class ParseCommand extends Command
{
    public function __construct(protected ProductRepository $productRepository) {}

    public function getName(): string
    {
        return 'parse';
    }

    public function getDescription(): string
    {
        return 'Processes a supplier product list.';
    }

    public function handle(array $options): void
    {
        $file = $options['file'] ?? null;
        $output = $options['unique-combinations'] ?? './unique-combinations.csv';

        if (! $file) {
            throw new \RuntimeException('Error: The --file option is required.');
        }

        if (! file_exists($file)) {
            throw new \RuntimeException("Error: File not found: $file");
        }

        $this->processFile($file, $output);

        echo "Processing complete. Unique combinations saved to: $output\n";
    }

    protected function processFile(string $filePath, string $outputPath): void
    {
        $this->productRepository->setSourceFile($filePath);
        $this->productRepository->setConsumerFile($outputPath);
        $this->productRepository->generateCombinations();
    }
}
