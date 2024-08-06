<?php

namespace App\Command;

use App\Service\DataMigrationPipeline;
use App\Service\DataProvider\LocalFileProvider;
use App\Service\Config\ConfigFileLoader;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:migrate:data',
    description: 'Add a short description for your command',
)]
class MigrateDataCommand extends Command
{
    public function __construct(
        private DataMigrationPipeline $dataMigrationPipeline,
        private ConfigFileLoader $configFileLoader
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            name: 'configFile',
            mode: InputArgument::REQUIRED,
            description: 'filepath to json config',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $configFile = $input->getArgument('configFile');

        $config = $this->configFileLoader->getConfig($configFile);

        $this->dataMigrationPipeline->migrate($config);
        $io->success('hurra');

        return Command::SUCCESS;
    }
}
