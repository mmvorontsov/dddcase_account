<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode;

use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\CredentialRecoverySecretCode;
use App\Context\Account\Infrastructure\Adapter\Application\Notification\AbstractSmsSender;
use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\{
    SmsNotificationRecipient as SmsRecipient,
};

/**
 * Class CredentialRecoverySecretCodeSmsSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode
 */
class CredentialRecoverySecretCodeSmsSender extends AbstractSmsSender implements
    CredentialRecoverySecretCodeSmsSenderInterface,
    LazyServiceInterface
{
    private const TEMPLATE = '@accountTemplate/notification/sms/credential_recovery_secret_code.text.twig';

    /**
     * @param CredentialRecoverySecretCode $notification
     * @param SmsRecipient $recipient
     */
    public function send(CredentialRecoverySecretCode $notification, SmsRecipient $recipient): void
    {
        $this->sendSms($notification, $recipient);
    }

    /**
     * @example /_development/preview/sms-preview/credential-recovery-secret-code
     * @param CredentialRecoverySecretCode $notification
     * @param SmsRecipient $recipient
     * @return string
     */
    public function renderPreview(CredentialRecoverySecretCode $notification, SmsRecipient $recipient): string
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
