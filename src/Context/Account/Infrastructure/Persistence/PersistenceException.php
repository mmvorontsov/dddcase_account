<?php

namespace App\Context\Account\Infrastructure\Persistence;

use RuntimeException;
use Throwable;

/**
 * Class PersistenceException
 * @package App\Context\Account\Infrastructure\Persistence
 */
class PersistenceException extends RuntimeException
{
    /**
     * PersistenceException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = 'An persistence error has occurred.', Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
