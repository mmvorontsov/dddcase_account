<?php

namespace App\Context\Account\Domain\Model\ContactData;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Model\User\UserId;

/**
 * Class CreateContactDataCommand
 * @package App\Context\Account\Domain\Model\ContactData
 */
final class CreateContactDataCommand
{
    /**
     * @var UserId
     */
    private UserId $userId;

    /**
     * @var EmailAddress|null
     */
    private ?EmailAddress $email;

    /**
     * @var PhoneNumber|null
     */
    private ?PhoneNumber $phone;

    /**
     * CreateContactDataCommand constructor.
     * @param UserId $userId
     * @param EmailAddress|null $email
     * @param PhoneNumber|null $phone
     */
    public function __construct(UserId $userId, ?EmailAddress $email, ?PhoneNumber $phone)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return EmailAddress|null
     */
    public function getEmail(): ?EmailAddress
    {
        return $this->email;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }
}
