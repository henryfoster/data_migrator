<?php

namespace App\Tests\Service\Transformer;

use App\Service\Transformer\BoolTransformer;
use PHPUnit\Framework\TestCase;

class BoolTransformerTest extends TestCase
{
    public function testBoolTransformer(): void
    {
        $boolTransformer = new BoolTransformer();
        $oneActual = $boolTransformer->transform('', '1', '');
        $yesActual = $boolTransformer->transform('', 'Yes', '');
        $trueActual = $boolTransformer->transform('', 'True', '');
        $this->assertTrue($oneActual);
        $this->assertTrue($yesActual);
        $this->assertTrue($trueActual);

        $zeroActual = $boolTransformer->transform('', '0', '');
        $noActual = $boolTransformer->transform('', 'No', '');
        $falseActual = $boolTransformer->transform('', 'False', '');
        $this->assertFalse($zeroActual);
        $this->assertFalse($noActual);
        $this->assertFalse($falseActual);
    }

    public function testBoolTransformerSupports(): void
    {
        $boolTransformer = new BoolTransformer();
        $this->assertTrue($boolTransformer->supports('', '1', ''));
        $this->assertTrue($boolTransformer->supports('', 'Yes', ''));
        $this->assertTrue($boolTransformer->supports('', 'True', ''));
        $this->assertTrue($boolTransformer->supports('', '0', ''));
        $this->assertTrue($boolTransformer->supports('', 'No', ''));
        $this->assertTrue($boolTransformer->supports('', 'False', ''));

    }
}
