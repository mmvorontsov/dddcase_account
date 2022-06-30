<?php

namespace App\Context\Account\Application\UseCase;

use Throwable;

/**
 * Class BadRequestException
 * @package App\Context\Account\Application\UseCase
 */
class BadRequestException extends ClientErrorException
{
    public const MESSAGE = 'Bad Request';

    /**
     * BadRequestException constructor.
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct($message = self::MESSAGE, Throwable $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }
}
