<?php

namespace App\Context\Account\Domain\Service\SignRegistration;

use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Interface SignRegistrationServiceInterface
 * @package App\Context\Account\Domain\Service\SignRegistration
 */
interface SignRegistrationServiceInterface
{
    /**
     * @param SignRegistrationCommand $command
     * @return Registration
     */
    public function execute(SignRegistrationCommand $command): Registration;
}
