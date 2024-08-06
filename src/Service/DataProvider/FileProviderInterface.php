<?php

namespace App\Service\DataProvider;

interface FileProviderInterface
{
    public function getFileContent(string $path): string;
}