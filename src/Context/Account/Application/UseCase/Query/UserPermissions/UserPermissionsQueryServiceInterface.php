<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

use App\Context\Account\Domain\Model\Permission\Permission;

/**
 * Interface UserPermissionsQueryServiceInterface
 * @package App\Context\Account\Application\UseCase\Query\UserPermissions
 */
interface UserPermissionsQueryServiceInterface
{
    /**
     * @param UserPermissionsRequest $request
     * @return Permission[]
     */
    public function findPermissions(UserPermissionsRequest $request): array;
}
