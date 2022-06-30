<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;

/**
 * Class RegistrationKeyMakerResponseAssembler
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
final class RegistrationKeyMakerResponseAssembler implements RegistrationKeyMakerResponseAssemblerInterface
{
    /**
     * @param RegistrationKeyMaker $registrationKeyMaker
     * @return RegistrationKeyMakerResponse
     */
    public function assemble(RegistrationKeyMaker $registrationKeyMaker): RegistrationKeyMakerResponse
    {
        return new RegistrationKeyMakerResponse($registrationKeyMaker);
    }
}
