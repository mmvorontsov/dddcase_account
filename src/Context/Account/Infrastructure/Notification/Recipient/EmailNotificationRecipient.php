<?php

namespace App\Context\Account\Infrastructure\Notification\Recipient;

/**
 * Class EmailNotificationRecipient
 * @package App\Context\Account\Infrastructure\Notification\Recipient
 */
final class EmailNotificationRecipient extends NotificationRecipient
{
    /**
     * @var string
     */
    private string $email;

    /**
     * EmailNotificationRecipient constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        parent::__construct(NotificationRecipientTypeEnum::EMAIL);
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
