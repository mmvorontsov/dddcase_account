<?php

namespace App\Context\Account\Application\Notification\CredentialRecoverySecretCode;

use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Interface CredentialRecoverySecretCodeSenderInterface
 * @package App\Context\Account\Application\Notification\CredentialRecoverySecretCode
 */
interface CredentialRecoverySecretCodeSenderInterface
{
    /**
     * @param CredentialRecoverySecretCode $notification
     * @param NotificationRecipient $recipient
     */
    public function send(CredentialRecoverySecretCode $notification, NotificationRecipient $recipient): void;
}
