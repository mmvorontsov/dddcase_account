<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulEmailChange;

use App\Context\Account\Application\Notification\SuccessfulEmailChange\SuccessfulEmailChange;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;

/**
 * Interface SuccessfulEmailChangeEmailSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulEmailChange
 */
interface SuccessfulEmailChangeEmailSenderInterface
{
    /**
     * @param SuccessfulEmailChange $notification
     * @param EmailNotificationRecipient $recipient
     */
    public function send(SuccessfulEmailChange $notification, EmailNotificationRecipient $recipient): void;

    /**
     * @param SuccessfulEmailChange $notification
     * @param EmailNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulEmailChange $notification, EmailNotificationRecipient $recipient): string;
}
