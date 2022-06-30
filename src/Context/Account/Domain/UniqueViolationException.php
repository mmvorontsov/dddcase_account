<?php

namespace App\Context\Account\Domain;

use Throwable;

/**
 * Class UniqueViolationException
 * @package App\Context\Account\Domain
 */
final class UniqueViolationException extends DomainException
{
    /**
     * UniqueViolationException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = 'An unique violation has occurred.', Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
