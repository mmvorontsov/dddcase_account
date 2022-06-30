<?php

namespace App\Context\Account\Application\Message;

use DateTimeImmutable;

/**
 * Class AbstractReply
 * @package App\Context\Account\Application\Message
 */
abstract class AbstractReply
{
    /**
     * @var string
     */
    protected string $messageId;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $createdAt;

    /**
     * AbstractReply constructor.
     * @param string $messageId
     * @param DateTimeImmutable $createdAt
     */
    public function __construct(string $messageId, DateTimeImmutable $createdAt)
    {
        $this->messageId = $messageId;
        $this->createdAt = $createdAt;
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
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
