<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;

/**
 * Interface InternalCommandBusInterface
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
interface InternalCommandBusInterface extends LazyServiceInterface
{
    public const BUS_NAME = 'internal.command.bus';

    /**
     * @param InternalCommandInterface $message
     */
    public function dispatch(InternalCommandInterface $message): void;
}
