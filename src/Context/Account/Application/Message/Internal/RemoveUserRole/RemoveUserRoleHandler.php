<?php

namespace App\Context\Account\Application\Message\Internal\RemoveUserRole;

use Exception;
use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Domain\Event\DomainEventSubject;
use App\Context\Account\Domain\Model\Role\RoleId;
use App\Context\Account\Domain\Model\User\UserId;
use App\Context\Account\Domain\Model\User\UserRepositoryInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class RemoveUserRoleHandler
 * @package App\Context\Account\Application\Message\Internal\RemoveUserRole
 */
final class RemoveUserRoleHandler implements InternalCommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

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
     * RemoveUserRoleHandlerSubscriber constructor.
     * @param UserRepositoryInterface $userRepository
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession,
        DomainEventObserverInterface $domainEventObserver
    ) {
        $this->userRepository = $userRepository;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
        $this->domainEventObserver = $domainEventObserver;

        DomainEventSubject::instance()->registerObserver($this->domainEventObserver);
    }

    /**
     * @param RemoveUserRoleV1 $message
     */
    public function __invoke(RemoveUserRoleV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->removeUserRole($message);
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            }
        );
    }

    /**
     * @param RemoveUserRoleV1 $message
     * @throws Exception
     */
    private function removeUserRole(RemoveUserRoleV1 $message): void
    {
        $userId = UserId::createFrom($message->getUserId());
        $roleId = RoleId::createFrom($message->getRoleId());

        $user = $this->userRepository->findById($userId);
        if (null === $user) {
            return;
        }

        $user->removeUserRole($roleId);
    }
}
