<?php

namespace App\Context\Account\Application\Message\Internal\NotifySuccessfulEmailChange;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Notification\SuccessfulEmailChange\SuccessfulEmailChange;
use App\Context\Account\Application\Notification\SuccessfulEmailChange\SuccessfulEmailChangeSenderInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class NotifySuccessfulEmailChangeHandler
 * @package App\Context\Account\Application\Message\Internal\NotifySuccessfulEmailChange
 */
final class NotifySuccessfulEmailChangeHandler implements InternalCommandHandlerInterface
{
    /**
     * @var SuccessfulEmailChangeSenderInterface
     */
    private SuccessfulEmailChangeSenderInterface $successfulEmailChangeSender;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * NotifySuccessfulEmailChangeHandler constructor.
     * @param SuccessfulEmailChangeSenderInterface $successfulEmailChangeSender
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     */
    public function __construct(
        SuccessfulEmailChangeSenderInterface $successfulEmailChangeSender,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession
    ) {
        $this->successfulEmailChangeSender = $successfulEmailChangeSender;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param NotifySuccessfulEmailChangeV1 $message
     */
    public function __invoke(NotifySuccessfulEmailChangeV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->successfulEmailChangeSender->send(
                new SuccessfulEmailChange($message->getFromEmail(), $message->getToEmail()),
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
