<?php

namespace App\Context\Account\Application\Message\Internal\NotifySuccessfulPasswordChange;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Notification\SuccessfulPasswordChange\{
    SuccessfulPasswordChange,
    SuccessfulPasswordChangeSenderInterface,
};
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class NotifySuccessfulPasswordChangeHandler
 * @package App\Context\Account\Application\Message\Internal\NotifySuccessfulPasswordChange
 */
final class NotifySuccessfulPasswordChangeHandler implements InternalCommandHandlerInterface
{
    /**
     * @var SuccessfulPasswordChangeSenderInterface
     */
    private SuccessfulPasswordChangeSenderInterface $successfulPasswordChangeSender;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * NotifySuccessfulPasswordChangeHandler constructor.
     * @param SuccessfulPasswordChangeSenderInterface $successfulPasswordChangeSender
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     */
    public function __construct(
        SuccessfulPasswordChangeSenderInterface $successfulPasswordChangeSender,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession
    ) {
        $this->successfulPasswordChangeSender = $successfulPasswordChangeSender;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param NotifySuccessfulPasswordChangeV1 $message
     */
    public function __invoke(NotifySuccessfulPasswordChangeV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->successfulPasswordChangeSender->send(
                new SuccessfulPasswordChange(),
                $message->getRecipient()
            );
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            }
        );
    }
}
