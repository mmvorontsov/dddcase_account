<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode;

use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\ContactDataChangeSecretCode;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractEmailSender;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    EmailNotificationRecipient as EmailRecipient,
};
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;

/**
 * Class ContactDataChangeSecretCodeEmailSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode
 */
class ContactDataChangeSecretCodeEmailSender extends AbstractEmailSender implements
    ContactDataChangeSecretCodeEmailSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/email/contact_data_change_secret_code.html.twig';
    private const SUBJECT = 'Your secret code contact email change';

    /**
     * @param ContactDataChangeSecretCode $notification
     * @param EmailRecipient $recipient
     */
    public function send(ContactDataChangeSecretCode $notification, EmailRecipient $recipient): void
    {
        $this->sendEmail($notification, $recipient, self::SUBJECT);
    }

    /**
     * @example /_development/preview/email-preview/contact-data-change-secret-code
     * @param ContactDataChangeSecretCode $notification
     * @param EmailRecipient $recipient
     * @return string
     */
    public function renderPreview(ContactDataChangeSecretCode $notification, EmailRecipient $recipient): string
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
