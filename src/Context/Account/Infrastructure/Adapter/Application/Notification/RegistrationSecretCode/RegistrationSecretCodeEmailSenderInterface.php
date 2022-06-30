<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode;

use App\Context\Account\Application\Notification\RegistrationSecretCode\RegistrationSecretCode;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;

/**
 * Interface RegistrationSecretCodeEmailSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode
 */
interface RegistrationSecretCodeEmailSenderInterface
{
    /**
     * @param RegistrationSecretCode $notification
     * @param EmailNotificationRecipient $recipient
     */
    public function send(RegistrationSecretCode $notification, EmailNotificationRecipient $recipient): void;

    /**
     * @param RegistrationSecretCode $notification
     * @param EmailNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(RegistrationSecretCode $notification, EmailNotificationRecipient $recipient): string;
}
