<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventInterface;
use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;

/**
 * Class InternalEventBus
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
class InternalEventBus implements InternalEventBusInterface
{
    /**
     * @var SymfonyMessageBusInterface
     */
    private SymfonyMessageBusInterface $internalEventBus; // Bus name - internal.event.bus

    /**
     * InternalEventBus constructor.
     * @param SymfonyMessageBusInterface $internalEventBus
     */
    public function __construct(SymfonyMessageBusInterface $internalEventBus)
    {
        $this->internalEventBus = $internalEventBus;
    }

    /**
     * @inheritdoc
     */
    public function dispatch(InternalEventInterface $message): void
    {
        $this->internalEventBus->dispatch($message, $stamps ?? []);
    }
}
