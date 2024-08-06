<?php

namespace App\Tests\Service\Transformer;

use App\Entity\Item;
use App\Service\Transformer\BoolTransformer;
use App\Service\Transformer\DataTransformer;
use PHPUnit\Framework\TestCase;

class DataTransformerTest extends TestCase
{
    private DataTransformer $dataTransformer;
    private BoolTransformer $boolTransformer;
    protected function setUp(): void
    {
        $this->boolTransformer = $this->createMock(BoolTransformer::class);
        $this->dataTransformer = new DataTransformer([$this->boolTransformer]);
    }

    public function testDataTransformer(): void
    {
        $data = [
            'active' => 'True',
            'test' => 'value'
        ];
        $this->boolTransformer
            ->method('supports')
            ->willReturnCallback(function($key, $value, $class) {
                return $key === 'active' && $value === 'True' && $class === Item::class;
            });

        $this->boolTransformer
            ->expects($this->once())
            ->method('transform')
            ->with('active', 'True', Item::class)
            ->willReturn(true);

        $transformedDate = $this->dataTransformer->transform($data, Item::class);
        $this->assertSame([
            'active' => true,
            'test' => 'value'
        ], $transformedDate);
    }
}
