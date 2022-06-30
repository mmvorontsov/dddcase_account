<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Event;

use App\Context\Account\Domain\Event\DomainEventInterface;
use App\Context\Account\Domain\Event\DomainEventObserverInterface;
use App\Context\Account\Infrastructure\Messaging\Bus\EventBusInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

/**
 * Class DomainEventObserver
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Event
 */
final class DomainEventObserver implements DomainEventObserverInterface
{
    /**
     * @var EventBusInterface
     */
    private EventBusInterface $eventBus;

    /**
     * DomainEventObserver constructor.
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param DomainEventInterface $event
     * @throws Throwable
     */
    public function notify(DomainEventInterface $event): void
    {
        try {
            $this->eventBus->dispatch($event);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}
