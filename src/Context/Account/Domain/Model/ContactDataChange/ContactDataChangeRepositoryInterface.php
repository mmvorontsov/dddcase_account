<?php

namespace App\Context\Account\Domain\Model\ContactDataChange;

use App\Context\Account\Domain\Model\SpecInterface;

/**
 * Interface ContactDataChangeRepositoryInterface
 * @package App\Context\Account\Domain\Model\ContactDataChange
 */
interface ContactDataChangeRepositoryInterface
{
    /**
     * @param ContactDataChange $contactDataChange
     */
    public function add(ContactDataChange $contactDataChange): void;

    /**
     * @param ContactDataChange $contactDataChange
     */
    public function remove(ContactDataChange $contactDataChange): void;

    /**
     * @param ContactDataChangeId $contactDataChangeId
     * @return ContactDataChange|null
     */
    public function findById(ContactDataChangeId $contactDataChangeId): ?ContactDataChange;

    /**
     * @param ContactDataChangeSelectionSpecInterface $spec
     * @return ContactDataChange|null
     */
    public function selectOneSatisfying(ContactDataChangeSelectionSpecInterface $spec): ?ContactDataChange;
}
