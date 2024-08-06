<?php

namespace App\Tests\Service\Config;

use App\Service\DataProvider\LocalFileProvider;
use App\Service\Config\ConfigFileLoader;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigFileLoaderTest extends TestCase
{
    private LocalFileProvider $localFileProvider;
    private ConfigFileLoader $configFileLoader;

    protected function setUp(): void
    {
        $this->localFileProvider = $this->createMock(LocalFileProvider::class);
        $this->configFileLoader = new ConfigFileLoader($this->localFileProvider);
    }

    public function testGetConfigWithValidJson(): void
    {
        $validJson = json_encode([
            'source' => ['key' => 'value'],
            'sink' => ['key' => 'value']
        ]);

        $this->localFileProvider
            ->expects($this->once())
            ->method('getFileContent')
            ->willReturn($validJson);

        $result = $this->configFileLoader->getConfig('valid/path.json');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('source', $result);
        $this->assertArrayHasKey('sink', $result);
    }

    public function testGetConfigWithInvalidJson(): void
    {
        $this->localFileProvider
            ->expects($this->once())
            ->method('getFileContent')
            ->willReturn('invalid json');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid JSON in config file');

        $this->configFileLoader->getConfig('invalid/path.json');
    }

    public function testGetConfigWithMissingSourceKey(): void
    {
        $invalidJson = json_encode(['sink' => []]);

        $this->localFileProvider
            ->expects($this->once())
            ->method('getFileContent')
            ->willReturn($invalidJson);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Config must have a 'source' key with an array/JSON-Object value");

        $this->configFileLoader->getConfig('missing/source.json');
    }

    public function testGetConfigWithMissingSinkKey(): void
    {
        $invalidJson = json_encode(['source' => []]);

        $this->localFileProvider
            ->expects($this->once())
            ->method('getFileContent')
            ->willReturn($invalidJson);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Config must have a 'sink' key with an array/JSON-Object value");

        $this->configFileLoader->getConfig('missing/sink.json');
    }
}