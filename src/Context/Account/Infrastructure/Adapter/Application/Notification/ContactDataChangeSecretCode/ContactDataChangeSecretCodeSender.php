<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode;

use InvalidArgumentException;
use App\Context\Account\Application\Notification\ContactDataChangeSecretCode\{
    ContactDataChangeSecretCode,
    ContactDataChangeSecretCodeSenderInterface,
};
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

use function sprintf;

/**
 * Class ContactDataChangeSecretCodeSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\ContactDataChangeSecretCode
 */
final class ContactDataChangeSecretCodeSender implements ContactDataChangeSecretCodeSenderInterface
{
    /**
     * @var ContactDataChangeSecretCodeEmailSenderInterface
     */
    private ContactDataChangeSecretCodeEmailSenderInterface $emailSender;

    /**
     * @var ContactDataChangeSecretCodeSmsSenderInterface
     */
    private ContactDataChangeSecretCodeSmsSenderInterface $smsSender;

    /**
     * ContactDataChangeSecretCodeSender constructor.
     * @param ContactDataChangeSecretCodeEmailSenderInterface $emailSender
     * @param ContactDataChangeSecretCodeSmsSenderInterface $smsSender
     */
    public function __construct(
        ContactDataChangeSecretCodeEmailSenderInterface $emailSender,
        ContactDataChangeSecretCodeSmsSenderInterface $smsSender,
    ) {
        $this->emailSender = $emailSender;
        $this->smsSender = $smsSender;
    }

    /**
     * @param ContactDataChangeSecretCode $notification
     * @param NotificationRecipient $recipient
     */
    public function send(ContactDataChangeSecretCode $notification, NotificationRecipient $recipient): void
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
