<?php

namespace App\Context\Account\Infrastructure\Messaging\Message\Interservice;

use DateTimeImmutable;

/**
 * Interface InterserviceEventInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message\Interservice
 */
interface InterserviceEventInterface extends InterserviceMessageInterface
{
    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn(): DateTimeImmutable;
}
