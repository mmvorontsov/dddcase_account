<?php

namespace App\Context\Account\Application\Notification\SuccessfulPhoneChange;

use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Interface SuccessfulPhoneChangeSenderInterface
 * @package App\Context\Account\Application\Notification\SuccessfulPhoneChange
 */
interface SuccessfulPhoneChangeSenderInterface
{
    /**
     * @param SuccessfulPhoneChange $notification
     * @param NotificationRecipient $recipient
     */
    public function send(SuccessfulPhoneChange $notification, NotificationRecipient $recipient): void;
}
