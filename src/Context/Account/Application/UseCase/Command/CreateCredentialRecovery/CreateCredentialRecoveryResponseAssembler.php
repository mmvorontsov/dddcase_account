<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Class CreateCredentialRecoveryResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
final class CreateCredentialRecoveryResponseAssembler implements CreateCredentialRecoveryResponseAssemblerInterface
{
    /**
     * @param CredentialRecovery $credentialRecovery
     * @return CreateCredentialRecoveryResponse
     */
    public function assemble(CredentialRecovery $credentialRecovery): CreateCredentialRecoveryResponse
    {
        return new CreateCredentialRecoveryResponse($credentialRecovery);
    }
}
