<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class SignCredentialRecoveryResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
final class SignCredentialRecoveryResponseAssembler implements SignCredentialRecoveryResponseAssemblerInterface
{
    /**
     * @param CredentialRecovery $credentialRecovery
     * @return SignCredentialRecoveryResponse
     */
    public function assemble(CredentialRecovery $credentialRecovery): SignCredentialRecoveryResponse
    {
        return new SignCredentialRecoveryResponse($credentialRecovery);
    }
}
