<?php

namespace App\Service\Transformer;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class DataTransformer
{

    public function __construct
    (
        #[AutowireIterator(tag: 'app.data_transformer')]
        private readonly iterable $transformers
    ) {
    }

    public function transform(array $data, string $class): array
    {
        foreach ($data as $key => $value) {
            /** @var TransformerInterface $transformer */
            foreach ($this->transformers as $transformer) {
                if ($transformer->supports($key, $value, $class)) {
                    $data[$key] = $transformer->transform($key, $value, $class);
                }
            }
        }
        return $data;
    }
}