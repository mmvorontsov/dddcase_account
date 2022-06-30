<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

/**
 * Interface CreateRegistrationUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
interface CreateRegistrationUseCaseInterface
{
    /**
     * @param CreateRegistrationRequest $request
     * @return CreateRegistrationResponse
     */
    public function execute(CreateRegistrationRequest $request): CreateRegistrationResponse;
}
