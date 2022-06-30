<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode;

use App\Context\Account\Application\UseCase\Command\CreateContactDataChangeSecretCode\{
    CreateContactDataChangeSecretCodeRequest as UseCaseRequest,
    CreateContactDataChangeSecretCodeResponse as UseCaseResponse,
};

/**
 * Interface CreateRegistrationSecretCodeUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistrationSecretCode
 */
interface CreateContactDataChangeSecretCodeUseCaseInterface
{
    /**
     * @param CreateContactDataChangeSecretCodeRequest $request
     * @return CreateContactDataChangeSecretCodeResponse
     */
    public function execute(UseCaseRequest $request): UseCaseResponse;
}
