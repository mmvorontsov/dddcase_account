<?php

namespace App\Context\Account\Domain\Model\Registration;

use App\Context\Account\Domain\Common\Type\EmailAddress;

/**
 * Class PersonalData
 * @package App\Context\Account\Domain\Model\Registration
 */
final class PersonalData
{
    /**
     * @var string
     */
    private string $firstname;

    /**
     * @var string
     */
    private string $hashedPassword;

    /**
     * @var EmailAddress
     */
    private EmailAddress $email;

    /**
     * PersonalData constructor.
     * @param string $firstname
     * @param string $hashedPassword
     * @param EmailAddress $email
     */
    public function __construct(string $firstname, string $hashedPassword, EmailAddress $email)
    {
        $this->firstname = $firstname;
        $this->hashedPassword = $hashedPassword;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    /**
     * @return EmailAddress
     */
    public function getEmail(): EmailAddress
    {
        return $this->email;
    }
}
