<?php

namespace App\Context\Account\Domain\Model\KeyMaker;

use App\Context\Account\Domain\Common\Type\EmailAddress;
use App\Context\Account\Domain\Common\Type\PhoneNumber;
use App\Context\Account\Domain\Common\Type\PrimaryContactData;
use App\Context\Account\Domain\DomainException;

/**
 * Class Recipient
 * @package App\Context\Account\Domain\Model\KeyMaker
 */
class Recipient
{
    /**
     * @var EmailAddress|null
     */
    private ?EmailAddress $email;

    /**
     * @var PhoneNumber|null
     */
    private ?PhoneNumber $phone;

    /**
     * Recipient constructor.
     * @param EmailAddress|null $email
     * @param PhoneNumber|null $phone
     */
    public function __construct(?EmailAddress $email, ?PhoneNumber $phone)
    {
        if (null === $email && null === $phone) {
            throw new DomainException('Email or phone must be specified.');
        }

        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * @param PrimaryContactData $primaryContactData
     * @return Recipient
     */
    public static function create(PrimaryContactData $primaryContactData): Recipient
    {
        return new self(
            $primaryContactData->getEmailAddressOrNull(),
            $primaryContactData->getPhoneNumberOrNull(),
        );
    }

    /**
     * @return PrimaryContactData
     */
    public function getPrimaryContactData(): PrimaryContactData
    {
        return $this->email ?? $this->phone;
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
