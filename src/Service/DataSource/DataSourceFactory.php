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
        return match ($config['type']) {
            'file' => $this->createFileSource($config),
            // sql,
            default => throw new \InvalidArgumentException('unsupported storage type')
        };
    }

    private function createFileSource(array $config): FileSource
    {
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