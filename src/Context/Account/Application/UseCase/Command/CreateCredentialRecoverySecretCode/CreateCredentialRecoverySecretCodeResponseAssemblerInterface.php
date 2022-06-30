<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Interface CreateCredentialRecoverySecretCodeResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
interface CreateCredentialRecoverySecretCodeResponseAssemblerInterface
{
    /**
     * @param SecretCode $secretCode
     * @return CreateCredentialRecoverySecretCodeResponse
     */
    public function assemble(SecretCode $secretCode): CreateCredentialRecoverySecretCodeResponse;
}
