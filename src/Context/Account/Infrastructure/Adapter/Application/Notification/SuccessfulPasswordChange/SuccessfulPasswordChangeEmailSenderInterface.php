<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange;

use App\Context\Account\Application\Notification\SuccessfulPasswordChange\SuccessfulPasswordChange;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    EmailNotificationRecipient as EmailRecipient,
};

/**
 * Interface SuccessfulPasswordChangeEmailSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange
 */
interface SuccessfulPasswordChangeEmailSenderInterface
{
    /**
     * @param SuccessfulPasswordChange $notification
     * @param EmailRecipient $recipient
     */
    public function send(SuccessfulPasswordChange $notification, EmailRecipient $recipient): void;

    /**
     * @param SuccessfulPasswordChange $notification
     * @param EmailRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulPasswordChange $notification, EmailRecipient $recipient): string;
}
