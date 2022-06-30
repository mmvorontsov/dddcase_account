<?php

namespace App\Context\Account\Application\Message\Internal\NotifyCredentialRecoverySecretCode;

use App\Context\Account\Application\Common\ExecutionTimeTrackerUtil;
use App\Context\Account\Application\Message\InboxHistoryManagerInterface;
use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\{
    CredentialRecoverySecretCode,
    CredentialRecoverySecretCodeSenderInterface,
};
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandHandlerInterface;
use App\Context\Account\Infrastructure\Persistence\TransactionalSessionInterface;

/**
 * Class NotifyCredentialRecoverySecretCodeHandler
 * @package App\Context\Account\Application\Message\Internal\NotifyCredentialRecoverySecretCode
 */
final class NotifyCredentialRecoverySecretCodeHandler implements InternalCommandHandlerInterface
{
    /**
     * @var CredentialRecoverySecretCodeSenderInterface
     */
    private CredentialRecoverySecretCodeSenderInterface $credentialRecoverySecretCodeSender;

    /**
     * @var InboxHistoryManagerInterface
     */
    private InboxHistoryManagerInterface $inboxHistoryManager;

    /**
     * @var TransactionalSessionInterface
     */
    private TransactionalSessionInterface $transactionalSession;

    /**
     * NotifyCredentialRecoverySecretCodeHandler constructor.
     * @param CredentialRecoverySecretCodeSenderInterface $credentialRecoverySecretCodeSender
     * @param InboxHistoryManagerInterface $inboxHistoryManager
     * @param TransactionalSessionInterface $transactionalSession
     */
    public function __construct(
        CredentialRecoverySecretCodeSenderInterface $credentialRecoverySecretCodeSender,
        InboxHistoryManagerInterface $inboxHistoryManager,
        TransactionalSessionInterface $transactionalSession
    ) {
        $this->credentialRecoverySecretCodeSender = $credentialRecoverySecretCodeSender;
        $this->inboxHistoryManager = $inboxHistoryManager;
        $this->transactionalSession = $transactionalSession;
    }

    /**
     * @param NotifyCredentialRecoverySecretCodeV1 $message
     */
    public function __invoke(NotifyCredentialRecoverySecretCodeV1 $message): void
    {
        if ($this->inboxHistoryManager->isProcessed($message)) {
            return;
        }

        $process = function () use ($message) {
            $this->credentialRecoverySecretCodeSender->send(
                new CredentialRecoverySecretCode($message->getSecretCode()),
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
