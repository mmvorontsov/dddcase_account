<?php

namespace App\Context\Account\Application\UseCase\Query\User;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UserRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\User
 */
interface UserRequestValidatorInterface
{
    /**
     * @param UserRequest $request
     * @return ErrorListInterface
     */
    public function validate(UserRequest $request): ErrorListInterface;
}
