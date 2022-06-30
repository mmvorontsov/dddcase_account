<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\DependencyInjection\LazyServiceInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceReplyInterface;

/**
 * Interface InterserviceReplyBusInterface
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
interface InterserviceReplyBusInterface extends LazyServiceInterface
{
    public const BUS_NAME = 'interservice.reply.bus';

    /**
     * @param InterserviceReplyInterface $message
     */
    public function dispatch(InterserviceReplyInterface $message): void;
}
