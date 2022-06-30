<?php

namespace App\Context\Account\Infrastructure\Messaging\Message\Internal;

use DateTimeImmutable;

/**
 * Interface InternalCommandInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message\Internal
 */
interface InternalCommandInterface extends InternalMessageInterface
{
    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable;
}
