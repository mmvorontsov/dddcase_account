<?php

namespace App\Context\Account\Application\UseCase\Command\SignContactDataChange;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface SignContactDataChangeRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\SignContactDataChange
 */
interface SignContactDataChangeRequestValidatorInterface
{
    /**
     * @param SignContactDataChangeRequest $request
     * @return ErrorListInterface
     */
    public function validate(SignContactDataChangeRequest $request): ErrorListInterface;
}
