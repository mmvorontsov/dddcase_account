<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode;

use InvalidArgumentException;
use App\Context\Account\Application\Notification\CredentialRecoverySecretCode\{
    CredentialRecoverySecretCode,
    CredentialRecoverySecretCodeSenderInterface,
};
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

use function sprintf;

/**
 * Class CredentialRecoverySecretCodeSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\CredentialRecoverySecretCode
 */
final class CredentialRecoverySecretCodeSender implements CredentialRecoverySecretCodeSenderInterface
{
    /**
     * @var CredentialRecoverySecretCodeEmailSenderInterface
     */
    private CredentialRecoverySecretCodeEmailSenderInterface $emailSender;

    /**
     * @var CredentialRecoverySecretCodeSmsSenderInterface
     */
    private CredentialRecoverySecretCodeSmsSenderInterface $smsSender;

    /**
     * CredentialRecoverySecretCodeSender constructor.
     * @param CredentialRecoverySecretCodeEmailSenderInterface $emailSender
     * @param CredentialRecoverySecretCodeSmsSenderInterface $smsSender
     */
    public function __construct(
        CredentialRecoverySecretCodeEmailSenderInterface $emailSender,
        CredentialRecoverySecretCodeSmsSenderInterface $smsSender,
    ) {
        $this->emailSender = $emailSender;
        $this->smsSender = $smsSender;
    }

    /**
     * @param CredentialRecoverySecretCode $notification
     * @param NotificationRecipient $recipient
     */
    public function send(CredentialRecoverySecretCode $notification, NotificationRecipient $recipient): void
    {
        switch (true) {
            case $recipient instanceof EmailNotificationRecipient:
                $this->emailSender->send($notification, $recipient);
                return;
            case $recipient instanceof SmsNotificationRecipient:
                $this->smsSender->send($notification, $recipient);
                return;
        }

        throw new InvalidArgumentException(
            sprintf('Unsupported notification recipient %s.', $recipient::class),
        );
    }
}
