<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange;

use InvalidArgumentException;
use App\Context\Account\Application\Notification\SuccessfulPasswordChange\{
    SuccessfulPasswordChange,
    SuccessfulPasswordChangeSenderInterface,
};
use App\Context\Account\Infrastructure\Notification\Recipient\EmailNotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

use function sprintf;

/**
 * Class SuccessfulPasswordChangeSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPasswordChange
 */
final class SuccessfulPasswordChangeSender implements SuccessfulPasswordChangeSenderInterface
{
    /**
     * @var SuccessfulPasswordChangeEmailSenderInterface
     */
    private SuccessfulPasswordChangeEmailSenderInterface $emailSender;

    /**
     * @var SuccessfulPasswordChangeSmsSenderInterface
     */
    private SuccessfulPasswordChangeSmsSenderInterface $smsSender;

    /**
     * SuccessfulPasswordChangeSender constructor.
     * @param SuccessfulPasswordChangeEmailSenderInterface $emailSender
     * @param SuccessfulPasswordChangeSmsSenderInterface $smsSender
     */
    public function __construct(
        SuccessfulPasswordChangeEmailSenderInterface $emailSender,
        SuccessfulPasswordChangeSmsSenderInterface $smsSender,
    ) {
        $this->emailSender = $emailSender;
        $this->smsSender = $smsSender;
    }

    /**
     * @param SuccessfulPasswordChange $notification
     * @param NotificationRecipient $recipient
     */
    public function send(SuccessfulPasswordChange $notification, NotificationRecipient $recipient): void
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
