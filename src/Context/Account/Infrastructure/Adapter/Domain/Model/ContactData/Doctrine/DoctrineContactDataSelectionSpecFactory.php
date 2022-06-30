<?php

namespace App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecFactoryInterface;
use App\Context\Account\Domain\Model\ContactData\ContactDataSelectionSpecInterface;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class DoctrineContactDataSelectionSpecFactory
 * @package App\Context\Account\Infrastructure\Adapter\Domain\Model\ContactData\Doctrine
 */
class DoctrineContactDataSelectionSpecFactory implements ContactDataSelectionSpecFactoryInterface
{
    /**
     * @param UserId $userId
     * @return ContactDataSelectionSpecInterface
     */
    public function createBelongsToUserSelectionSpec(UserId $userId): ContactDataSelectionSpecInterface
    {
        return new DoctrineBelongsToUserSelectionSpec($userId);
    }

    /**
     * @param EmailAddress $email
     * @return ContactDataSelectionSpecInterface
     */
    public function createHasEmailSelectionSpec(EmailAddress $email): ContactDataSelectionSpecInterface
    {
        return new DoctrineHasEmailSelectionSpec($email);
    }

    /**
     * @param PhoneNumber $phone
     * @return ContactDataSelectionSpecInterface
     */
    public function createHasPhoneSelectionSpec(PhoneNumber $phone): ContactDataSelectionSpecInterface
    {
        return new DoctrineHasPhoneSelectionSpec($phone);
    }
}
