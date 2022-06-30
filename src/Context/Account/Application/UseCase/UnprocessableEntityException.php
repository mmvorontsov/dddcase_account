<?php

namespace App\Context\Account\Application\UseCase;

use App\Context\Account\Application\Common\Error\ErrorListInterface;
use Throwable;

/**
 * Class UnprocessableEntityException
 * @package App\Context\Account\Application\UseCase
 */
final class UnprocessableEntityException extends ClientErrorException implements ErrorsAwareExceptionInterface
{
    public const MESSAGE = 'Request data is not valid.';

    /**
     * @var ErrorListInterface
     */
    private ErrorListInterface $errors;

    /**
     * UnprocessableEntityException constructor.
     * @param ErrorListInterface $errors
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(ErrorListInterface $errors, $message = self::MESSAGE, Throwable $previous = null)
    {
        parent::__construct($message, 422, $previous);
        $this->errors = $errors;
    }

    /**
     * @return ErrorListInterface
     */
    public function getErrors(): ErrorListInterface
    {
        return $this->errors;
    }
}
