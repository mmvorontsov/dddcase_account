<?php

namespace App\Context\Account\Domain\Model\ContactData;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;

/**
 * Class ContactDataCreated
 * @package App\Context\Account\Domain\Model\ContactData
 */
final class ContactDataCreated extends DomainEvent
{
    /**
     * @var ContactData
     */
    private ContactData $contactData;

    /**
     * ContactDataCreated constructor.
     * @param ContactData $contactData
     * @throws Exception
     */
    public function __construct(ContactData $contactData)
    {
        parent::__construct();
        $this->contactData = $contactData;
    }

    /**
     * @return ContactData
     */
    public function getContactData(): ContactData
    {
        return $this->contactData;
    }
}
