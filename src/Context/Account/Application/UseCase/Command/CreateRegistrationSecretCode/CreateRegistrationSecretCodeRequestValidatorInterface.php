<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface CreateRegistrationSecretCodeRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
interface CreateRegistrationSecretCodeRequestValidatorInterface
{
    /**
     * @param CreateRegistrationSecretCodeRequest $request
     * @return ErrorListInterface
     */
    public function validate(CreateRegistrationSecretCodeRequest $request): ErrorListInterface;
}
