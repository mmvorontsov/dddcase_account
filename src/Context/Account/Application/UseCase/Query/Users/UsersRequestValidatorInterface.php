<?php

namespace App\Context\Account\Application\UseCase\Query\Users;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UsersRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\Users
 */
interface UsersRequestValidatorInterface
{
    /**
     * @param UsersRequest $request
     * @return ErrorListInterface
     */
    public function validate(UsersRequest $request): ErrorListInterface;
}
