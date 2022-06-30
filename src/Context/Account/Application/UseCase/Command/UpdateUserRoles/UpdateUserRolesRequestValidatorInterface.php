<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserRoles;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UpdateUserRolesRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserRoles
 */
interface UpdateUserRolesRequestValidatorInterface
{
    /**
     * @param UpdateUserRolesRequest $request
     * @return ErrorListInterface
     */
    public function validate(UpdateUserRolesRequest $request): ErrorListInterface;
}
