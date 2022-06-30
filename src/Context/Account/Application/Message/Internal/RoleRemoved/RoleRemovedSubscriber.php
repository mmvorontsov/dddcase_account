<?php

namespace App\Context\Account\Application\Message\Internal\RoleRemoved;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Message\Internal\RemoveUserRole\RemoveUserRoleV1;
use App\Context\Account\Application\Message\OutboxQueueManagerInterface;
use App\Context\Account\Domain\Common\Type\Uuid;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\UserRepositoryInterface;
use App\Context\Account\Domain\Model\User\UserSelectionSpecFactoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventSubscriberInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class RoleRemovedSubscriber
 * @package App\Context\Account\Application\Message\Internal\RoleRemoved
 */
final class RoleRemovedSubscriber implements InternalEventSubscriberInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var UserSelectionSpecFactoryInterface
     */
    private UserSelectionSpecFactoryInterface $userSelectionSpecFactory;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

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
     * RoleRemovedSubscriber constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserSelectionSpecFactoryInterface $userSelectionSpecFactory
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param OutboxQueueManagerInterface $outboxQueueManager
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserSelectionSpecFactoryInterface $userSelectionSpecFactory,
        InboxHistoryManagerInterface $inboxHistoryManager,
        OutboxQueueManagerInterface $outboxQueueManager,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->userRepository = $userRepository;
        $this->userSelectionSpecFactory = $userSelectionSpecFactory;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->outboxQueueManager = $outboxQueueManager;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param RoleRemovedV1 $message
     */
    public function __invoke(RoleRemovedV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->createInternalRemoveUserRole($message);
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            }
        );
    }

    /**
     * @param RoleRemovedV1 $message
     * @throws Exception
     */
    private function createInternalRemoveUserRole(RoleRemovedV1 $message): void
    {
        $roleId = RoleId::createFrom($message->getRoleId());
        $roleIds = [$roleId];

        $users = $this->userRepository->selectSatisfying(
            $this->userSelectionSpecFactory->createHasOneOfRolesSelectionSpec($roleIds)
        );

        foreach ($users as $user) {
            $this->outboxQueueManager->add(
                new RemoveUserRoleV1(
                    Uuid::create(),
                    $user->getUserId()->getValue(),
                    $roleId->getValue(),
                    new DateTimeImmutable()
                )
            );
        }
    }
}
