<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

/**
 * Interface RegistrationKeyMakerUseCaseInterface
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
interface RegistrationKeyMakerUseCaseInterface
{
    /**
     * @param RegistrationKeyMakerRequest $request
     * @return RegistrationKeyMakerResponse
     */
    public function execute(RegistrationKeyMakerRequest $request): RegistrationKeyMakerResponse;
}
