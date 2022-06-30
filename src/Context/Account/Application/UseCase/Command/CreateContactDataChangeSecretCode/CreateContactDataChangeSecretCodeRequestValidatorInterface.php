<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface CreateContactDataChangeSecretCodeRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode
 */
interface CreateContactDataChangeSecretCodeRequestValidatorInterface
{
    /**
     * @param CreateContactDataChangeSecretCodeRequest $request
     * @return ErrorListInterface
     */
    public function validate(CreateContactDataChangeSecretCodeRequest $request): ErrorListInterface;
}
