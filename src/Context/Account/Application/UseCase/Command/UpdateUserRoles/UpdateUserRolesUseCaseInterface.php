<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserRoles;

/**
 * Interface UpdateUserRolesUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserRoles
 */
interface UpdateUserRolesUseCaseInterface
{
    /**
     * @param UpdateUserRolesRequest $request
     * @return UpdateUserRolesResponse
     */
    public function execute(UpdateUserRolesRequest $request): UpdateUserRolesResponse;
}
