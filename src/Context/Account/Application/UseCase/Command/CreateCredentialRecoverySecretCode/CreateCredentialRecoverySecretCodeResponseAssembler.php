<?php

namespace App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode;

use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Class CreateCredentialRecoverySecretCodeResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecoverySecretCode
 */
final class CreateCredentialRecoverySecretCodeResponseAssembler implements
    CreateCredentialRecoverySecretCodeResponseAssemblerInterface
{
    /**
     * @param SecretCode $secretCode
     * @return CreateCredentialRecoverySecretCodeResponse
     */
    public function assemble(SecretCode $secretCode): CreateCredentialRecoverySecretCodeResponse
    {
        return new CreateCredentialRecoverySecretCodeResponse($secretCode);
    }
}
