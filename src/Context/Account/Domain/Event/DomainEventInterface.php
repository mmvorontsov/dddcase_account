<?php

namespace App\Context\Account\Domain\Event;

use DateTimeImmutable;
use App\Context\Account\Domain\Common\Type\Uuid;

/**
 * Interface DomainEventInterface
 * @package App\Context\Account\Domain\Event
 */
interface DomainEventInterface
{
    /**
     * @return Uuid
     */
    public function getEventId(): Uuid;

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn(): DateTimeImmutable;
}
