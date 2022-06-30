<?php

namespace App\Context\Account\Application\UseCase\Command\SignRegistration;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\Registration\RegistrationDto;
use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Class SignRegistrationResponse
 * @package App\Context\Account\Application\UseCase\Command\SignRegistration
 */
class SignRegistrationResponse
{
    /**
     * @var RegistrationDto
     */
    private RegistrationDto $item;

    /**
     * SignRegistrationResponse constructor.
     * @param Registration $registration
     */
    public function __construct(Registration $registration)
    {
        $this->item = RegistrationDto::createFromRegistration($registration);
    }

    /**
     * @return RegistrationDto
     */
    public function getItem(): RegistrationDto
    {
        return $this->item;
    }
}
