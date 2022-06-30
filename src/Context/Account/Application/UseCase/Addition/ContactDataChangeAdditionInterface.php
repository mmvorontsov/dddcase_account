<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;
use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChangeId;

/**
 * Interface ContactDataChangeAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface ContactDataChangeAdditionInterface
{
    /**
     * @param ContactDataChangeId $id
     * @return ContactDataChange|null
     */
    public function findById(ContactDataChangeId $id): ?ContactDataChange;

    /**
     * @param ContactDataChangeId $id
     * @param string|null $msg
     * @return ContactDataChange
     */
    public function findByIdOrNotFound(ContactDataChangeId $id, string $msg = null): ContactDataChange;
}
