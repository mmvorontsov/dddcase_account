<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface CreateCredentialRecoveryRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
interface CreateCredentialRecoveryRequestValidatorInterface
{
    /**
     * @param CreateCredentialRecoveryRequest $request
     * @return ErrorListInterface
     */
    public function validate(CreateCredentialRecoveryRequest $request): ErrorListInterface;
}
