<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;

/**
 * Class InterserviceEventBus
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
class InterserviceEventBus implements InterserviceEventBusInterface
{
    /**
     * @var SymfonyMessageBusInterface
     */
    private SymfonyMessageBusInterface $interserviceEventBus; // Bus name - interservice.event.bus

    /**
     * InterserviceEventBus constructor.
     * @param SymfonyMessageBusInterface $interserviceEventBus
     */
    public function __construct(SymfonyMessageBusInterface $interserviceEventBus)
    {
        $this->interserviceEventBus = $interserviceEventBus;
    }

    /**
     * @inheritdoc
     */
    public function dispatch(InterserviceEventInterface $message): void
    {
        if ($message instanceof RoutableMessageInterface) {
            $stamps[] = new AmqpStamp($message->getRoutingKey());
        }

        $this->interserviceEventBus->dispatch($message, $stamps ?? []);
    }
}
