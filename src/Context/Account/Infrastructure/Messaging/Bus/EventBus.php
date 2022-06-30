<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;

/**
 * Class EventBus
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
class EventBus implements EventBusInterface
{
    /**
     * @var SymfonyMessageBusInterface
     */
    private SymfonyMessageBusInterface $eventBus; // Bus name - event.bus

    /**
     * EventBus constructor.
     * @param SymfonyMessageBusInterface $eventBus
     */
    public function __construct(SymfonyMessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @inheritdoc
     */
    public function dispatch($message): void
    {
        $this->eventBus->dispatch($message);
    }
}
