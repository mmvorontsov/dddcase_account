<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface CreateRegistrationRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
interface CreateRegistrationRequestValidatorInterface
{
    /**
     * @param CreateRegistrationRequest $request
     * @return ErrorListInterface
     */
    public function validate(CreateRegistrationRequest $request): ErrorListInterface;
}
