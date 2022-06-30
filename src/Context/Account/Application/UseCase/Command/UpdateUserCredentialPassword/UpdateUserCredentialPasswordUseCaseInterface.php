<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword;

/**
 * Interface UpdateUserCredentialPasswordUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\UpdateUserCredentialPassword
 */
interface UpdateUserCredentialPasswordUseCaseInterface
{
    /**
     * @param UpdateUserCredentialPasswordRequest $request
     * @return UpdateUserCredentialPasswordResponse
     */
    public function execute(UpdateUserCredentialPasswordRequest $request): UpdateUserCredentialPasswordResponse;
}
