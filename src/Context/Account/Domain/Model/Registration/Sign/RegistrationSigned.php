<?php

namespace App\Context\Account\Domain\Model\Registration\Sign;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\Registration\Registration;

/**
 * Class RegistrationSigned
 * @package App\Context\Account\Domain\Model\Registration\Sign
 */
final class RegistrationSigned extends DomainEvent
{
    /**
     * @var Registration
     */
    private Registration $registration;

    /**
     * RegistrationSigned constructor.
     * @param Registration $registration
     * @throws Exception
     */
    public function __construct(Registration $registration)
    {
        parent::__construct();
        $this->registration = $registration;
    }

    /**
     * @return Registration
     */
    public function getRegistration(): Registration
    {
        return $this->registration;
    }
}
