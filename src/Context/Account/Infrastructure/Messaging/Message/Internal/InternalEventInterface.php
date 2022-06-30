<?php

namespace App\Context\Account\Infrastructure\Messaging\Message\Internal;

use DateTimeImmutable;

/**
 * Interface InternalEventInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message\Internal
 */
interface InternalEventInterface extends InternalMessageInterface
{
    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn(): DateTimeImmutable;
}
