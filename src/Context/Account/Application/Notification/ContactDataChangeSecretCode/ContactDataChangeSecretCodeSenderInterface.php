<?php

namespace App\Context\Account\Application\Notification\ContactDataChangeSecretCode;

use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Interface ContactDataChangeSecretCodeSenderInterface
 * @package App\Context\Account\Application\Notification\ContactDataChangeSecretCode
 */
interface ContactDataChangeSecretCodeSenderInterface
{
    /**
     * @param ContactDataChangeSecretCode $notification
     * @param NotificationRecipient $recipient
     */
    public function send(ContactDataChangeSecretCode $notification, NotificationRecipient $recipient): void;
}
