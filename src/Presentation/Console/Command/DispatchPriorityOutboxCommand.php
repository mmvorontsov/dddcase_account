<?php

namespace App\Presentation\Console\Command;

use App\Context\Account\Application\UseCase\Maintenance\DispatchPriorityOutbox\{
    DispatchPriorityOutboxUseCaseInterface,
};
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DispatchPriorityOutboxCommand
 * @package App\Presentation\Console\Command
 */
class DispatchPriorityOutboxCommand extends Command
{
    private const DEFAULT_LIMIT = 50;

    /**
     * @var string
     */
    protected static $defaultName = 'app:dispatch-priority-outbox';

    /**
     * @var DispatchPriorityOutboxUseCaseInterface
     */
    private DispatchPriorityOutboxUseCaseInterface $dispatchPriorityOutboxUseCase;

    /**
     * DispatchPriorityOutboxCommand constructor.
     * @param DispatchPriorityOutboxUseCaseInterface $dispatchPriorityOutboxUseCase
     */
    public function __construct(DispatchPriorityOutboxUseCaseInterface $dispatchPriorityOutboxUseCase)
    {
        parent::__construct();
        $this->dispatchPriorityOutboxUseCase = $dispatchPriorityOutboxUseCase;
    }

    /**
     * @var void
     */
    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Dispatch priority outbox.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Dispatch priority outbox to internal or interservice queues.')
            ->addArgument(
                'limit',
                InputArgument::OPTIONAL,
                'To publication portion size.',
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
        $response = $this->dispatchPriorityOutboxUseCase->execute($limit);

        $output->writeln('Total dispatched: ' . $response->getTotalDispatched());

        return 0;
    }
}
