<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface ValidatorAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface ValidatorAdditionInterface
{
    /**
     * @param ErrorListInterface $errorList
     */
    public function isEmptyErrorListOrUnprocessableEntity(ErrorListInterface $errorList): void;
}
