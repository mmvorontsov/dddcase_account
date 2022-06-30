<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UserByCredentialRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 */
interface UserByCredentialRequestValidatorInterface
{
    /**
     * @param UserByCredentialRequest $request
     * @return ErrorListInterface
     */
    public function validate(UserByCredentialRequest $request): ErrorListInterface;
}
