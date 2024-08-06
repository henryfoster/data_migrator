<?php

namespace App\Tests\Command;

use App\Tests\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class MigrateDataCommandTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        DatabasePrimer::prime(self::$kernel);
    }

    public function testExecute(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = $application->find('app:migrate:data');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'configFile' => self::$kernel->getProjectDir().'/exampleConfig.json'
        ]);

        $commandTester->assertCommandIsSuccessful();


        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Data migrated successfully!', $output);
    }
}
