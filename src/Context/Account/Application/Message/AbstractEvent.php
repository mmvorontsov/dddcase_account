<?php

namespace App\Context\Account\Application\Message;

use DateTimeImmutable;

/**
 * Class AbstractEvent
 * @package App\Context\Account\Application\Message
 */
abstract class AbstractEvent
{
    /**
     * @var string
     */
    protected string $messageId;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $occurredOn;

    /**
     * AbstractEvent constructor.
     * @param string $messageId
     * @param DateTimeImmutable $occurredOn
     */
    public function __construct(string $messageId, DateTimeImmutable $occurredOn)
    {
        $this->messageId = $messageId;
        $this->occurredOn = $occurredOn;
    }

    /**
     * @return string
     */
    public function getMessageId(): string
    {
        return $this->messageId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
