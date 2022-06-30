<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface SignCredentialRecoveryRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
interface SignCredentialRecoveryRequestValidatorInterface
{
    /**
     * @param SignCredentialRecoveryRequest $request
     * @return ErrorListInterface
     */
    public function validate(SignCredentialRecoveryRequest $request): ErrorListInterface;
}
