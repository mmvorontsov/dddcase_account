<?php

namespace App\Context\Account\Domain;

use Throwable;

/**
 * Class ConsistencyViolationException
 * @package App\Context\Account\Domain
 */
final class ConsistencyViolationException extends DomainException
{
    /**
     * ConsistencyViolationException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = 'An consistency violation has occurred.', Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
