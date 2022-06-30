<?php

namespace App\Context\Account\Infrastructure\Messaging\Message;

/**
 * Interface DeprecatedMessageInterface
 * @package App\Context\Account\Infrastructure\Messaging\Message
 */
interface DeprecatedMessageInterface
{
    /**
     * @return string
     */
    public function getDeprecation(): string;
}
