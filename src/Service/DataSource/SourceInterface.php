<?php

namespace App\Service\DataSource;

interface SourceInterface
{
    public function getData(): iterable;
}