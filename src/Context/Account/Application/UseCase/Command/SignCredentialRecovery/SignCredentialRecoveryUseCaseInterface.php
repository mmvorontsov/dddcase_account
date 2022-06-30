<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

/**
 * Interface SignCredentialRecoveryUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
interface SignCredentialRecoveryUseCaseInterface
{
    /**
     * @param SignCredentialRecoveryRequest $request
     * @return SignCredentialRecoveryResponse
     */
    public function execute(SignCredentialRecoveryRequest $request): SignCredentialRecoveryResponse;
}
