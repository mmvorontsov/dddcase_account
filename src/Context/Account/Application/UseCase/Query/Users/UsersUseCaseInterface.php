<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

/**
 * Interface UsersUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
interface UsersUseCaseInterface
{
    /**
     * @param UsersRequest $request
     * @return UsersResponse
     */
    public function execute(UsersRequest $request): UsersResponse;
}
