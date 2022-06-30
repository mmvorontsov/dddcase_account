<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Class CreateRegistrationSecretCodeResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
final class CreateRegistrationSecretCodeResponseAssembler implements
    CreateRegistrationSecretCodeResponseAssemblerInterface
{
    /**
     * @param SecretCode $secretCode
     * @return CreateRegistrationSecretCodeResponse
     */
    public function assemble(SecretCode $secretCode): CreateRegistrationSecretCodeResponse
    {
        return new CreateRegistrationSecretCodeResponse($secretCode);
    }
}
