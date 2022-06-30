<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulEmailChange;

use App\Context\Account\Application\Notification\SuccessfulEmailChange\SuccessfulEmailChange;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractEmailSender;
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;

/**
 * Class SuccessfulEmailChangeEmailSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulEmailChange
 */
class SuccessfulEmailChangeEmailSender extends AbstractEmailSender implements
    SuccessfulEmailChangeEmailSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/email/successful_email_change.html.twig';
    private const SUBJECT = 'Successful email change';

    /**
     * @param SuccessfulEmailChange $notification
     * @param EmailNotificationRecipient $recipient
     */
    public function send(SuccessfulEmailChange $notification, EmailNotificationRecipient $recipient): void
    {
        $this->sendEmail($notification, $recipient, self::SUBJECT);
    }

    /**
     * @example /_development/preview/email-preview/successful-email-change
     * @param SuccessfulEmailChange $notification
     * @param EmailNotificationRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulEmailChange $notification, EmailNotificationRecipient $recipient): string
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
