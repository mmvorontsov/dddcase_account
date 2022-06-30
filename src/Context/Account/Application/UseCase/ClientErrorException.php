<?php

namespace App\Context\Account\Application\UseCase;

use RuntimeException;
use Throwable;

/**
 * Class ClientErrorException
 * @package App\Context\Account\Application\UseCase
 */
class ClientErrorException extends RuntimeException
{
    /**
     * ClientErrorException constructor.
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
