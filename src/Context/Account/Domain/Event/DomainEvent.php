<?php

namespace App\Context\Account\Domain\Event;

use DateTimeImmutable;
use Exception;
use App\Context\Account\Domain\Common\Type\Uuid;

/**
 * Class DomainEvent
 * @package App\Context\Account\Domain\Event
 */
class DomainEvent implements DomainEventInterface
{
    /**
     * @var Uuid
     */
    protected Uuid $eventId;

    /**
     * @var DateTimeImmutable
     */
    protected DateTimeImmutable $occurredOn;

    /**
     * DomainEvent constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->eventId = Uuid::create();
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return Uuid
     */
    public function getEventId(): Uuid
    {
        return $this->eventId;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
