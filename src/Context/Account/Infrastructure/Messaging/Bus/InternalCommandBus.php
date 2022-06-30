<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use Symfony\Component\Messenger\MessageBusInterface as SymfonyMessageBusInterface;

/**
 * Class InternalCommandBus
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
class InternalCommandBus implements InternalCommandBusInterface
{
    /**
     * @var SymfonyMessageBusInterface
     */
    private SymfonyMessageBusInterface $internalCommandBus; // Bus name - internal.command.bus

    /**
     * InternalEventBus constructor.
     * @param SymfonyMessageBusInterface $internalCommandBus
     */
    public function __construct(SymfonyMessageBusInterface $internalCommandBus)
    {
        $this->internalCommandBus = $internalCommandBus;
    }

    /**
     * @inheritdoc
     */
    public function dispatch(InternalCommandInterface $message): void
    {
        $this->internalCommandBus->dispatch($message, $stamps ?? []);
    }
}
