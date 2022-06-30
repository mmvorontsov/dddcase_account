<?php

namespace App\Context\Account\Application\Message\Internal\NotifySuccessfulPhoneChange;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Notification\SuccessfulPhoneChange\SuccessfulPhoneChange;
use App\Context\Account\Application\Notification\SuccessfulPhoneChange\SuccessfulPhoneChangeSenderInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class NotifySuccessfulPhoneChangeHandler
 * @package App\Context\Account\Application\Message\Internal\NotifySuccessfulPhoneChange
 */
final class NotifySuccessfulPhoneChangeHandler implements InternalCommandHandlerInterface
{
    /**
     * @var SuccessfulPhoneChangeSenderInterface
     */
    private SuccessfulPhoneChangeSenderInterface $successfulPhoneChangeSender;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * NotifySuccessfulPhoneChangeHandler constructor.
     * @param SuccessfulPhoneChangeSenderInterface $successfulPhoneChangeSender
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     */
    public function __construct(
        SuccessfulPhoneChangeSenderInterface $successfulPhoneChangeSender,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession
    ) {
        $this->successfulPhoneChangeSender = $successfulPhoneChangeSender;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param NotifySuccessfulPhoneChangeV1 $message
     */
    public function __invoke(NotifySuccessfulPhoneChangeV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->successfulPhoneChangeSender->send(
                new SuccessfulPhoneChange($message->getFromPhone(), $message->getToPhone()),
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
