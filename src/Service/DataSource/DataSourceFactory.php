<?php

namespace App\Service\DataSource;

use App\Service\DataProvider\LocalFileProvider;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class DataSourceFactory
{
    public function __construct()
    {
    }

    public function create(array $config)
    {
        if (!isset($config['type'])) {
            throw new \InvalidArgumentException('Missing type key under source config');
        }
        return match ($config['type']) {
            'file' => $this->createFileSource($config),
            // sql,
            default => throw new \InvalidArgumentException('unsupported storage type')
        };
    }

    private function createFileSource(array $config): FileSource
    {
        if (!isset($config['storage'])) {
            throw new \InvalidArgumentException('Missing storage key under source config');
        }
        if (!isset($config['format'])) {
            throw new \InvalidArgumentException('Missing format key under source config');
        }
        if (!isset($config['path'])) {
            throw new \InvalidArgumentException('Missing path key under source config');
        }

        $fileProvider = match ($config['storage']) {
            'local' => new LocalFileProvider(),
            default => throw new \InvalidArgumentException('unsupported storage')
        };

        $decoder = match($config['format']) {
            'xml' => new XmlEncoder(),
            'json' => new JsonEncoder(),
            default => throw new \InvalidArgumentException('unsupported format')
        };
        return new FileSource($fileProvider, $decoder, $config['format'], $config['path']);
    }
}