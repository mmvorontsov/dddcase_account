<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Interface SignRegistrationResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
interface SignRegistrationResponseAssemblerInterface
{
    /**
     * @param Registration $registration
     * @return SignRegistrationResponse
     */
    public function assemble(Registration $registration): SignRegistrationResponse;
}
