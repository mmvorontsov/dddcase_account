<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Interface EnterCredentialRecoveryPasswordResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
interface EnterCredentialRecoveryPasswordResponseAssemblerInterface
{
    /**
     * @param CredentialRecovery $credentialRecovery
     * @return EnterCredentialRecoveryPasswordResponse
     */
    public function assemble(CredentialRecovery $credentialRecovery): EnterCredentialRecoveryPasswordResponse;
}
