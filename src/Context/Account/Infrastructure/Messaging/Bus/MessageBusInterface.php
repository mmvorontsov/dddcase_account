<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

/**
 * Interface MessageBusInterface
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
interface MessageBusInterface
{
    /**
     * @param $message
     */
    public function dispatch($message): void;
}
