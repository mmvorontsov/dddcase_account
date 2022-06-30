<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

/**
 * Interface UserByCredentialUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 */
interface UserByCredentialUseCaseInterface
{
    /**
     * @param UserByCredentialRequest $request
     * @return UserByCredentialResponse
     */
    public function execute(UserByCredentialRequest $request): UserByCredentialResponse;
}
