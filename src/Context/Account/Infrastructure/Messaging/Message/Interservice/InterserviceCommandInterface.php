<?php

namespace App\Context\Account\Infrastructure\Messaging\Message\Interservice;

use DateTimeImmutable;

/**
 * Interface InterserviceCommandInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message\Interservice
 */
interface InterserviceCommandInterface extends InterserviceMessageInterface
{
    /**
     * @return string
     */
    public function getReplyRecipientContextId(): string;

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable;
}
