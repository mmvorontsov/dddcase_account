<?php

namespace App\Context\Account\Application\UseCase\Addition;

use App\Context\Account\Domain\Model\ContactData\ContactData;
use App\Context\Account\Domain\Model\ContactData\ContactDataId;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Interface ContactDataAdditionInterface
 * @package App\Context\Account\Application\UseCase\Addition
 */
interface ContactDataAdditionInterface
{
    /**
     * @param ContactDataId $id
     * @return ContactData|null
     */
    public function findById(ContactDataId $id): ?ContactData;

    /**
     * @param ContactDataId $id
     * @param string|null $msg
     * @return ContactData
     */
    public function findByIdOrNotFound(ContactDataId $id, string $msg = null): ContactData;

    /**
     * @param UserId $id
     * @return ContactData|null
     */
    public function findContactDataOfUser(UserId $id): ?ContactData;

    /**
     * @param UserId $id
     * @param string|null $msg
     * @return ContactData
     */
    public function findContactDataOfUserOrNotFound(UserId $id, string $msg = null): ContactData;
}
