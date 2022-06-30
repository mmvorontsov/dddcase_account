<?php

namespace App\Context\Account\Domain\Model\ContactData\Update;

use Exception;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\ContactData\ContactData;

/**
 * Class ContactDataPhoneUpdated
 * @package App\Context\Account\Domain\Model\ContactData\Update
 */
final class ContactDataPhoneUpdated extends DomainEvent
{
    /**
     * @var ContactData
     */
    private ContactData $contactData;

    /**
     * @var PhoneNumber
     */
    private PhoneNumber $fromPhone;

    /**
     * ContactDataPhoneUpdated constructor.
     * @param ContactData $contactData
     * @param PhoneNumber $fromPhone
     * @throws Exception
     */
    public function __construct(ContactData $contactData, PhoneNumber $fromPhone)
    {
        parent::__construct();
        $this->contactData = $contactData;
        $this->fromPhone = $fromPhone;
    }

    /**
     * @return ContactData
     */
    public function getContactData(): ContactData
    {
        return $this->contactData;
    }

    /**
     * @return PhoneNumber
     */
    public function getFromPhone(): PhoneNumber
    {
        return $this->fromPhone;
    }
}
