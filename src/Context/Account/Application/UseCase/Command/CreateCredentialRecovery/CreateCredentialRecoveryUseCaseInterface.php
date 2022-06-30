<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

/**
 * Interface CreateCredentialRecoveryUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
interface CreateCredentialRecoveryUseCaseInterface
{
    /**
     * @param CreateCredentialRecoveryRequest $request
     * @return CreateCredentialRecoveryResponse
     */
    public function execute(CreateCredentialRecoveryRequest $request): CreateCredentialRecoveryResponse;
}
