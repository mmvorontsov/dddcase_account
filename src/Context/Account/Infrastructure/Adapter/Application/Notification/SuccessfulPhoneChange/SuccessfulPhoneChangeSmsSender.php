<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPhoneChange;

use App\Context\Account\Application\Notification\SuccessfulPhoneChange\SuccessfulPhoneChange;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractSmsSender;
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Class SuccessfulPhoneChangeSmsSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPhoneChange
 */
class SuccessfulPhoneChangeSmsSender extends AbstractSmsSender implements
    SuccessfulPhoneChangeSmsSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/sms/successful_phone_change.text.twig';

    /**
     * @param SuccessfulPhoneChange $notification
     * @param SmsNotificationRecipient $recipient
     */
    public function send(SuccessfulPhoneChange $notification, SmsNotificationRecipient $recipient): void
    {
        $this->sendSms($notification, $recipient);
    }

    /**
     * @example /_development/preview/sms-preview/successful-phone-change
     * @param SuccessfulPhoneChange $notification
     * @param SmsNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulPhoneChange $notification, SmsNotificationRecipient $recipient): string
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
