<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface RegistrationKeyMakerRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
interface RegistrationKeyMakerRequestValidatorInterface
{
    /**
     * @param RegistrationKeyMakerRequest $request
     * @return ErrorListInterface
     */
    public function validate(RegistrationKeyMakerRequest $request): ErrorListInterface;
}
