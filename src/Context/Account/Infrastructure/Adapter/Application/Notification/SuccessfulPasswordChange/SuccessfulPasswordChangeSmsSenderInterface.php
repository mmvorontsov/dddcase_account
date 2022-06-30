<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange;

use App\Context\Account\Application\Notification\SuccessfulPasswordChange\SuccessfulPasswordChange;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Interface SuccessfulPasswordChangeSmsSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange
 */
interface SuccessfulPasswordChangeSmsSenderInterface
{
    /**
     * @param SuccessfulPasswordChange $notification
     * @param SmsNotificationRecipient $recipient
     */
    public function send(SuccessfulPasswordChange $notification, SmsNotificationRecipient $recipient): void;

    /**
     * @param SuccessfulPasswordChange $notification
     * @param SmsNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulPasswordChange $notification, SmsNotificationRecipient $recipient): string;
}
