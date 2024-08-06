<?php

namespace App\Tests\Service\DataSink;

use App\Entity\Item;
use App\Factory\ItemFactory;
use App\Service\DataSink\DoctrineSink;
use App\Tests\DatabasePrimer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineSinkTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        DatabasePrimer::prime(self::$kernel);
    }

    public function testSomething(): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $doctrineSink = new DoctrineSink($entityManager);
        $item = ItemFactory::new()->create([
            'price' => 999.98,
            'name' => 'test item'
        ])->_real();
        $doctrineSink->write([$item]);
        $found = $entityManager->getRepository(Item::class)->findOneBy(['name' => 'test item']);
        $this->assertEquals($item->getName(), $found->getName());
        $this->assertEquals($item->getPrice(), $found->getPrice());
    }
}
