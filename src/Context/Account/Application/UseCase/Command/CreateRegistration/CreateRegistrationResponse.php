<?php

namespace App\Context\Account\Application\UseCase\Command\CreateRegistration;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\Registration\RegistrationDto;
use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Class CreateRegistrationResponse
 * @package App\Context\Account\Application\UseCase\Command\CreateRegistration
 */
class CreateRegistrationResponse
{
    /**
     * @var RegistrationDto
     */
    private RegistrationDto $item;

    /**
     * CreateRegistrationResponse constructor.
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
