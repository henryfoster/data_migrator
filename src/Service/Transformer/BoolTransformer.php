<?php

namespace App\Service\Transformer;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

class BoolTransformer implements TransformerInterface
{
    public function transform(string $key, string $value, string $class): string|bool
    {
        return match(strtolower(trim($value))) {
            'yes','1','true' => true,
            'no','0','false' => false,
            default => $value
        };
    }

    public function supports(string $key, mixed $value, string $class): bool
    {
        return match(strtolower(trim($value))) {
            'yes','1','true','no','0','false' => true,
            default => false
        };
    }
}