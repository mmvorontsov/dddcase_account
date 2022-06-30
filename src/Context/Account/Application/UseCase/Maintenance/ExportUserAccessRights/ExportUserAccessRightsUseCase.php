<?php

namespace App\Context\Account\Application\UseCase\Maintenance\ExportUserAccessRights;

use App\Context\Account\Application\Message\Interservice\Account\SyncUserAccessRights\{
    SyncUserAccessRightsV1,
};
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Application\Security\AccessControl\AccessRightsMapping;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Outbox\Outbox;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class ExportUserAccessRightsUseCase
 * @package App\Context\Account\Application\UseCase\Maintenance\ExportUserAccessRights
 */
final class ExportUserAccessRightsUseCase implements ExportUserAccessRightsUseCaseInterface
{
    /**
     * @var OutboxQueueManagerInterface
     */
    private OutboxQueueManagerInterface $outboxQueueManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * ExportUserAccessRightsUseCase constructor.
     * @param OutboxQueueManagerInterface $outboxQueueManager
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        OutboxQueueManagerInterface $outboxQueueManager,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->outboxQueueManager = $outboxQueueManager;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @return ExportUserAccessRightsResponse
     */
    public function execute(): ExportUserAccessRightsResponse
    {
        /** @var Outbox $outbox */
        $outbox = $this->transactionalSession->executeAtomically(
            function () {
                return $this->outboxQueueManager->add(
                    SyncUserAccessRightsV1::create(AccessRightsMapping::getUserAccessRights())
                );
            }
        );

        return new ExportUserAccessRightsResponse($outbox->getOutboxId()->getValue());
    }
}
