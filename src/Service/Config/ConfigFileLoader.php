<?php

namespace App\Service\Config;

use App\Service\DataProvider\LocalFileProvider;
use InvalidArgumentException;

class ConfigFileLoader
{
    public function __construct(private readonly LocalFileProvider $localFileProvider)
    {
    }

    public function getConfig(string $path): array
    {
        try {
            $config = json_decode($this->localFileProvider->getFileContent($path), associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new InvalidArgumentException('Invalid JSON in config file '. $exception->getMessage());
        }
        $this->validateConfig($config);
        return $config;
    }

    private function validateConfig(mixed $config): void
    {
        if (!is_array($config)) {
            throw new InvalidArgumentException("Config must be an array/JSON-Object");
        }

        if (!isset($config['source']) || !is_array($config['source'])) {
            throw new InvalidArgumentException("Config must have a 'source' key with an array/JSON-Object value");
        }

        if (!isset($config['sink']) || !is_array($config['sink'])) {
            throw new InvalidArgumentException("Config must have a 'sink' key with an array/JSON-Object value");
        }
    }
}