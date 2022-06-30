<?php

namespace App\Context\Account\Domain\Event;

/**
 * Interface DomainEventObserverInterface
 * @package App\Context\Account\Domain\Event
 */
interface DomainEventObserverInterface
{
    /**
     * @param DomainEventInterface $event
     */
    public function notify(DomainEventInterface $event): void;
}
