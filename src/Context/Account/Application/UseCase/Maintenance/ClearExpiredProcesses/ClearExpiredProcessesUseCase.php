<?php

namespace App\Context\Account\Application\UseCase\Maintenance\ClearExpiredProcesses;

use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Registration\Registration;
use App\Context\Account\Domain\Model\Registration\RegistrationRepositoryInterface;
use App\Context\Account\Domain\Model\Registration\RegistrationSelectionSpecFactoryInterface;
use App\Context\Account\Infrastructure\Logging\LoggerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;
use Throwable;

/**
 * Class ClearExpiredProcessesUseCase
 * @package App\Context\Account\Application\UseCase\Maintenance\ClearExpiredProcesses
 */
final class ClearExpiredProcessesUseCase implements ClearExpiredProcessesUseCaseInterface
{
    /**
     * @var RegistrationRepositoryInterface
     */
    private RegistrationRepositoryInterface $registrationRepository;

    /**
     * @var RegistrationSelectionSpecFactoryInterface
     */
    private RegistrationSelectionSpecFactoryInterface $registrationSelectionSpecFactory;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ClearExpiredProcessesUseCase constructor.
     * @param RegistrationRepositoryInterface $registrationRepository
     * @param RegistrationSelectionSpecFactoryInterface $registrationSelectionSpecFactory
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     * @param LoggerInterface $logger
     */
    public function __construct(
        RegistrationRepositoryInterface $registrationRepository,
        RegistrationSelectionSpecFactoryInterface $registrationSelectionSpecFactory,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
        LoggerInterface $logger
    ) {
        $this->registrationRepository = $registrationRepository;
        $this->registrationSelectionSpecFactory = $registrationSelectionSpecFactory;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;
        $this->logger = $logger;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param int $limit
     * @return ClearExpiredProcessesResponse
     */
    public function execute(int $limit): ClearExpiredProcessesResponse
    {
        $totalRemoved = 0;
        $totalRemoved += $this->removeRegistrations($limit);
        // TODO Remove contact data change
        // TODO Remove credential recovery

        return new ClearExpiredProcessesResponse($totalRemoved);
    }

    /**
     * @param int $limit
     * @return int
     */
    private function removeRegistrations(int $limit): int
    {
        $expiredRegistrations = $this->registrationRepository->selectSatisfying(
            $this->registrationSelectionSpecFactory->createIsExpiredSelectionSpec($limit)
        );

        if (empty($expiredRegistrations)) {
            return 0;
        }

        $removed = 0;
        /** @var Registration $registration */
        foreach ($expiredRegistrations as $registration) {
            try {
                $this->transactionalSession->executeAtomically(
                    function () use ($registration) {
                        $this->registrationRepository->remove($registration);
                    }
                );
                $removed++;
            } catch (Throwable $e) {
                $context = [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'registrationId' => $registration->getRegistrationId(),
                ];
                $this->logger->error($e->getMessage(), $context);
            }
        }

        return $removed;
    }
}
