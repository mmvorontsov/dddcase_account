<?php

namespace App\Context\Account\Application\Message\Internal\NotifyContactDataChangeSecretCode;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\{
    ContactDataChangeSecretCodeSenderInterface,
};
use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\ContactDataChangeSecretCode;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class NotifyContactDataChangeSecretCodeHandler
 * @package App\Context\Account\Application\Message\Internal\NotifyContactDataChangeSecretCode
 */
final class NotifyContactDataChangeSecretCodeHandler implements InternalCommandHandlerInterface
{
    /**
     * @var ContactDataChangeSecretCodeSenderInterface
     */
    private ContactDataChangeSecretCodeSenderInterface $contactDataChangeSecretCodeSender;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * NotifyContactDataChangeSecretCodeHandler constructor.
     * @param ContactDataChangeSecretCodeSenderInterface $contactDataChangeSecretCodeSender
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     */
    public function __construct(
        ContactDataChangeSecretCodeSenderInterface $contactDataChangeSecretCodeSender,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession
    ) {
        $this->contactDataChangeSecretCodeSender = $contactDataChangeSecretCodeSender;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param NotifyContactDataChangeSecretCodeV1 $message
     */
    public function __invoke(NotifyContactDataChangeSecretCodeV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->contactDataChangeSecretCodeSender->send(
                new ContactDataChangeSecretCode($message->getSecretCode()),
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
