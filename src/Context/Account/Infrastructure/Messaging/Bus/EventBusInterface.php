<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;

/**
 * Interface EventBusInterface
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
interface EventBusInterface extends LazyServiceInterface
{
    public const BUS_NAME = 'event.bus';

    /**
     * @param $message
     */
    public function dispatch($message): void;
}
