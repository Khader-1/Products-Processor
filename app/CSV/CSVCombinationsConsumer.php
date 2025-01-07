<?php

namespace App\CSV;

use App\Contracts\CombinationsConsumer;
use App\Models\Product;

class CSVCombinationsConsumer implements CombinationsConsumer
{
    protected string $path;

    protected bool $headerWritten = false;

    public function setFile(string $path): void
    {
        $this->path = $path;
        // remove file if it exists
        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }

    /**
     * Write product combinations to CSV file
     *
     * If the file does not exist, it will be created and the header will be written,
     * otherwise the combinations will be appended to the file
     */
    public function write(Product $product, int $count): void
    {
        $file = fopen($this->path, 'a');
        if (! $this->headerWritten) {
            fputcsv($file, array_merge(array_keys($product->toArray()), ['count']));
            $this->headerWritten = true;
        }
        fputcsv($file, array_merge($product->toArray(), [$count]));
        fclose($file);

    }
}
