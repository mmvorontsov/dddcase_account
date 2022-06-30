<?php

namespace App\Context\Account\Application\UseCase\Command\CreateContactDataChange;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;

/**
 * Interface CreateContactDataChangeResponseAssemblerInterface
 * @package App\Context\Account\Application\UseCase\Command\CreateContactDataChange
 */
interface CreateContactDataChangeResponseAssemblerInterface
{
    /**
     * @param ContactDataChange $contactDataChange
     * @return CreateContactDataChangeResponse
     */
    public function assemble(ContactDataChange $contactDataChange): CreateContactDataChangeResponse;
}
