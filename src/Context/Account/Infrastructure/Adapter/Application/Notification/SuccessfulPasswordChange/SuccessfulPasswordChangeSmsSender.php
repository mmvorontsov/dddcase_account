<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Application\Notification\SuccessfulPasswordChange\{
    SuccessfulPasswordChange,
};
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractSmsSender;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Class SuccessfulPasswordChangeSmsSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange
 */
class SuccessfulPasswordChangeSmsSender extends AbstractSmsSender implements
    SuccessfulPasswordChangeSmsSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/sms/successful_password_change.text.twig';

    /**
     * @param SuccessfulPasswordChange $notification
     * @param SmsNotificationRecipient $recipient
     */
    public function send(SuccessfulPasswordChange $notification, SmsNotificationRecipient $recipient): void
    {
        $this->sendSms($notification, $recipient);
    }

    /**
     * @example /_development/preview/sms-preview/successful-password-change
     * @param SuccessfulPasswordChange $notification
     * @param SmsNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulPasswordChange $notification, SmsNotificationRecipient $recipient): string
    {
        return $this->renderSmsPreview($notification, $recipient);
    }

    /**
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return self::TEMPLATE;
    }
}
