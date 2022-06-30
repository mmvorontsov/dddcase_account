<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Interface CreateCredentialRecoveryResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
interface CreateCredentialRecoveryResponseAssemblerInterface
{
    /**
     * @param CredentialRecovery $credentialRecovery
     * @return CreateCredentialRecoveryResponse
     */
    public function assemble(CredentialRecovery $credentialRecovery): CreateCredentialRecoveryResponse;
}
