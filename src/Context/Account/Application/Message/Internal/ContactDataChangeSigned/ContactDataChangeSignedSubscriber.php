<?php

namespace App\Context\Account\Application\Message\Internal\ContactDataChangeSigned;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventSubscriberInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class ContactDataChangeSignedSubscriber
 * @package App\Context\Account\Application\Message\Internal\ContactDataChangeSigned
 */
final class ContactDataChangeSignedSubscriber implements InternalEventSubscriberInterface
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
     * @var ContactDataChangeRepositoryInterface
     */
    private ContactDataChangeRepositoryInterface $contactDataChangeRepository;

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
     * ContactDataChangeSignedSubscriber constructor.
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     * @param KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory
     * @param ContactDataChangeRepositoryInterface $contactDataChangeRepository
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        KeyMakerRepositoryInterface $keyMakerRepository,
        KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory,
        ContactDataChangeRepositoryInterface $contactDataChangeRepository,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->keyMakerRepository = $keyMakerRepository;
        $this->keyMakerSelectionSpecFactory = $keyMakerSelectionSpecFactory;
        $this->contactDataChangeRepository = $contactDataChangeRepository;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param ContactDataChangeSignedV1 $message
     */
    public function __invoke(ContactDataChangeSignedV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->removeContactDataChangeKeyMaker($message);
            $this->removeContactDataChange($message);
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            }
        );
    }

    /**
     * @param ContactDataChangeSignedV1 $message
     */
    private function removeContactDataChangeKeyMaker(ContactDataChangeSignedV1 $message): void
    {
        $contactDataChangeId = ContactDataChangeId::createFrom($message->getContactDataChangeId());
        $keyMaker = $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToContactDataChangeSelectionSpec($contactDataChangeId)
        );

        if (null !== $keyMaker) {
            $this->keyMakerRepository->remove($keyMaker);
        }
    }

    /**
     * @param ContactDataChangeSignedV1 $message
     */
    private function removeContactDataChange(ContactDataChangeSignedV1 $message): void
    {
        $contactDataChangeId = ContactDataChangeId::createFrom($message->getContactDataChangeId());
        $contactDataChange = $this->contactDataChangeRepository->findById($contactDataChangeId);

        if (null !== $contactDataChange) {
            $this->contactDataChangeRepository->remove($contactDataChange);
        }
    }
}
