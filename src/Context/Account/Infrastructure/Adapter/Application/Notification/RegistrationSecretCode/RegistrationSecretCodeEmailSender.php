<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode;

use App\Context\Account\Application\Notification\RegistrationSecretCode\RegistrationSecretCode;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractEmailSender;
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;

/**
 * Class RegistrationSecretCodeEmailSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode
 */
class RegistrationSecretCodeEmailSender extends AbstractEmailSender implements
    RegistrationSecretCodeEmailSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/email/registration_secret_code.html.twig';
    private const SUBJECT = 'Your secret code for registration';

    /**
     * @param RegistrationSecretCode $notification
     * @param EmailNotificationRecipient $recipient
     */
    public function send(RegistrationSecretCode $notification, EmailNotificationRecipient $recipient): void
    {
        $this->sendEmail($notification, $recipient, self::SUBJECT);
    }

    /**
     * @example /_development/preview/email-preview/registration-secret-code
     * @param RegistrationSecretCode $notification
     * @param EmailNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(RegistrationSecretCode $notification, EmailNotificationRecipient $recipient): string
    {
        return $this->renderEmailPreview($notification, $recipient);
    }

    /**
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return self::TEMPLATE;
    }
}
