<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Class SignRegistrationResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
final class SignRegistrationResponseAssembler implements SignRegistrationResponseAssemblerInterface
{
    /**
     * @param Registration $registration
     * @return SignRegistrationResponse
     */
    public function assemble(Registration $registration): SignRegistrationResponse
    {
        return new SignRegistrationResponse($registration);
    }
}
