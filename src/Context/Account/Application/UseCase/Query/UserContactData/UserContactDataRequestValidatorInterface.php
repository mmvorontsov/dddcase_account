<?php

namespace App\Context\Account\Application\UseCase\Query\UserContactData;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface UserContactDataRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\UserContactData
 */
interface UserContactDataRequestValidatorInterface
{
    /**
     * @param UserContactDataRequest $request
     * @return ErrorListInterface
     */
    public function validate(UserContactDataRequest $request): ErrorListInterface;
}
