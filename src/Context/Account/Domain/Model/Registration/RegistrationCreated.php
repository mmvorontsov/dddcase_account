<?php

namespace App\Context\Account\Domain\Model\Registration;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;

/**
 * Class RegistrationCreated
 * @package App\Context\Account\Domain\Model\Registration
 */
final class RegistrationCreated extends DomainEvent
{
    /**
     * @var Registration
     */
    private Registration $registration;

    /**
     * RegistrationCreated constructor.
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
