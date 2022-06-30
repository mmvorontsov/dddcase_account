<?php

namespace App\Context\Account\Domain\Service\SignContactDataChange;

use App\Context\Account\Domain\Model\ContactDataChange\ContactDataChange;

/**
 * Class SignContactDataChangeCommand
 * @package App\Context\Account\Domain\Service\SignContactDataChange
 */
final class SignContactDataChangeCommand
{
    /**
     * @var ContactDataChange
     */
    private ContactDataChange $contactDataChange;

    /**
     * @var string
     */
    private string $secretCode;

    /**
     * SignContactDataChangeCommand constructor.
     * @param ContactDataChange $contactDataChange
     * @param string $secretCode
     */
    public function __construct(ContactDataChange $contactDataChange, string $secretCode)
    {
        $this->contactDataChange = $contactDataChange;
        $this->secretCode = $secretCode;
    }

    /**
     * @return ContactDataChange
     */
    public function getContactDataChange(): ContactDataChange
    {
        return $this->contactDataChange;
    }

    /**
     * @return string
     */
    public function getSecretCode(): string
    {
        return $this->secretCode;
    }
}
