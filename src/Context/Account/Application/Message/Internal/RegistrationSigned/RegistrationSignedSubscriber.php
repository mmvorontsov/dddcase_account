<?php

namespace App\Context\Account\Application\Message\Internal\RegistrationSigned;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerRepositoryInterface;
use App\Context\Account\Domain\Model\KeyMaker\KeyMakerSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\Registration\RegistrationId;
use App\Context\Account\Domain\Model\Registration\RegistrationRepositoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventSubscriberInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class RegistrationSignedSubscriber
 * @package App\Context\Account\Application\Message\Internal\RegistrationSigned
 */
final class RegistrationSignedSubscriber implements InternalEventSubscriberInterface
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
     * @var RegistrationRepositoryInterface
     */
    private RegistrationRepositoryInterface $registrationRepository;

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
     * RegistrationSignedSubscriber constructor.
     * @param KeyMakerRepositoryInterface $keyMakerRepository
     * @param KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory
     * @param RegistrationRepositoryInterface $registrationRepository
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        KeyMakerRepositoryInterface $keyMakerRepository,
        KeyMakerSelectionSpecFactoryInterface $keyMakerSelectionSpecFactory,
        RegistrationRepositoryInterface $registrationRepository,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver,
    ) {
        $this->keyMakerRepository = $keyMakerRepository;
        $this->keyMakerSelectionSpecFactory = $keyMakerSelectionSpecFactory;
        $this->registrationRepository = $registrationRepository;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param RegistrationSignedV1 $message
     */
    public function __invoke(RegistrationSignedV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->removeRegistrationKeyMaker($message);
            $this->removeRegistration($message);
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            },
        );
    }

    /**
     * @param RegistrationSignedV1 $message
     */
    private function removeRegistrationKeyMaker(RegistrationSignedV1 $message): void
    {
        $registrationId = RegistrationId::createFrom($message->getRegistrationId());
        $keyMaker = $this->keyMakerRepository->selectOneSatisfying(
            $this->keyMakerSelectionSpecFactory->createBelongsToRegistrationSelectionSpec($registrationId),
        );

        if (null !== $keyMaker) {
            $this->keyMakerRepository->remove($keyMaker);
        }
    }

    /**
     * @param RegistrationSignedV1 $message
     */
    private function removeRegistration(RegistrationSignedV1 $message): void
    {
        $registrationId = RegistrationId::createFrom($message->getRegistrationId());
        $registration = $this->registrationRepository->findById($registrationId);

        if (null !== $registration) {
            $this->registrationRepository->remove($registration);
        }
    }
}
