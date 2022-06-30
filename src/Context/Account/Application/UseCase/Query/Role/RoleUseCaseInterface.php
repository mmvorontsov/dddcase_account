<?php

namespace App\Context\Account\Application\UseCase\Query\Role;

/**
 * Interface RoleUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\Role
 */
interface RoleUseCaseInterface
{
    /**
     * @param RoleRequest $request
     * @return RoleResponse
     */
    public function execute(RoleRequest $request): RoleResponse;
}
