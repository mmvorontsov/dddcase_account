<?php

namespace App\Context\Account\Application\Notification\SuccessfulEmailChange;

use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Interface SuccessfulEmailChangeSenderInterface
 * @package App\Context\Account\Application\Notification\SuccessfulEmailChange
 */
interface SuccessfulEmailChangeSenderInterface
{
    /**
     * @param SuccessfulEmailChange $notification
     * @param NotificationRecipient $recipient
     */
    public function send(SuccessfulEmailChange $notification, NotificationRecipient $recipient): void;
}
