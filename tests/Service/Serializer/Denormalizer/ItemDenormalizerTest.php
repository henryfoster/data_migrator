<?php

namespace App\Tests\Service\Serializer\Denormalizer;

use App\Entity\Item;
use App\Service\Serializer\Denormalizer\ItemDenormalizer;
use PHPUnit\Framework\TestCase;

class ItemDenormalizerTest extends TestCase
{
    private ItemDenormalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new ItemDenormalizer();
    }

    public function testDenormalize(): void
    {
        $data = [
            'entity_id' => '123',
            'CategoryName' => 'Coffee',
            'sku' => 'SKU123',
            'name' => 'Test Coffee',
            'shortdesc' => 'A short description',
            'price' => '9.99',
            'link' => 'https://example.com/coffee',
            'image' => 'https://example.com/coffee.jpg',
            'Brand' => 'Test Brand',
            'Rating' => '4',
            'CaffeineType' => 'Regular',
            'Count' => '10',
            'Flavored' => true,
            'Seasonal' => false,
            'Instock' => true,
            'Facebook' => true,
            'IsKCup' => false
        ];

        $context = ['idPrefix' => 'TEST'];

        $item = $this->normalizer->denormalize($data, Item::class, context:  $context);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('TEST-123', $item->getExternalId());
        $this->assertEquals('Coffee', $item->getCategoryName());
        $this->assertEquals('SKU123', $item->getSku());
        $this->assertEquals('Test Coffee', $item->getName());
        $this->assertEquals('A short description', $item->getShortDescription());
        $this->assertEquals(9.99, $item->getPrice());
        $this->assertEquals('https://example.com/coffee', $item->getLink());
        $this->assertEquals('https://example.com/coffee.jpg', $item->getImage());
        $this->assertEquals('Test Brand', $item->getBrand());
        $this->assertEquals(4, $item->getRating());
        $this->assertEquals('Regular', $item->getCaffeineType());
        $this->assertEquals(10, $item->getCount());
        $this->assertEquals(true, $item->isFlavored());
        $this->assertEquals(false, $item->isSeasonal());
        $this->assertEquals(true, $item->isInStock());
        $this->assertEquals(true, $item->isFacebook());
        $this->assertEquals(false, $item->getIsKCup());
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertTrue($this->normalizer->supportsDenormalization([], Item::class));
        $this->assertFalse($this->normalizer->supportsDenormalization([], \stdClass::class));
    }

    public function testGetSupportedTypes(): void
    {
        $supportedTypes = $this->normalizer->getSupportedTypes(null);
        $this->assertArrayHasKey(Item::class, $supportedTypes);
        $this->assertTrue($supportedTypes[Item::class]);
    }
}