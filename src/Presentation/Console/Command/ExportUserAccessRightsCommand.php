<?php

namespace App\Presentation\Console\Command;

use App\Context\Account\Application\UseCase\Maintenance\ExportUserAccessRights\{
    ExportUserAccessRightsUseCaseInterface,
};
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ExportUserAccessRightsCommand
 * @package App\Presentation\Console\Command
 */
class ExportUserAccessRightsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:export-user-access-rights';

    /**
     * @var ExportUserAccessRightsUseCaseInterface
     */
    private ExportUserAccessRightsUseCaseInterface $exportUserAccessRightsUseCase;

    /**
     * ExportUserAccessRightsCommand constructor.
     * @param ExportUserAccessRightsUseCaseInterface $exportUserAccessRightsUseCase
     */
    public function __construct(ExportUserAccessRightsUseCaseInterface $exportUserAccessRightsUseCase)
    {
        parent::__construct();
        $this->exportUserAccessRightsUseCase = $exportUserAccessRightsUseCase;
    }

    /**
     * @var void
     */
    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Export user access rights.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Export user access rights.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->exportUserAccessRightsUseCase->execute();
        $output->writeln('Outbox ID: ' . $response->getOutboxId());

        return 0;
    }
}
