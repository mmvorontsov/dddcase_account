<?php

namespace App\Context\Account\Infrastructure\Messaging\Message\Interservice;

use DateTimeImmutable;

/**
 * Interface InterserviceReplyInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message\Interservice
 */
interface InterserviceReplyInterface extends InterserviceMessageInterface
{
    /**
     * @return InterserviceMessageInterface
     */
    public function getTarget(): InterserviceMessageInterface;

    /**
     * @return string
     */
    public function getRecipientContextId(): string;

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable;
}
