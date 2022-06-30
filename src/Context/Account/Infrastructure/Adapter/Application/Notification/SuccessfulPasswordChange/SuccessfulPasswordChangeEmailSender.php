<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Application\Notification\SuccessfulPasswordChange\{
    SuccessfulPasswordChange,
};
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractEmailSender;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    EmailNotificationRecipient as EmailRecipient,
};

/**
 * Class SuccessfulPasswordChangeEmailSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange
 */
class SuccessfulPasswordChangeEmailSender extends AbstractEmailSender implements
    SuccessfulPasswordChangeEmailSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/email/successful_password_change.html.twig';
    private const SUBJECT = 'Password updated';

    /**
     * @param SuccessfulPasswordChange $notification
     * @param EmailRecipient $recipient
     */
    public function send(SuccessfulPasswordChange $notification, EmailRecipient $recipient): void
    {
        $this->sendEmail($notification, $recipient, self::SUBJECT);
    }

    /**
     * @example /_development/preview/email-preview/successful-password-change
     * @param SuccessfulPasswordChange $notification
     * @param EmailRecipient $recipient
     * @return string
     */
    public function renderPreview(SuccessfulPasswordChange $notification, EmailRecipient $recipient): string
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
