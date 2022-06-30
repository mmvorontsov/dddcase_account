<?php

namespace App\Context\Account\Application\UseCase;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface ErrorsAwareExceptionInterface
 * @package App\Context\Account\Application\UseCase
 */
interface ErrorsAwareExceptionInterface
{
    /**
     * @return ErrorListInterface
     */
    public function getErrors(): ErrorListInterface;
}
