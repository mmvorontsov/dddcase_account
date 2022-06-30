<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface CreateContactDataChangeRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
interface CreateContactDataChangeRequestValidatorInterface
{
    /**
     * @param CreateContactDataChangeRequest $request
     * @return ErrorListInterface
     */
    public function validate(CreateContactDataChangeRequest $request): ErrorListInterface;
}
