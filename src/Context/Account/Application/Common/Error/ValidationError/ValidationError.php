<?php

namespace App\Context\Account\Application\Common\Error\ValidationError;

/**
 * Class ValidationError
 * @package App\Context\Account\Application\Common\Error\ValidationError
 */
final class ValidationError implements ValidationErrorInterface
{
    public const CODE = 'VALIDATION_ERROR';

    /**
     * @var string
     */
    private string $code;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $path;

    /**
     * ValidationError constructor.
     * @param string $message
     * @param string $path
     */
    public function __construct(string $message, string $path)
    {
        $this->code = self::CODE;
        $this->message = $message;
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritdoc
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
