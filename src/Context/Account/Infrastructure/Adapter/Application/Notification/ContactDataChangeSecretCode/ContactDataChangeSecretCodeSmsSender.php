<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode;

use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\ContactDataChangeSecretCode;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractSmsSender;
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    SmsNotificationRecipient as SmsRecipient,
};

/**
 * Class ContactDataChangeSecretCodeSmsSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode
 */
class ContactDataChangeSecretCodeSmsSender extends AbstractSmsSender implements
    ContactDataChangeSecretCodeSmsSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/sms/contact_data_change_secret_code.text.twig';

    /**
     * @param ContactDataChangeSecretCode $notification
     * @param SmsRecipient $recipient
     */
    public function send(ContactDataChangeSecretCode $notification, SmsRecipient $recipient): void
    {
        $this->sendSms($notification, $recipient);
    }

    /**
     * @example /_development/preview/sms-preview/contact-data-change-secret-code
     * @param ContactDataChangeSecretCode $notification
     * @param SmsRecipient $recipient
     * @return string
     */
    public function renderPreview(ContactDataChangeSecretCode $notification, SmsRecipient $recipient): string
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
