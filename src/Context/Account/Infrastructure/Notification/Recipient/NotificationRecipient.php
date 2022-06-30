<?php

namespace App\Context\Account\Infrastructure\Notification\Recipient;

/**
 * Class NotificationRecipient
 * @package App\Context\Account\Infrastructure\Notification\Recipient
 */
abstract class NotificationRecipient
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * NotificationRecipient constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
