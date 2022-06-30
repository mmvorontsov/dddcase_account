<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventInterface;

/**
 * Interface InternalEventBusInterface
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
interface InternalEventBusInterface extends LazyServiceInterface
{
    public const BUS_NAME = 'internal.event.bus';

    /**
     * @param InternalEventInterface $message
     */
    public function dispatch(InternalEventInterface $message): void;
}
