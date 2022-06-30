<?php

namespace App\Context\Account\Application\UseCase\Query\UserCredential;

/**
 * Interface UserCredentialUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\UserCredential
 */
interface UserCredentialUseCaseInterface
{
    /**
     * @param UserCredentialRequest $request
     * @return UserCredentialResponse
     */
    public function execute(UserCredentialRequest $request): UserCredentialResponse;
}
