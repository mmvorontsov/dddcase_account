<?php

namespace App\Context\Account\Domain\Model\ContactData\Update;

use Exception;
use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\ContactData\ContactData;

/**
 * Class ContactDataEmailUpdated
 * @package App\Context\Account\Domain\Model\ContactData\Update
 */
final class ContactDataEmailUpdated extends DomainEvent
{
    /**
     * @var ContactData
     */
    private ContactData $contactData;

    /**
     * @var EmailAddress
     */
    private EmailAddress $fromEmail;

    /**
     * ContactDataEmailUpdated constructor.
     * @param ContactData $contactData
     * @param EmailAddress $fromEmail
     * @throws Exception
     */
    public function __construct(ContactData $contactData, EmailAddress $fromEmail)
    {
        parent::__construct();
        $this->contactData = $contactData;
        $this->fromEmail = $fromEmail;
    }

    /**
     * @return ContactData
     */
    public function getContactData(): ContactData
    {
        return $this->contactData;
    }

    /**
     * @return EmailAddress
     */
    public function getFromEmail(): EmailAddress
    {
        return $this->fromEmail;
    }
}
