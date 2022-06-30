<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceReplyInterface;
use App\Context\Account\Infrastructure\Messaging\Message\RoutableMessageInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;

use function sprintf;

/**
 * Class InterserviceReplyBus
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
class InterserviceReplyBus implements InterserviceReplyBusInterface
{
    /**
     * @var SymfonyMessageBusInterface
     */
    private SymfonyMessageBusInterface $interserviceReplyBus; // Bus name - interservice.reply.bus

    /**
     * InterserviceReplyBus constructor.
     * @param SymfonyMessageBusInterface $interserviceReplyBus
     */
    public function __construct(SymfonyMessageBusInterface $interserviceReplyBus)
    {
        $this->interserviceReplyBus = $interserviceReplyBus;
    }

    /**
     * @inheritdoc
     */
    public function dispatch(InterserviceReplyInterface $message): void
    {
        if ($message instanceof RoutableMessageInterface) {
            $routingKey = sprintf('for:%s|%s', $message->getRecipientContextId(), $message->getRoutingKey());
            $stamps[] = new AmqpStamp($routingKey);
        }

        $this->interserviceReplyBus->dispatch($message, $stamps ?? []);
    }
}
