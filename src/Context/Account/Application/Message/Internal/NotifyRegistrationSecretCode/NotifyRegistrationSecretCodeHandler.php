<?php

namespace App\Context\Account\Application\Message\Internal\NotifyRegistrationSecretCode;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Notification\RegistrationSecretCode\{
    RegistrationSecretCodeSenderInterface,
};
use App\Context\Account\Application\Notification\RegistrationSecretCode\RegistrationSecretCode;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class NotifyRegistrationSecretCodeHandler
 * @package App\Context\Account\Application\Message\Internal\NotifyRegistrationSecretCode
 */
final class NotifyRegistrationSecretCodeHandler implements InternalCommandHandlerInterface
{
    /**
     * @var RegistrationSecretCodeSenderInterface
     */
    private RegistrationSecretCodeSenderInterface $registrationSecretCodeSender;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * NotifyRegistrationSecretCodeHandler constructor.
     * @param RegistrationSecretCodeSenderInterface $registrationSecretCodeSender
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     */
    public function __construct(
        RegistrationSecretCodeSenderInterface $registrationSecretCodeSender,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession,
    ) {
        $this->registrationSecretCodeSender = $registrationSecretCodeSender;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param NotifyRegistrationSecretCodeV1 $message
     */
    public function __invoke(NotifyRegistrationSecretCodeV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->registrationSecretCodeSender->send(
                new RegistrationSecretCode($message->getSecretCode()),
                $message->getRecipient(),
            );
        };

        $this->transactionalSession->executeAtomically(
            function () use ($message, $process) {
                $executionTime = ExecutionTimeTrackerUtil::callAndTrack($process);
                $this->inboxHistoryManager->add($message, $executionTime);
            },
        );
        // TODO Try, catch, logging
    }
}
