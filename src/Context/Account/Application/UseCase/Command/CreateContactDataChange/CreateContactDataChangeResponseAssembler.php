<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;

/**
 * Class CreateCredentialRecoveryResponseAssembler
 * @package App\Context\Account\Application\UseCase\Command\CreateCredentialRecovery
 */
final class CreateContactDataChangeResponseAssembler implements CreateContactDataChangeResponseAssemblerInterface
{
    /**
     * @param ContactDataChange $contactDataChange
     * @return CreateContactDataChangeResponse
     */
    public function assemble(ContactDataChange $contactDataChange): CreateContactDataChangeResponse
    {
        return new CreateContactDataChangeResponse($contactDataChange);
    }
}
