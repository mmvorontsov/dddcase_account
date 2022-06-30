<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceCommandInterface;

/**
 * Interface InterserviceCommandBusInterface
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
interface InterserviceCommandBusInterface extends LazyServiceInterface
{
    public const BUS_NAME = 'interservice.command.bus';

    /**
     * @param InterserviceCommandInterface $message
     */
    public function dispatch(InterserviceCommandInterface $message): void;
}
