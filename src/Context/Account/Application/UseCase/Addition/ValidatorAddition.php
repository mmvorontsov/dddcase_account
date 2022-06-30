<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Application\Common\Error\ErrorListInterface;
use App\Context\Account\Application\UseCase\UnprocessableEntityException;

/**
 * Class ValidatorAddition
 * @package App\Context\Account\Application\UseCase\Addition
 */
class ValidatorAddition implements ValidatorAdditionInterface
{
    /**
     * @param ErrorListInterface $errorList
     */
    public function isEmptyErrorListOrUnprocessableEntity(ErrorListInterface $errorList): void
    {
        if ($errorList->hasErrors()) {
            throw new UnprocessableEntityException($errorList);
        }
    }
}
