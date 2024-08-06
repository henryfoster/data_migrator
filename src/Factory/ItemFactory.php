<?php

namespace App\Factory;

use App\Entity\Item;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Item>
 */
final class ItemFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Item::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'categoryName' => self::faker()->text(255),
            'externalId' => self::faker()->text(255),
            'facebook' => self::faker()->boolean(),
            'image' => self::faker()->text(255),
            'inStock' => self::faker()->boolean(),
            'isKCup' => self::faker()->boolean(),
            'link' => self::faker()->text(255),
            'name' => self::faker()->text(255),
            'rating' => self::faker()->randomNumber(),
            'sku' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Item $item): void {})
        ;
    }
}
