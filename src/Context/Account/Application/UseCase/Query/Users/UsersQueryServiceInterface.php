<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

use App\Context\Account\Application\Common\Pagination\Pagination;

/**
 * Interface UsersQueryServiceInterface
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
interface UsersQueryServiceInterface
{
    /**
     * @param UsersRequest $request
     * @return Pagination
     */
    public function findUsers(UsersRequest $request): Pagination;
}
