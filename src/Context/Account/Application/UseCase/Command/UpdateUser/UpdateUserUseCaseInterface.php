<?php

namespace App\Context\Account\Application\UseCase\Command\UpdateUser;

/**
 * Interface CreateUserRegistrationUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateUserRegistration
 */
interface UpdateUserUseCaseInterface
{
    /**
     * @param UpdateUserRequest $request
     * @return UpdateUserResponse
     */
    public function execute(UpdateUserRequest $request): UpdateUserResponse;
}
