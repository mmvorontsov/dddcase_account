<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode;

use App\Context\Account\Application\Notification\RegistrationSecretCode\RegistrationSecretCode;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Interface RegistrationSecretCodeSmsSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode
 */
interface RegistrationSecretCodeSmsSenderInterface
{
    /**
     * @param RegistrationSecretCode $notification
     * @param SmsNotificationRecipient $recipient
     */
    public function send(RegistrationSecretCode $notification, SmsNotificationRecipient $recipient): void;

    /**
     * @param RegistrationSecretCode $notification
     * @param SmsNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(RegistrationSecretCode $notification, SmsNotificationRecipient $recipient): string;
}
