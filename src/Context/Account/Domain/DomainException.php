<?php

namespace App\Context\Account\Domain;

use RuntimeException;
use Throwable;

/**
 * Class DomainException
 * @package App\Context\Account\Domain
 */
class DomainException extends RuntimeException
{
    /**
     * DomainException constructor.
     * @param $message
     * @param Throwable|null $previous
     */
    public function __construct($message = 'An domain error has occurred.', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
