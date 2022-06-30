<?php

namespace App\Context\Account\Application\Common\Error;

use ArrayIterator;
use Countable;

/**
 * Interface ErrorListInterface
 * @package App\Context\Account\Application\Common\Error
 */
interface ErrorListInterface extends Countable
{
    /**
     * @param ErrorInterface $error
     */
    public function add(ErrorInterface $error);

    /**
     * @param $offset
     */
    public function remove($offset);

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator;

    /**
     * @return ErrorInterface|null
     */
    public function getFirstError(): ?ErrorInterface;
}
