<?php

namespace App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Interface EnterCredentialRecoveryPasswordServiceInterface
 * @package App\Context\Account\Domain\Service\EnterCredentialRecoveryPassword
 */
interface EnterCredentialRecoveryPasswordServiceInterface
{
    /**
     * @param EnterCredentialRecoveryPasswordCommand $command
     * @return CredentialRecovery
     */
    public function execute(EnterCredentialRecoveryPasswordCommand $command): CredentialRecovery;
}
