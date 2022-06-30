<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode;

use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\{
    CredentialRecoverySecretCode,
};
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractEmailSender;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    EmailNotificationRecipient as EmailRecipient,
};
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;

/**
 * Class CredentialRecoverySecretCodeEmailSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode
 */
class CredentialRecoverySecretCodeEmailSender extends AbstractEmailSender implements
    CredentialRecoverySecretCodeEmailSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/email/credential_recovery_secret_code.html.twig';
    private const SUBJECT = 'Secret code for credential recovery';

    /**
     * @param CredentialRecoverySecretCode $notification
     * @param EmailRecipient $recipient
     */
    public function send(CredentialRecoverySecretCode $notification, EmailRecipient $recipient): void
    {
        $this->sendEmail($notification, $recipient, self::SUBJECT);
    }

    /**
     * @example /_development/preview/email-preview/credential-recovery-secret-code
     * @param CredentialRecoverySecretCode $notification
     * @param EmailRecipient $recipient
     * @return string
     */
    public function renderPreview(CredentialRecoverySecretCode $notification, EmailRecipient $recipient): string
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
