<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface SignRegistrationRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
interface SignRegistrationRequestValidatorInterface
{
    /**
     * @param SignRegistrationRequest $request
     * @return ErrorListInterface
     */
    public function validate(SignRegistrationRequest $request): ErrorListInterface;
}
