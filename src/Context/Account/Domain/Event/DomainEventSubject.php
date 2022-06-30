<?php

namespace App\Context\Account\Domain\Event;

use BadMethodCallException;

/**
 * Class DomainEventSubject
 * @package App\Context\Account\Domain\Event
 */
final class DomainEventSubject
{
    /**
     * @var DomainEventSubject|null
     */
    private static ?self $instance = null;

    /**
     * @var DomainEventObserverInterface[]
     */
    private array $observers = [];

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param DomainEventObserverInterface $domainEventObserver
     * @return callable
     */
    public function registerObserver(DomainEventObserverInterface $domainEventObserver): callable
    {
        $alreadyRegistered = false;
        foreach ($this->observers as $observer) {
            if ($observer === $domainEventObserver) {
                $alreadyRegistered = true;
                break;
            }
        }

        if (false === $alreadyRegistered) {
            $this->observers[] = $domainEventObserver;
        }

        return function () use ($domainEventObserver) {
            $this->unregisterObserver($domainEventObserver);
        };
    }

    /**
     * @param DomainEventObserverInterface $domainEventObserver
     */
    public function unregisterObserver(DomainEventObserverInterface $domainEventObserver): void
    {
        foreach ($this->observers as $index => $observer) {
            if ($observer === $domainEventObserver) {
                unset($this->observers[$index]);
            }
        }
    }

    public function unregisterAllObservers(): void
    {
        $this->observers = [];
    }

    /**
     * @param DomainEventInterface $event
     */
    public function notify(DomainEventInterface $event): void
    {
        foreach ($this->observers as $observer) {
            $observer->notify($event);
        }
    }

    public function __clone()
    {
        throw new BadMethodCallException('Clone is not supported.');
    }
}
