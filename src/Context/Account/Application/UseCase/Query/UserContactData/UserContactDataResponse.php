<?php

namespace App\Context\Account\Application\UseCase\Query\UserContactData;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactData\ContactDataDto;
use App\Context\Account\Domain\Model\ContactData\ContactData;

/**
 * Class UserContactDataResponse
 * @package App\Context\Account\Application\UseCase\Query\UserContactData
 */
final class UserContactDataResponse
{
    /**
     * @var ContactDataDto
     */
    private ContactDataDto $item;

    /**
     * UserContactDataResponse constructor.
     * @param ContactData $contactData
     */
    public function __construct(ContactData $contactData)
    {
        $this->item = ContactDataDto::createFromContactData($contactData);
    }

    /**
     * @return ContactDataDto
     */
    public function getItem(): ContactDataDto
    {
        return $this->item;
    }
}
