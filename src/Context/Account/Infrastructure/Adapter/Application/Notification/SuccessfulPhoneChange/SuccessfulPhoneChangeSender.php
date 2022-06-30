<?php

namespace App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPhoneChange;

use InvalidArgumentException;
use App\Context\Account\Application\Notification\SuccessfulPhoneChange\SuccessfulPhoneChange;
use App\Context\Account\Application\Notification\SuccessfulPhoneChange\SuccessfulPhoneChangeSenderInterface;
use App\Context\Account\Infrastructure\Notification\Recipient\NotificationRecipient;
use App\Context\Account\Infrastructure\Notification\Recipient\SmsNotificationRecipient;

use function sprintf;

/**
 * Class SuccessfulPhoneChangeSender
 * @package App\Context\Account\Infrastructure\Adapter\Application\Notification\SuccessfulPhoneChange
 */
final class SuccessfulPhoneChangeSender implements SuccessfulPhoneChangeSenderInterface
{
    /**
     * @var SuccessfulPhoneChangeSmsSenderInterface
     */
    private SuccessfulPhoneChangeSmsSenderInterface $smsSender;

    /**
     * SuccessfulPhoneChangeSender constructor.
     * @param SuccessfulPhoneChangeSmsSenderInterface $smsSender
     */
    public function __construct(SuccessfulPhoneChangeSmsSenderInterface $smsSender)
    {
        $this->smsSender = $smsSender;
    }

    /**
     * @param SuccessfulPhoneChange $notification
     * @param NotificationRecipient $recipient
     */
    public function send(SuccessfulPhoneChange $notification, NotificationRecipient $recipient): void
    {
        switch (true) {
            case $recipient instanceof SmsNotificationRecipient:
                $this->smsSender->send($notification, $recipient);
                return;
        }

        throw new InvalidArgumentException(
            sprintf('Unsupported notification recipient %s.', $recipient::class),
        );
    }
}
