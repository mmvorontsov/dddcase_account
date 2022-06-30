<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

/**
 * Interface EnterCredentialRecoveryPasswordUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
interface EnterCredentialRecoveryPasswordUseCaseInterface
{
    /**
     * @param EnterCredentialRecoveryPasswordRequest $request
     * @return EnterCredentialRecoveryPasswordResponse
     */
    public function execute(EnterCredentialRecoveryPasswordRequest $request): EnterCredentialRecoveryPasswordResponse;
}
