<?php

namespace App\Context\Account\Infrastructure\Notification\Recipient;

/**
 * Class SmsNotificationRecipient
 * @package App\Context\Account\Infrastructure\Notification\Recipient
 */
final class SmsNotificationRecipient extends NotificationRecipient
{
    /**
     * @var string
     */
    private string $phone;

    /**
     * SmsNotificationRecipient constructor.
     * @param string $phone
     */
    public function __construct(string $phone)
    {
        parent::__construct(NotificationRecipientTypeEnum::SMS);
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
}
