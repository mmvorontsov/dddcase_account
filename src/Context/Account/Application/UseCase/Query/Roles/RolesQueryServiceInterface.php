<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

use App\Context\Account\Application\Common\Pagination\Pagination;

/**
 * Interface RolesQueryServiceInterface
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
interface RolesQueryServiceInterface
{
    /**
     * @param RolesRequest $request
     * @return Pagination
     */
    public function findRoles(RolesRequest $request): Pagination;
}
