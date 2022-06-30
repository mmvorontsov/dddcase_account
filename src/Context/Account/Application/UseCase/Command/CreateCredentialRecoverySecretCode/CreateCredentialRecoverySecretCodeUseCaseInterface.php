<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode\{
    CreateCredentialRecoverySecretCodeRequest as UseCaseRequest,
};

/**
 * Interface CreateCredentialRecoverySecretCodeUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
interface CreateCredentialRecoverySecretCodeUseCaseInterface
{
    /**
     * @param CreateCredentialRecoverySecretCodeRequest $request
     * @return CreateCredentialRecoverySecretCodeResponse
     */
    public function execute(UseCaseRequest $request): CreateCredentialRecoverySecretCodeResponse;
}
