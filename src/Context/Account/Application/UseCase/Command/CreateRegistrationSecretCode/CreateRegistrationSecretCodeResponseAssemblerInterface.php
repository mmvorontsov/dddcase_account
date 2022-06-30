<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

use App\Context\Account\Domain\Model\KeyMaker\SecretCode\SecretCode;

/**
 * Interface CreateRegistrationSecretCodeResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
interface CreateRegistrationSecretCodeResponseAssemblerInterface
{
    /**
     * @param SecretCode $secretCode
     * @return CreateRegistrationSecretCodeResponse
     */
    public function assemble(SecretCode $secretCode): CreateRegistrationSecretCodeResponse;
}
