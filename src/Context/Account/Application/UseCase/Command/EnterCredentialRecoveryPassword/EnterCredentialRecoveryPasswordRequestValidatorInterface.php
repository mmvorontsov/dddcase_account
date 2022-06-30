<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface EnterCredentialRecoveryPasswordRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
interface EnterCredentialRecoveryPasswordRequestValidatorInterface
{
    /**
     * @param EnterCredentialRecoveryPasswordRequest $request
     * @return ErrorListInterface
     */
    public function validate(EnterCredentialRecoveryPasswordRequest $request): ErrorListInterface;
}
