<?php

namespace App\Context\Account\Application\Message\Internal\CredentialRecoveryPasswordEntered;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryRepositoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventSubscriberInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class CredentialRecoveryPasswordEnteredSubscriber
 * @package App\Context\Account\Application\Message\Internal\CredentialRecoveryPasswordEntered
 */
final class CredentialRecoveryPasswordEnteredSubscriber implements InternalEventSubscriberInterface
{
    /**
     * @var CredentialRecoveryRepositoryInterface
     */
    private CredentialRecoveryRepositoryInterface $credentialRecoveryRepository;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * @var DomainEventObserverInterface
     */
    private DomainEventObserverInterface $domainEventObserver;

    /**
     * CredentialRecoveryPasswordEnteredSubscriber constructor.
     * @param CredentialRecoveryRepositoryInterface $credentialRecoveryRepository
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        CredentialRecoveryRepositoryInterface $credentialRecoveryRepository,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->credentialRecoveryRepository = $credentialRecoveryRepository;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CredentialRecoveryPasswordEnteredV1 $message
     */
    public function __invoke(CredentialRecoveryPasswordEnteredV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->removeCredentialRecovery($message);
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            }
        );
    }

    /**
     * @param CredentialRecoveryPasswordEnteredV1 $message
     */
    private function removeCredentialRecovery(CredentialRecoveryPasswordEnteredV1 $message): void
    {
        $credentialRecoveryId = CredentialRecoveryId::createFrom($message->getCredentialRecoveryId());
        $credentialRecovery = $this->credentialRecoveryRepository->findById($credentialRecoveryId);

        if (null !== $credentialRecovery) {
            $this->credentialRecoveryRepository->remove($credentialRecovery);
        }
    }
}
