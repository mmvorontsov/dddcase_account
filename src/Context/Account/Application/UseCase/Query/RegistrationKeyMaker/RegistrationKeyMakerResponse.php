<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use App\Context\Account\Application\UseCase\Assembly\Output\Model\KeyMaker\RegistrationKeyMakerDto;
use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;

/**
 * Class RegistrationKeyMakerResponse
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
class RegistrationKeyMakerResponse
{
    /**
     * @var RegistrationKeyMakerDto
     */
    private RegistrationKeyMakerDto $item;

    /**
     * RegistrationKeyMakerResponse constructor.
     * @param RegistrationKeyMaker $keyMaker
     */
    public function __construct(RegistrationKeyMaker $keyMaker)
    {
        $this->item = RegistrationKeyMakerDto::createFromRegistrationKeyMaker($keyMaker);
    }

    /**
     * @return RegistrationKeyMakerDto
     */
    public function getItem(): RegistrationKeyMakerDto
    {
        return $this->item;
    }
}
