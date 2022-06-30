<?php

namespace App\Context\Account\Infrastructure\Messaging\Bus;

use InvalidArgumentException;
use App\Context\Account\Domain\Event\DomainEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalCommandInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Internal\InternalEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceCommandInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceEventInterface;
use App\Context\Account\Infrastructure\Messaging\Message\Interservice\InterserviceReplyInterface;

use function sprintf;

/**
 * Class MessageBus
 * @package App\Context\Account\Infrastructure\Messaging\Bus
 */
final class MessageBus implements MessageBusInterface
{
    /**
     * @var EventBusInterface
     */
    private EventBusInterface $eventBus;

    /**
     * @var InternalCommandBusInterface
     */
    private InternalCommandBusInterface $internalCommandBus;

    /**
     * @var InternalEventBusInterface
     */
    private InternalEventBusInterface $internalEventBus;

    /**
     * @var InterserviceCommandBusInterface
     */
    private InterserviceCommandBusInterface $interserviceCommandBus;

    /**
     * @var InterserviceEventBusInterface
     */
    private InterserviceEventBusInterface $interserviceEventBus;

    /**
     * @var InterserviceReplyBusInterface
     */
    private InterserviceReplyBusInterface $interserviceReplyBus;

    /**
     * MessageBus constructor.
     * @param EventBusInterface $eventBus
     * @param InternalCommandBusInterface $internalCommandBus
     * @param InternalEventBusInterface $internalEventBus
     * @param InterserviceCommandBusInterface $interserviceCommandBus
     * @param InterserviceEventBusInterface $interserviceEventBus
     * @param InterserviceReplyBusInterface $interserviceReplyBus
     */
    public function __construct(
        EventBusInterface $eventBus,
        InternalCommandBusInterface $internalCommandBus,
        InternalEventBusInterface $internalEventBus,
        InterserviceCommandBusInterface $interserviceCommandBus,
        InterserviceEventBusInterface $interserviceEventBus,
        InterserviceReplyBusInterface $interserviceReplyBus
    ) {
        $this->eventBus = $eventBus;
        $this->internalCommandBus = $internalCommandBus;
        $this->internalEventBus = $internalEventBus;
        $this->interserviceCommandBus = $interserviceCommandBus;
        $this->interserviceEventBus = $interserviceEventBus;
        $this->interserviceReplyBus = $interserviceReplyBus;
    }

    /**
     * @inheritdoc
     */
    public function dispatch($message): void
    {
        switch (true) {
            case $message instanceof DomainEventInterface:
                $this->eventBus->dispatch($message);
                return;
            case $message instanceof InternalCommandInterface:
                $this->internalCommandBus->dispatch($message);
                return;
            case $message instanceof InternalEventInterface:
                $this->internalEventBus->dispatch($message);
                return;
            case $message instanceof InterserviceCommandInterface:
                $this->interserviceCommandBus->dispatch($message);
                return;
            case $message instanceof InterserviceEventInterface:
                $this->interserviceEventBus->dispatch($message);
                return;
            case $message instanceof InterserviceReplyInterface:
                $this->interserviceReplyBus->dispatch($message);
                return;
        }

        throw new InvalidArgumentException(
            sprintf('Message bus for message type "%s" not found', $message::class)
        );
    }
}
