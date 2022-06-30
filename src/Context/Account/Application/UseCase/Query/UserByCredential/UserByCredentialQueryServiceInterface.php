<?php

namespace App\Context\Account\Application\UseCase\Query\UserByCredential;

use App\Context\Account\Domain\Model\User\User;

/**
 * Interface UserByCredentialQueryServiceInterface
 * @package App\Context\Account\Application\UseCase\Query\UserByCredential
 */
interface UserByCredentialQueryServiceInterface
{
    /**
     * @param UserByCredentialRequest $request
     * @return User|null
     */
    public function findUser(UserByCredentialRequest $request): ?User;
}
