<?php

namespace App\Context\Account\Application\UseCase\Query\UserCredential;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UserCredentialRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\UserCredential
 */
interface UserCredentialRequestValidatorInterface
{
    /**
     * @param UserCredentialRequest $request
     * @return ErrorListInterface
     */
    public function validate(UserCredentialRequest $request): ErrorListInterface;
}
