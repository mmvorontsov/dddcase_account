<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode;

use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\ContactDataChangeSecretCode;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    EmailNotificationRecipient as EmailRecipient,
};

/**
 * Interface ContactDataChangeSecretCodeEmailSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode
 */
interface ContactDataChangeSecretCodeEmailSenderInterface
{
    /**
     * @param ContactDataChangeSecretCode $notification
     * @param EmailRecipient $recipient
     */
    public function send(ContactDataChangeSecretCode $notification, EmailRecipient $recipient): void;

    /**
     * @param ContactDataChangeSecretCode $notification
     * @param EmailRecipient $recipient
     * @return string
     */
    public function renderPreview(ContactDataChangeSecretCode $notification, EmailRecipient $recipient): string;
}
