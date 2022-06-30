<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Interface CreateRegistrationResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
interface CreateRegistrationResponseAssemblerInterface
{
    /**
     * @param Registration $registration
     * @return CreateRegistrationResponse
     */
    public function assemble(Registration $registration): CreateRegistrationResponse;
}
