<?php

namespace App\Context\Account\Application\UseCase\Command\SignCredentialRecovery;

use App\Context\Account\Domain\Model\CredentialRecovery\CredentialRecovery;

/**
 * Interface SignCredentialRecoveryResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\SignCredentialRecovery
 */
interface SignCredentialRecoveryResponseAssemblerInterface
{
    /**
     * @param CredentialRecovery $credentialRecovery
     * @return SignCredentialRecoveryResponse
     */
    public function assemble(CredentialRecovery $credentialRecovery): SignCredentialRecoveryResponse;
}
