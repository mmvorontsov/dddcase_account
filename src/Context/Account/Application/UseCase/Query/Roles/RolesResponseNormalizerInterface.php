<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

/**
 * Interface RolesResponseNormalizerInterface
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
interface RolesResponseNormalizerInterface
{
    /**
     * @param RolesResponse $response
     * @return array
     */
    public function toArray(RolesResponse $response): array;
}
