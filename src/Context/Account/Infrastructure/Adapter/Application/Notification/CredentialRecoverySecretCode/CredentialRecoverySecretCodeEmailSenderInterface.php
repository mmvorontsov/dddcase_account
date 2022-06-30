<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode;

use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\CredentialRecoverySecretCode;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    EmailNotificationRecipient as EmailRecipient,
};

/**
 * Interface CredentialRecoverySecretCodeEmailSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode
 */
interface CredentialRecoverySecretCodeEmailSenderInterface
{
    /**
     * @param CredentialRecoverySecretCode $notification
     * @param EmailRecipient $recipient
     */
    public function send(CredentialRecoverySecretCode $notification, EmailRecipient $recipient): void;

    /**
     * @param CredentialRecoverySecretCode $notification
     * @param EmailRecipient $recipient
     * @return string
     */
    public function renderPreview(CredentialRecoverySecretCode $notification, EmailRecipient $recipient): string;
}
