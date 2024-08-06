<?php

namespace App\Service\Transformer;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.data_transformer')]
interface TransformerInterface
{
    public function transform(string $key, string $value, string $class): mixed;
    public function supports(string $key, mixed $value, string $class): bool;
}