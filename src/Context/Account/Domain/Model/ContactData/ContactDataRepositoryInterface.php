<?php

namespace App\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Model\SpecInterface;

/**
 * Interface ContactDataRepositoryInterface
 * @package App\Context\Account\Domain\Model\ContactData
 */
interface ContactDataRepositoryInterface
{
    /**
     * @param ContactData $contactData
     */
    public function add(ContactData $contactData): void;

    /**
     * @param ContactDataId $contactDataId
     * @return ContactData|null
     */
    public function findById(ContactDataId $contactDataId): ?ContactData;

    /**
     * @param ContactDataSelectionSpecInterface $spec
     * @return ContactData|null
     */
    public function selectOneSatisfying(ContactDataSelectionSpecInterface $spec): ?ContactData;
}
