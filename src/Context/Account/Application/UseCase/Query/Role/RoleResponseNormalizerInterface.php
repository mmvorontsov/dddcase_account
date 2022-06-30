<?php

namespace App\Context\Account\Application\UseCase\Query\Role;

/**
 * Interface RoleResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\Role
 */
interface RoleResponseNormalizerInterface
{
    /**
     * @param RoleResponse $response
     * @return array
     */
    public function toArray(RoleResponse $response): array;
}
