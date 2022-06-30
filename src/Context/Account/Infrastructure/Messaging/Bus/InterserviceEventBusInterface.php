<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceEventInterface;

/**
 * Interface InterserviceEventBusInterface
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
interface InterserviceEventBusInterface extends LazyServiceInterface
{
    public const BUS_NAME = 'interservice.event.bus';

    /**
     * @param InterserviceEventInterface $message
     */
    public function dispatch(InterserviceEventInterface $message): void;
}
