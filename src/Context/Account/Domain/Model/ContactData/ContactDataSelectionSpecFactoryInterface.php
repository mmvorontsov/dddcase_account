<?php

namespace App\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Interface ContactDataSelectionSpecFactoryInterface
 * @package App\Context\Account\Domain\Model\ContactData
 */
interface ContactDataSelectionSpecFactoryInterface
{
    /**
     * @param UserId $userId
     * @return ContactDataSelectionSpecInterface
     */
    public function createBelongsToUserSelectionSpec(UserId $userId): ContactDataSelectionSpecInterface;

    /**
     * @param EmailAddress $email
     * @return ContactDataSelectionSpecInterface
     */
    public function createHasEmailSelectionSpec(EmailAddress $email): ContactDataSelectionSpecInterface;

    /**
     * @param PhoneNumber $phone
     * @return ContactDataSelectionSpecInterface
     */
    public function createHasPhoneSelectionSpec(PhoneNumber $phone): ContactDataSelectionSpecInterface;
}
