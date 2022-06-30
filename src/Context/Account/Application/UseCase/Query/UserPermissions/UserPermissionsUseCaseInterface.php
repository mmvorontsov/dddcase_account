<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

/**
 * Interface UserPermissionsUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\UserPermissions
 */
interface UserPermissionsUseCaseInterface
{
    /**
     * @param UserPermissionsRequest $request
     * @return UserPermissionsResponse
     */
    public function execute(UserPermissionsRequest $request): UserPermissionsResponse;
}
