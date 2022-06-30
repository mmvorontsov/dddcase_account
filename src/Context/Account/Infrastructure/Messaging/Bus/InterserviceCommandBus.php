<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceCommandInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;

/**
 * Class InterserviceCommandBus
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
class InterserviceCommandBus implements InterserviceCommandBusInterface
{
    /**
     * @var SymfonyMessageBusInterface
     */
    private SymfonyMessageBusInterface $interserviceCommandBus; // Bus name - interservice.command.bus

    /**
     * InterserviceCommandBus constructor.
     * @param SymfonyMessageBusInterface $interserviceCommandBus
     */
    public function __construct(SymfonyMessageBusInterface $interserviceCommandBus)
    {
        $this->interserviceCommandBus = $interserviceCommandBus;
    }

    /**
     * @param InterserviceCommandInterface $message
     */
    public function dispatch(InterserviceCommandInterface $message): void
    {
        if ($message instanceof RoutableMessageInterface) {
            $stamps[] = new AmqpStamp($message->getRoutingKey());
        }

        $this->interserviceCommandBus->dispatch($message, $stamps ?? []);
    }
}
