<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode;

/**
 * Interface CreateRegistrationSecretCodeUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
interface CreateRegistrationSecretCodeUseCaseInterface
{
    /**
     * @param CreateRegistrationSecretCodeRequest $request
     * @return CreateRegistrationSecretCodeResponse
     */
    public function execute(CreateRegistrationSecretCodeRequest $request): CreateRegistrationSecretCodeResponse;
}
