<?php

namespace App\Context\Account\Application\Notification\RegistrationSecretCode;

use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Interface RegistrationSecretCodeSenderInterface
 * @package App\Context\Account\Application\Notification\RegistrationSecretCode
 */
interface RegistrationSecretCodeSenderInterface
{
    /**
     * @param RegistrationSecretCode $notification
     * @param NotificationRecipient $recipient
     */
    public function send(RegistrationSecretCode $notification, NotificationRecipient $recipient): void;
}
