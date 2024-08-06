<?php

namespace App\Tests\Service\DataProvider;

use App\Service\DataProvider\LocalFileProvider;
use PHPUnit\Framework\TestCase;

class LocalFileProviderTest extends TestCase
{
    private LocalFileProvider $localFileProvider;
    private string $tempDir;
    protected function setUp(): void
    {
        $this->localFileProvider = new LocalFileProvider();
        $this->tempDir = sys_get_temp_dir().'/local_file_provider_test_'.uniqid();
        mkdir($this->tempDir);
    }

    protected function tearDown(): void
    {
        if (!is_dir($this->tempDir)) {
            return;
        }
        exec("rm -rf " . escapeshellarg($this->tempDir));
    }

    private function createTempFile(string $content)
    {
        $tmpFile = $this->tempDir.'/test_file_'.uniqid().'.txt';
        file_put_contents($tmpFile, $content);
        return $tmpFile;
    }

    public function testGetFileContent(): void
    {
        $content = 'This is some test content.';
        $tmpFile = $this->createTempFile($content);
        $contentFromFile = $this->localFileProvider->getFileContent($tmpFile);
        self::assertEquals($content, $contentFromFile);
    }

    public function testGetFileContentWithNonExistentFile(): void
    {
        $nonExistentFile = $this->tempDir . '/non_existent_file.txt';
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('File does not exist at: '.$nonExistentFile);
        $this->localFileProvider->getFileContent($nonExistentFile);
    }

    public function testGetEmptyFile(): void
    {
        $tempFile = $this->createTempFile('');
        $actualContent = $this->localFileProvider->getFileContent($tempFile);
        $this->assertEquals('', $actualContent);
    }
}
