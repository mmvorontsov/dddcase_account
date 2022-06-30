<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode;

use App\Context\Account\Application\Notification\RegistrationSecretCode\RegistrationSecretCode;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractSmsSender;
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

/**
 * Class RegistrationSecretCodeSmsSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode
 */
class RegistrationSecretCodeSmsSender extends AbstractSmsSender implements
    RegistrationSecretCodeSmsSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/sms/registration_secret_code.text.twig';

    /**
     * @param RegistrationSecretCode $notification
     * @param SmsNotificationRecipient $recipient
     */
    public function send(RegistrationSecretCode $notification, SmsNotificationRecipient $recipient): void
    {
        $this->sendSms($notification, $recipient);
    }

    /**
     * @example /_development/preview/sms-preview/registration-secret-code
     * @param RegistrationSecretCode $notification
     * @param SmsNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(RegistrationSecretCode $notification, SmsNotificationRecipient $recipient): string
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
