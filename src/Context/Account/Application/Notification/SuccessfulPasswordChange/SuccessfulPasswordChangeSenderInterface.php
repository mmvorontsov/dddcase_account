<?php

namespace App\Context\Account\Application\Notification\SuccessfulPasswordChange;

use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

/**
 * Interface SuccessfulPasswordChangeSenderInterface
 * @package App\Context\Account\Application\Notification\SuccessfulPasswordChange
 */
interface SuccessfulPasswordChangeSenderInterface
{
    /**
     * @param SuccessfulPasswordChange $notification
     * @param NotificationRecipient $recipient
     */
    public function send(SuccessfulPasswordChange $notification, NotificationRecipient $recipient): void;
}
