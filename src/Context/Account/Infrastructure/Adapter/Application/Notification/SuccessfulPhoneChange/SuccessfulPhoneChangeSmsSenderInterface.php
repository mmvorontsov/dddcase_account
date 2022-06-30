<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPhoneChange;

use App\Context\Account\Application\Notification\SuccessfulPhoneChange\SuccessfulPhoneChange;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Interface SuccessfulPhoneChangeSmsSenderInterface
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPhoneChange
 */
interface SuccessfulPhoneChangeSmsSenderInterface
{
    /**
     * @param SuccessfulPhoneChange $notification
     * @param SmsNotificationRecipient $recipient
     */
    public function send(SuccessfulPhoneChange $notification, SmsNotificationRecipient $recipient): void;

    /**
     * @param SuccessfulPhoneChange $notification
     * @param SmsNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulPhoneChange $notification, SmsNotificationRecipient $recipient): string;
}
