<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUser;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UpdateUserRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUser
 */
interface UpdateUserRequestValidatorInterface
{
    /**
     * @param UpdateUserRequest $request
     * @return ErrorListInterface
     */
    public function validate(UpdateUserRequest $request): ErrorListInterface;
}
