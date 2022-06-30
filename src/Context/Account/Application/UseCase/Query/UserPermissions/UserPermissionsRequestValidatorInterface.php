<?php

namespace App\Context\Account\Application\UseCase\Query\UserPermissions;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UserRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\User
 */
interface UserPermissionsRequestValidatorInterface
{
    /**
     * @param UserPermissionsRequest $request
     * @return ErrorListInterface
     */
    public function validate(UserPermissionsRequest $request): ErrorListInterface;
}
