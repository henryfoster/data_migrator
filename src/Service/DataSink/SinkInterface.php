<?php

namespace App\Service\DataSink;

interface SinkInterface
{
    public function write(iterable $data): void;
}