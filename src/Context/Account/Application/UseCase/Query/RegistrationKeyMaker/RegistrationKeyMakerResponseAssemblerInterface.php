<?php

namespace App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker;

use App\Context\Account\Domain\Model\KeyMaker\RegistrationKeyMaker;

/**
 * Interface RegistrationKeyMakerResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Query\RegistrationKeyMaker
 */
interface RegistrationKeyMakerResponseAssemblerInterface
{
    /**
     * @param RegistrationKeyMaker $registrationKeyMaker
     * @return RegistrationKeyMakerResponse
     */
    public function assemble(RegistrationKeyMaker $registrationKeyMaker): RegistrationKeyMakerResponse;
}
