<?php

namespace App\Service\DataSink;

use Doctrine\ORM\EntityManagerInterface;

class DataSinkFactory
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function create(array $config): SinkInterface
    {
        if (!isset($config['type'])) {
            throw new \InvalidArgumentException('Missing type key under sink config');
        }
        // create File Sink with format, destination
        return match ($config['type']) {
            'doctrine' => new DoctrineSink($this->entityManager),
            default => throw new \InvalidArgumentException('Invalid data sink type')
        };
    }
}