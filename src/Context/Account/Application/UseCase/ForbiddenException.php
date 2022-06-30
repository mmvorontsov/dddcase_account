<?php

namespace App\Context\Account\Application\UseCase;

use Throwable;

/**
 * Class ForbiddenException
 * @package App\Context\Account\Application\UseCase
 */
final class ForbiddenException extends ClientErrorException
{
    public const MESSAGE = 'No access rights to perform action.';

    /**
     * ForbiddenException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = self::MESSAGE, Throwable $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}
