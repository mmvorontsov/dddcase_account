<?php

namespace App\Context\Account\Infrastructure\Messaging\Message;

/**
 * Interface MessageInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message
 */
interface MessageInterface
{
    /**
     * @return string
     */
    public function getMessageId(): string;
}
