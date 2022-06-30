<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode;

use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\CredentialRecoverySecretCode;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    SmsNotificationRecipient as SmsRecipient,
};

/**
 * Interface CredentialRecoverySecretCodeSmsSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode
 */
interface CredentialRecoverySecretCodeSmsSenderInterface
{
    /**
     * @param CredentialRecoverySecretCode $notification
     * @param SmsRecipient $recipient
     */
    public function send(CredentialRecoverySecretCode $notification, SmsRecipient $recipient): void;

    /**
     * @param CredentialRecoverySecretCode $notification
     * @param SmsRecipient $recipient
     * @return string
     */
    public function renderPreview(CredentialRecoverySecretCode $notification, SmsRecipient $recipient): string;
}
