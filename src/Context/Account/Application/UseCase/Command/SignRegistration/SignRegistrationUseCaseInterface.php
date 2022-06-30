<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

/**
 * Interface SignRegistrationUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
interface SignRegistrationUseCaseInterface
{
    /**
     * @param SignRegistrationRequest $request
     * @return SignRegistrationResponse
     */
    public function execute(SignRegistrationRequest $request): SignRegistrationResponse;
}
