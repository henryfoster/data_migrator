<?php

namespace App\Service\Serializer\Denormalizer;



use App\Entity\Item;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ItemDenormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $idPrefix = $context['idPrefix'] ?? '';
        $item = new Item();
        $item->setExternalId($idPrefix.'-'.$data['entity_id'] ?? null);
        $item->setCategoryName($data['CategoryName'] ?? null);
        $item->setSku($data['sku'] ?? null);
        $item->setName($data['name'] ?? null);
        $item->setShortDescription($data['shortdesc'] ?? null);
        $item->setPrice(empty($data['price']) ? null : $data['price']);
        $item->setLink($data['link'] ?? null);
        $item->setImage($data['image'] ?? null);
        $item->setBrand($data['Brand'] ?? null);
        $item->setRating((int) $data['Rating'] ?? null);
        $item->setCaffeineType($data['CaffeineType'] ?? null);
        $item->setCount((int) $data['Count'] ?? null);
        $item->setFlavored($data['Flavored'] ?? null);
        $item->setSeasonal($data['Seasonal'] ?? null);
        $item->setInStock($data['Instock'] ?? null);
        $item->setFacebook($data['Facebook'] ?? null);
        $item->setIsKCup($data['IsKCup'] ?? null);
        return $item;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Item::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Item::class => true];
    }
}