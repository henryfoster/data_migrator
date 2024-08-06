<?php

namespace App\Service\DataProvider;

class LocalFileProvider implements FileProviderInterface
{
    public function getFileContent(string $path): string
    {
        if (!file_exists($path)) {
            throw new \RuntimeException('File does not exist at: '. $path);
        }
        $content = file_get_contents($path);
        if (false === $content) {
            throw new \RuntimeException('Failed to read File at: '.$path);
        }
        return $content;
    }
}