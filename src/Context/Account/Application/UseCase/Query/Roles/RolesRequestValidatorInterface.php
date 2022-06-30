<?php

namespace App\Context\Account\Application\UseCase\Query\Roles;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface RolesRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\Roles
 */
interface RolesRequestValidatorInterface
{
    /**
     * @param RolesRequest $request
     * @return ErrorListInterface
     */
    public function validate(RolesRequest $request): ErrorListInterface;
}
