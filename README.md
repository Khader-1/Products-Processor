# Product Processor [![PHPUnit Tests 🧪](https://github.com/Khader-1/Products-Processor/actions/workflows/ci.yaml/badge.svg)](https://github.com/Khader-1/Products-Processor/actions/workflows/ci.yaml)

A flexible and extensible product list processor that parses supplier product data, generates unique combinations, and outputs the results in a CSV format.


## Usage
### Running the parser

```shell
php parser.php --file=products_comma_separated.csv --unique-combinations=combination_count.csv
```

### Pre-requisites

- PHP 7.4 or higher
- Composer (for testing and autoloading)

### Installation

1. Clone the repository

```shell
git clone https://github.com/Khader-1/Products-Processor.git
cd Products-Processor
```

2. Install dependencies

```shell
composer install
```

## Configuration

The parser is configured using `config/parser.php`. Below is an example configuration:
- **Source**: The class responsible for reading the input file.
- **Sink**: The class responsible for writing the output file.
- **Properties**: Attributes expected in the input file.


```php
return [
    'source' => App\CSV\CSVProductSource::class,
    'sink' => App\CSV\CSVCombinationsConsumer::class,
    'properties' => [
        'brand_name' => ['type' => 'string', 'required' => true],
        'model_name' => ['type' => 'string', 'required' => true],
        'condition_name' => ['type' => 'string'],
        'grade_name' => ['type' => 'string'],
    ],
];
```

