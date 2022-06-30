<?php

namespace App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker;

use App\Context\Account\Application\Common\Error\ErrorListInterface;

/**
 * Interface CredentialRecoveryKeyMakerRequestValidatorInterface
 * @package App\Context\Account\Application\UseCase\Query\CredentialRecoveryKeyMaker
 */
interface CredentialRecoveryKeyMakerRequestValidatorInterface
{
    /**
     * @param CredentialRecoveryKeyMakerRequest $request
     * @return ErrorListInterface
     */
    public function validate(CredentialRecoveryKeyMakerRequest $request): ErrorListInterface;
}
