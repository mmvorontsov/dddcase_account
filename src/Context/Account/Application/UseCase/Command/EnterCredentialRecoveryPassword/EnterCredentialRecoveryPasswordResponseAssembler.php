<?php

namespace App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class EnterCredentialRecoveryPasswordResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\EnterCredentialRecoveryPassword
 */
final class EnterCredentialRecoveryPasswordResponseAssembler implements
    EnterCredentialRecoveryPasswordResponseAssemblerInterface
{
    /**
     * @param CredentialRecovery $credentialRecovery
     * @return EnterCredentialRecoveryPasswordResponse
     */
    public function assemble(CredentialRecovery $credentialRecovery): EnterCredentialRecoveryPasswordResponse
    {
        return new EnterCredentialRecoveryPasswordResponse($credentialRecovery);
    }
}
