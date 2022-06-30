<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface CreateCredentialRecoverySecretCodeRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
interface CreateCredentialRecoverySecretCodeRequestValidatorInterface
{
    /**
     * @param CreateCredentialRecoverySecretCodeRequest $request
     * @return ErrorListInterface
     */
    public function validate(CreateCredentialRecoverySecretCodeRequest $request): ErrorListInterface;
}
