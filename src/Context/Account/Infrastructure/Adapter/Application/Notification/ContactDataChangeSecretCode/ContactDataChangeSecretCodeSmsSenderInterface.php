<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode;

use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\ContactDataChangeSecretCode;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    SmsNotificationRecipient as SmsRecipient,
};

/**
 * Interface ContactDataChangeSecretCodeSmsSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode
 */
interface ContactDataChangeSecretCodeSmsSenderInterface
{
    /**
     * @param ContactDataChangeSecretCode $notification
     * @param SmsRecipient $recipient
     */
    public function send(ContactDataChangeSecretCode $notification, SmsRecipient $recipient): void;

    /**
     * @param ContactDataChangeSecretCode $notification
     * @param SmsRecipient $recipient
     * @return string
     */
    public function renderPreview(ContactDataChangeSecretCode $notification, SmsRecipient $recipient): string;
}
