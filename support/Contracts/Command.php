<?php

namespace Support\Contracts;

abstract class Command
{
    abstract public function getName(): string;

    abstract public function getDescription(): string;

    abstract public function handle(array $options): void;

    public function parseOptions(array $argv): array
    {
        $options = [];
        foreach ($argv as $arg) {
            if (preg_match('/--([\w-]+)(?:=(.*))?/', $arg, $matches)) {
                $options[$matches[1]] = $matches[2] ?? true;
            }
        }

        return $options;
    }

    public function run(array $argv): void
    {
        $options = $this->parseOptions($argv);
        $this->handle($options);
    }
}
