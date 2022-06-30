<?php

namespace App\Context\Account\Domain\Model\ContactDataChange\Sign;

use Exception;
use App\Context\Account\Domain\Event\DomainEvent;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;

/**
 * Class ContactDataChangeSigned
 * @package App\Context\Account\Domain\Model\ContactDataChange\Sign
 */
final class ContactDataChangeSigned extends DomainEvent
{
    /**
     * @var ContactDataChange
     */
    private ContactDataChange $contactDataChange;

    /**
     * ContactDataChangeSigned constructor.
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
