<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserRoles;

/**
 * Interface UpdateUserRolesResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserRoles
 */
interface UpdateUserRolesResponseNormalizerInterface
{
    /**
     * @param UpdateUserRolesResponse $response
     * @return array
     */
    public function toArray(UpdateUserRolesResponse $response): array;
}
