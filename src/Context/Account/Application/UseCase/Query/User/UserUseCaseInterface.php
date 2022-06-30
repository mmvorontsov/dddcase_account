<?php

namespace App\Context\Account\Application\UseCase\Query\User;

/**
 * Interface UserUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\User
 */
interface UserUseCaseInterface
{
    /**
     * @param UserRequest $request
     * @return UserResponse
     */
    public function execute(UserRequest $request): UserResponse;
}
