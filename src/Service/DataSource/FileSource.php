<?php

namespace App\Service\DataSource;

use App\Service\DataProvider\FileProviderInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class FileSource implements SourceInterface
{
    public function __construct(
        private FileProviderInterface $fileProvider,
        private DecoderInterface $decoder,
        private string $format,
        private string $path
    ) {
    }

    public function getData(): iterable
    {
        $fileContent = $this->fileProvider->getFileContent($this->path);
        return $this->decoder->decode($fileContent, $this->format)['item'];
    }
}