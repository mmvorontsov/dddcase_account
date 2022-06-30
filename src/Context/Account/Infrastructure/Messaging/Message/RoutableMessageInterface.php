<?php

namespace App\Context\Account\Infrastructure\Messaging\Message;

/**
 * Interface RoutableMessageInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message
 */
interface RoutableMessageInterface
{
    /**
     * @return string
     */
    public function getRoutingKey(): string;
}
