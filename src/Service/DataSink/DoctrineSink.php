<?php

namespace App\Service\DataSink;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineSink implements SinkInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function write(iterable $data): void
    {
        foreach ($data as $item) {
            $this->entityManager->persist($item);

        }
        $this->entityManager->flush();
    }
}