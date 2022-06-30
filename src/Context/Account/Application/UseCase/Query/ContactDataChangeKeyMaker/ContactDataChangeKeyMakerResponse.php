<?php

namespace App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker\ContactDataChangeKeyMakerDto;
use App\Context\Account\Domain\Model\KeyMaker\ContactDataChangeKeyMaker;

/**
 * Class ContactDataChangeKeyMakerResponse
 * @package App\Context\Account\Application\UseCase\Query\ContactDataChangeKeyMaker
 */
final class ContactDataChangeKeyMakerResponse
{
    /**
     * @var ContactDataChangeKeyMakerDto
     */
    private ContactDataChangeKeyMakerDto $item;

    /**
     * ContactDataChangeKeyMakerResponse constructor.
     * @param ContactDataChangeKeyMaker $keyMaker
     */
    public function __construct(ContactDataChangeKeyMaker $keyMaker)
    {
        $this->item = ContactDataChangeKeyMakerDto::createFromContactDataChangeKeyMaker($keyMaker);
    }

    /**
     * @return ContactDataChangeKeyMakerDto
     */
    public function getItem(): ContactDataChangeKeyMakerDto
    {
        return $this->item;
    }
}
