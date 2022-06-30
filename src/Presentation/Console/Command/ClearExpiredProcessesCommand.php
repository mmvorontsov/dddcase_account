<?php

namespace App\Presentation\Console\Command;

use App\Context\Account\Application\UseCase\Maintenance\ClearExpiredProcesses\{
    ClearExpiredProcessesUseCaseInterface,
};
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClearExpiredProcessesCommand
 * @package App\Presentation\Console\Command
 */
class ClearExpiredProcessesCommand extends Command
{
    private const DEFAULT_LIMIT = 50;

    /**
     * @var string
     */
    protected static $defaultName = 'app:clear-expired-processes';

    /**
     * @var ClearExpiredProcessesUseCaseInterface
     */
    private ClearExpiredProcessesUseCaseInterface $clearExpiredProcessesUseCase;

    /**
     * ClearExpiredProcessesCommand constructor.
     * @param ClearExpiredProcessesUseCaseInterface $clearExpiredProcessesUseCase
     */
    public function __construct(ClearExpiredProcessesUseCaseInterface $clearExpiredProcessesUseCase)
    {
        parent::__construct();
        $this->clearExpiredProcessesUseCase = $clearExpiredProcessesUseCase;
    }

    /**
     * @var void
     */
    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Clear expired processes.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Clear expired processes.')
            ->addArgument(
                'limit',
                InputArgument::OPTIONAL,
                'To remove portion limit.',
                self::DEFAULT_LIMIT
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = (int)$input->getArgument('limit');
        $response = $this->clearExpiredProcessesUseCase->execute($limit);

        $output->writeln('Total removed: ' . $response->getTotalRemoved());

        return 0;
    }
}
