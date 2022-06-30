<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulEmailChange;

use InvalidArgumentException;
use App\Context\Account\Application\Notification\SuccessfulEmailChange\SuccessfulEmailChange;
use App\Context\Account\Application\Notification\SuccessfulEmailChange\SuccessfulEmailChangeSenderInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;

use function sprintf;

/**
 * Class SuccessfulEmailChangeSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulEmailChange
 */
final class SuccessfulEmailChangeSender implements SuccessfulEmailChangeSenderInterface
{
    /**
     * @var SuccessfulEmailChangeEmailSenderInterface
     */
    private SuccessfulEmailChangeEmailSenderInterface $emailSender;

    /**
     * SuccessfulEmailChangeSender constructor.
     * @param SuccessfulEmailChangeEmailSenderInterface $emailSender
     */
    public function __construct(SuccessfulEmailChangeEmailSenderInterface $emailSender)
    {
        $this->emailSender = $emailSender;
    }

    /**
     * @param SuccessfulEmailChange $notification
     * @param NotificationRecipient $recipient
     */
    public function send(SuccessfulEmailChange $notification, NotificationRecipient $recipient): void
    {
        switch (true) {
            case $recipient instanceof EmailNotificationRecipient:
                $this->emailSender->send($notification, $recipient);
                return;
        }

        throw new InvalidArgumentException(
            sprintf('Unsupported notification recipient %s.', $recipient::class),
        );
    }
}
