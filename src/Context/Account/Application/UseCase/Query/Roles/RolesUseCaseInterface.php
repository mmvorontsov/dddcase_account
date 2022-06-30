<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

/**
 * Interface RolesUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
interface RolesUseCaseInterface
{
    /**
     * @param RolesRequest $request
     * @return RolesResponse
     */
    public function execute(RolesRequest $request): RolesResponse;
}
