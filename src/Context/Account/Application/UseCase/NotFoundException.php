<?php

namespace App\Context\Account\Application\UseCase;

use Throwable;

/**
 * Class NotFoundException
 * @package App\Context\Account\Application\UseCase
 */
final class NotFoundException extends ClientErrorException
{
    public const MESSAGE = 'Resource not found';

    /**
     * NotFoundException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = self::MESSAGE, Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
