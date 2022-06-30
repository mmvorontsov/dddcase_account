<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode;

use InvalidArgumentException;
use App\Context\Account\Application\Notification\RegistrationSecretCode\{
    RegistrationSecretCode,
    RegistrationSecretCodeSenderInterface,
};
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

use function sprintf;

/**
 * Class RegistrationSecretCodeSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\RegistrationSecretCode
 */
final class RegistrationSecretCodeSender implements RegistrationSecretCodeSenderInterface
{
    /**
     * @var RegistrationSecretCodeEmailSenderInterface
     */
    private RegistrationSecretCodeEmailSenderInterface $emailSender;

    /**
     * @var RegistrationSecretCodeSmsSenderInterface
     */
    private RegistrationSecretCodeSmsSenderInterface $smsSender;

    /**
     * RegistrationSecretCodeSender constructor.
     * @param RegistrationSecretCodeEmailSenderInterface $emailSender
     * @param RegistrationSecretCodeSmsSenderInterface $smsSender
     */
    public function __construct(
        RegistrationSecretCodeEmailSenderInterface $emailSender,
        RegistrationSecretCodeSmsSenderInterface $smsSender,
    ) {
        $this->emailSender = $emailSender;
        $this->smsSender = $smsSender;
    }

    /**
     * @param RegistrationSecretCode $notification
     * @param NotificationRecipient $recipient
     */
    public function send(RegistrationSecretCode $notification, NotificationRecipient $recipient): void
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
