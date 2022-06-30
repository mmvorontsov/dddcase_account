<?php

namespace App\Context\Account\Application\UseCase\Command\SignContactDataChange;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\ContactDataChange\ContactDataChangeDto;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;

/**
 * Class SignContactDataChangeResponse
 * @package App\Context\Account\Application\UseCase\Command\SignContactDataChange
 */
final class SignContactDataChangeResponse
{
    /**
     * @var ContactDataChangeDto
     */
    private ContactDataChangeDto $item;

    /**
     * SignContactDataChangeResponse constructor.
     * @param ContactDataChange $contactDataChange
     */
    public function __construct(ContactDataChange $contactDataChange)
    {
        $this->item = ContactDataChangeDto::createFromContactDataChange($contactDataChange);
    }

    /**
     * @return ContactDataChangeDto
     */
    public function getItem(): ContactDataChangeDto
    {
        return $this->item;
    }
}
