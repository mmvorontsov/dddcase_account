<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Class CreateRegistrationResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
final class CreateRegistrationResponseAssembler implements CreateRegistrationResponseAssemblerInterface
{
    /**
     * @param Registration $registration
     * @return CreateRegistrationResponse
     */
    public function assemble(Registration $registration): CreateRegistrationResponse
    {
        return new CreateRegistrationResponse($registration);
    }
}
