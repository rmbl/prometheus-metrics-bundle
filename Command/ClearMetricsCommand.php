<?php

declare(strict_types=1);

namespace Artprima\PrometheusMetricsBundle\Command;

use Prometheus\Storage\Adapter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Clear metrics from prometheus storage.
 */
#[AsCommand('artprima:prometheus:metrics:clear', 'Clear all collected metrics from storage.')]
class ClearMetricsCommand extends Command
{
    /**
     * @var Adapter
     */
    private $storage;

    public function __construct(Adapter $storage)
    {
        parent::__construct(null);

        $this->storage = $storage;
    }

    protected function configure(): void
    {
        $this
            ->setName('artprima:prometheus:metrics:clear')
            ->setDescription('Clear all collected metrics from storage.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln(sprintf('Clearing storage from <comment>%s</comment>', get_class($this->storage)));

        $this->storage->wipeStorage();

        $io->success('The storage was successfully cleared.');

        return 0;
    }
}
