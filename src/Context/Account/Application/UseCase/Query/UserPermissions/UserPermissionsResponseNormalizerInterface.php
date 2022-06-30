<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

/**
 * Interface UserPermissionsResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\UserPermissions
 */
interface UserPermissionsResponseNormalizerInterface
{
    /**
     * @param UserPermissionsResponse $response
     * @return array
     */
    public function toArray(UserPermissionsResponse $response): array;
}
