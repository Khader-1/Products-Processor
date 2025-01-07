<?php

namespace App\CSV;

use App\Contracts\ProductSource;

class CSVProductSource implements ProductSource
{
    protected string $path;

    public function setFile(string $path): void
    {
        $this->path = $path;
    }

    /**
     * Read products from CSV file
     */
    public function next(): \Generator
    {
        $file = fopen($this->path, 'r');
        $header = fgetcsv($file);
        while ($row = fgetcsv($file)) {
            yield array_combine($header, $row);
        }
        fclose($file);
    }
}
