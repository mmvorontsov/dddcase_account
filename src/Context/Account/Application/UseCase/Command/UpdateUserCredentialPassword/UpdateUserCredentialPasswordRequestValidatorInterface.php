<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UpdateUserCredentialPasswordRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword
 */
interface UpdateUserCredentialPasswordRequestValidatorInterface
{
    /**
     * @param UpdateUserCredentialPasswordRequest $request
     * @return ErrorListInterface
     */
    public function validate(UpdateUserCredentialPasswordRequest $request): ErrorListInterface;
}
