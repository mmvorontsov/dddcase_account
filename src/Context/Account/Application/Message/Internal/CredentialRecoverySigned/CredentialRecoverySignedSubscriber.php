<?php

namespace App\Context\Account\Application\Message\Internal\CredentialRecoverySigned;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecoveryId;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventSubscriberInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class CredentialRecoverySignedSubscriber
 * @package App\Context\Account\Application\Message\Internal\CredentialRecoverySigned
 */
final class CredentialRecoverySignedSubscriber implements InternalEventSubscriberInterface
{
    /**
     * @var KeyMakerRepositoryInterface
     */
    private KeyMakerRepositoryInterface $keyMakerRepository;

    /**
     * @var KeyMakerSelectionSpecFactoryInterface
     */
    private KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory;

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
     * CredentialRecoverySignedSubscriber constructor.
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     * @param KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        KeyMakerRepositoryInterface $keyMakerRepository,
        KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->keyMakerRepository = $keyMakerRepository;
        $this->keyMakerSelectionSpecFactory = $keyMakerSelectionSpecFactory;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param CredentialRecoverySignedV1 $message
     */
    public function __invoke(CredentialRecoverySignedV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->removeCredentialRecoveryKeyMaker($message);
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            }
        );
    }

    /**
     * @param CredentialRecoverySignedV1 $message
     */
    private function removeCredentialRecoveryKeyMaker(CredentialRecoverySignedV1 $message): void
    {
        $credentialRecoveryId = CredentialRecoveryId::createFrom($message->getCredentialRecoveryId());
        $keyMaker = $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToCredentialRecoverySelectionSpec($credentialRecoveryId)
        );

        if (null !== $keyMaker) {
            $this->keyMakerRepository->remove($keyMaker);
        }
    }
}
