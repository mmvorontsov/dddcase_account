<?php

namespace App\Context\Account\Application\UseCase\Query\Role;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface RoleRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\Role
 */
interface RoleRequestValidatorInterface
{
    /**
     * @param RoleRequest $request
     * @return ErrorListInterface
     */
    public function validate(RoleRequest $request): ErrorListInterface;
}
