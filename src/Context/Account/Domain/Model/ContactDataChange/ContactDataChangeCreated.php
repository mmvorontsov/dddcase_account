<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;

/**
 * Class ContactDataChangeCreated
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
final class ContactDataChangeCreated extends DomainEvent
{
    /**
     * @var ContactDataChange
     */
    private ContactDataChange $contactDataChange;

    /**
     * ContactDataChangeCreated constructor.
     * @param ContactDataChange $contactDataChange
     * @throws Exception
     */
    public function __construct(ContactDataChange $contactDataChange)
    {
        parent::__construct();
        $this->contactDataChange = $contactDataChange;
    }

    /**
     * @return ContactDataChange
     */
    public function getContactDataChange(): ContactDataChange
    {
        return $this->contactDataChange;
    }
}
