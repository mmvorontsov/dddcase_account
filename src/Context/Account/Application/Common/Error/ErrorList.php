<?php

namespace App\Context\Account\Application\Common\Error;

use ArrayIterator;

use function count;

/**
 * Class ViolationList
 * @package App\Context\Account\Infrastructure\Validation
 */
final class ErrorList implements ErrorListInterface
{
    /**
     * @var ErrorInterface[]
     */
    private array $errors = [];

    /**
     * ErrorList constructor.
     * @param array $errors
     */
    public function __construct(array $errors = [])
    {
        foreach ($errors as $error) {
            $this->add($error);
        }
    }

    /**
     * @inheritdoc
     */
    public function add(ErrorInterface $error)
    {
        $this->errors[] = $error;
    }

    /**
     * @inheritdoc
     */
    public function remove($offset)
    {
        unset($this->errors[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return count($this->errors);
    }

    /**
     * @inheritdoc
     */
    public function hasErrors(): bool
    {
        return $this->count() !== 0;
    }

    /**
     * @inheritdoc
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->errors);
    }

    /**
     * @inheritdoc
     */
    public function getFirstError(): ?ErrorInterface
    {
        return $this->errors[0] ?? null;
    }
}
